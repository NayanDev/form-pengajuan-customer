<?php

namespace App\Http\Controllers;

use App\Models\CategoryMapping;
use App\Models\Location;
use App\Models\Mapping;
use App\Models\MappingStudyReading;
use App\Models\MonitoringReading;
use App\Models\TempMonitoring;
use Idev\EasyAdmin\app\Helpers\Constant;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class MappingController extends DefaultController
{
    protected $modelClass = Mapping::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    protected $arrPermissions = ['list', 'show', 'create', 'edit', 'delete', 'export-excel-default', 'export-pdf-default', 'import-excel-default'];
    protected $dynamicPermission = true;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Mapping';
        $this->generalUri = 'mapping';
        $this->arrPermissions = [];
        $this->actionButtons = ['btn_print', 'btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true],
                    ['name' => 'Warehouse', 'column' => 'warehouse_name', 'order' => true],
                    ['name' => 'Type', 'column' => 'warehouse_type', 'order' => true],
                    ['name' => 'Code', 'column' => 'code', 'order' => true],
                    ['name' => 'Location', 'column' => 'location_name', 'order' => true],
                    ['name' => 'Status', 'column' => 'status', 'order' => true],
                    ['name' => 'Mapping', 'column' => 'mapping_name', 'order' => true],
                    ['name' => 'Year', 'column' => 'year', 'order' => true],
                    ['name' => 'Min', 'column' => 'min', 'order' => true],
                    ['name' => 'Max', 'column' => 'max', 'order' => true],
                    ['name' => 'Avg', 'column' => 'avg', 'order' => true],
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['mapping_study_id'],
            'headers' => [
                    ['name' => 'Mapping study id', 'column' => 'mapping_study_id'],
                    ['name' => 'Location id', 'column' => 'location_id'], 
            ]
        ];

        $this->importStyles = [
            ['source' => asset('custom/css/monitoring-suhu.css')],
        ];
    }


    protected function fields($mode = "create", $id = '-')
    {
        $edit = null;
        if ($id != '-') {
            $edit = $this->modelClass::where('id', $id)->first();
        }

        $mapping_studies = CategoryMapping::select(['id as value', 'name as text'])->get();
        $location = Location::select(['id as value', 'name as text'])->get();

        $fields = [
                    [
                        'type' => 'select',
                        'label' => 'Mapping study id',
                        'name' =>  'mapping_study_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('mapping_study_id', $id),
                        'value' => (isset($edit)) ? $edit->mapping_study_id : '',
                        'options' => $mapping_studies,
                    ],
                    [
                        'type' => 'select',
                        'label' => 'Location id',
                        'name' =>  'location_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('location_id', $id),
                        'value' => (isset($edit)) ? $edit->location_id : '',
                        'options' => $location,
                    ],
        ];
        
        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [
                    'mapping_study_id' => 'required|string',
                    'location_id' => 'required|string',
        ];

        return $rules;
    }


    protected function defaultDataQuery()
    {
        $filters = [];
        $orThose = request('search');
        $orderBy = request('order', 'locations.id');
        $orderState = request('order_state', 'DESC');

        return Mapping::join('mapping_studies', 'mapping_studies.id', '=', 'mapping_study_points.mapping_study_id')
            ->join('locations', 'locations.id', '=', 'mapping_study_points.location_id')
            ->join('warehouses', 'warehouses.id', '=', 'locations.warehouse_id')
            ->leftJoin(
                'mapping_study_readings',
                'mapping_study_readings.mapping_study_point_id',
                '=',
                'mapping_study_points.id'
            )
            ->where($filters)
            ->when($orThose, function ($query) use ($orThose) {
                $query->where(function ($q) use ($orThose) {
                    $q->where('mapping_studies.name', 'LIKE', "%$orThose%")
                    ->orWhere('mapping_studies.year', 'LIKE', "%$orThose%")
                    ->orWhere('locations.code', 'LIKE', "%$orThose%")
                    ->orWhere('locations.name', 'LIKE', "%$orThose%")
                    ->orWhere('locations.status', 'LIKE', "%$orThose%")
                    ->orWhere('warehouses.name', 'LIKE', "%$orThose%")
                    ->orWhere('warehouses.type', 'LIKE', "%$orThose%");
                });
            })
            ->groupBy(
                'mapping_study_points.id',
                'locations.id',
                'locations.code',
                'locations.name',
                'locations.status',
                'mapping_studies.year',
                'mapping_studies.name',
                'warehouses.name',
                'warehouses.type',
                'mapping_study_points.created_at',
                'mapping_study_points.updated_at',
            )
            ->orderBy($orderBy, $orderState)
            ->select(
                'mapping_study_points.id as id',
                'mapping_studies.year as year',
                'mapping_studies.name as mapping_name',

                'locations.id as location_id',
                'locations.code as code',
                'locations.name as location_name',
                'locations.status as status',

                'warehouses.name as warehouse_name',
                'warehouses.type as warehouse_type',

                'mapping_study_points.created_at as created_at',
                'mapping_study_points.updated_at as updated_at',

                DB::raw('ROUND(MIN(mapping_study_readings.value), 2) as min'),
                DB::raw('ROUND(MAX(mapping_study_readings.value), 2) as max'),
                DB::raw('ROUND(AVG(mapping_study_readings.value), 2) as avg')
            );
    }


    protected function indexApi()
    {
        $permission = (new Constant)->permissionByMenu($this->generalUri);
        $permission[] = 'print';

        $eb = [];
        $data_columns = [];
        foreach ($this->tableHeaders as $key => $col) {
            if ($key > 0) {
                $data_columns[] = $col['column'];
            }
        }

        foreach ($this->actionButtons as $key => $ab) {
            if (in_array(str_replace("btn_", "", $ab), $permission)) {
                $eb[] = $ab;
            }
        }

        $dataQueries = $this->defaultDataQuery()->paginate(10);

        $datas['extra_buttons'] = $eb;
        $datas['data_columns'] = $data_columns;
        $datas['data_queries'] = $dataQueries;
        $datas['data_permissions'] = $permission;
        $datas['uri_key'] = $this->generalUri;

        return $datas;
    }


    protected function generatePDF()
    {
        $locationId = request('location_id');
        $month = request('month', now()->month);
        $year = request('year', now()->year);


        // Get location data
        $location = Location::with('warehouse')->findOrFail($locationId);
        
        // Get mapping study point for this location
        $mappingPoint = \App\Models\MappingStudyPoint::where('location_id', $locationId)->first();
        
        if (!$mappingPoint) {
            abort(404, 'Mapping point not found');
        }

        // Get all readings for this month
        $readings = \App\Models\MappingStudyReading::with('user')
            ->where('mapping_study_point_id', $mappingPoint->id)
            ->whereYear('recorded_at', $year)
            ->whereMonth('recorded_at', $month)
            ->get()
            ->groupBy(function($item) {
                return $item->recorded_at->format('Y-m-d H:00:00');
            });

        $data = [
            'title' => $this->title,
            'location' => $location,
            'month' => $month,
            'year' => $year,
            'readings' => $readings,
        ];

        $pdf = PDF::loadView('pdf.monitoring-suhu', $data)
            ->setPaper('A4', 'portrait');

        return $pdf->stream($this->title . '.pdf');
    }


    protected function monitoringSuhu()
    {
        $idMapStudy = request('mapping_study');
        $category = request('category');
        if($category === 'mapping') {
            $mappingStudy = Mapping::findOrfail($idMapStudy);
            $mappingStudyReading = Mapping::where('id', $idMapStudy)->get();

            // Hitung min, max, avg dari mapping study reading
            $readings = MappingStudyReading::whereHas('mappingStudyPoint', function($query) use ($idMapStudy) {
                $query->where('mapping_study_id', $idMapStudy);
            })->pluck('value');

            $minValue = $readings->min();
            $maxValue = $readings->max();
            $avgValue = $readings->avg();

        } elseif($category === 'monitoring') {
            $mappingStudy = TempMonitoring::findOrfail($idMapStudy);
            $mappingStudyReading = TempMonitoring::where('id', $idMapStudy)->first();

            // Hitung min, max, avg dari monitoring reading
            $readings = MonitoringReading::where('monitoring_point_id', $mappingStudyReading->id)
                ->pluck('value');

            $minValue = $readings->min();
            $maxValue = $readings->max();
            $avgValue = $readings->avg();
        }
        

        $baseUrlExcel = route($this->generalUri.'.export-excel-default');
        $baseUrlPdf = route($this->generalUri.'.export-pdf-default');

        $moreActions = [
            [
                'key' => 'import-excel-default',
                'name' => 'Import Excel',
                'html_button' => "<button id='import-excel' type='button' class='btn btn-sm btn-info radius-6' href='#' data-bs-toggle='modal' data-bs-target='#modalImportDefault' title='Import Excel' ><i class='ti ti-upload'></i></button>"
            ],
            [
                'key' => 'export-excel-default',
                'name' => 'Export Excel',
                'html_button' => "<a id='export-excel' data-base-url='".$baseUrlExcel."' class='btn btn-sm btn-success radius-6' target='_blank' href='" . $baseUrlExcel . "'  title='Export Excel'><i class='ti ti-cloud-download'></i></a>"
            ],
            [
                'key' => 'export-pdf-default',
                'name' => 'Export Pdf',
                'html_button' => "<a id='export-pdf' data-base-url='".$baseUrlPdf."' class='btn btn-sm btn-danger radius-6' target='_blank' href='" . $baseUrlPdf . "' title='Export PDF'><i class='ti ti-file'></i></a>"
            ],
        ];

        $permissions =  $this->arrPermissions;
        if ($this->dynamicPermission) {
            $permissions = (new Constant())->permissionByMenu($this->generalUri);
        }
        $layout = (request('from_ajax') && request('from_ajax') == true) ? 'easyadmin::backend.idev.list_drawer_ajax' : 'backend.idev.list_drawer_monitoring_suhu';
        if(isset($this->drawerLayout)){
            $layout = $this->drawerLayout;
        }
        $data['permissions'] = $permissions;
        $data['more_actions'] = $moreActions;
        $data['headerLayout'] = $this->pageHeaderLayout;
        $data['table_headers'] = $this->tableHeaders;
        $data['title'] = $this->title;
        $data['uri_key'] = $this->generalUri;
        $data['uri_list_api'] = route($this->generalUri . '.listapi');
        $data['uri_create'] = route($this->generalUri . '.create');
        $data['url_store'] = route($this->generalUri . '.store');
        $data['fields'] = $this->fields();
        $data['edit_fields'] = $this->fields('edit');
        $data['actionButtonViews'] = $this->actionButtonViews;
        $data['templateImportExcel'] = "#";
        $data['import_scripts'] = $this->importScripts;
        $data['import_styles'] = $this->importStyles;
        $data['filters'] = $this->filters();

        $data['mapping_study'] = $mappingStudy;
        $data['mapping_study_reading'] = $mappingStudyReading;
        $data['min_value'] = $minValue;
        $data['max_value'] = $maxValue;
        $data['avg_value'] = $avgValue;
        
        return view($layout, $data);
    }

}
