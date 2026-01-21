<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Mapping;
use App\Models\TempMonitoring;
use App\Models\MonitoringPoint;
use App\Models\MappingStudyPoint;
use App\Models\MonitoringReading;
use App\Models\MappingStudyReading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Idev\EasyAdmin\app\Helpers\Constant;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;
use Illuminate\Support\Facades\DB;

class TempMonitoringController extends DefaultController
{
    protected $modelClass = TempMonitoring::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    protected $arrPermissions = ['list', 'show', 'create', 'edit', 'delete', 'export-excel-default', 'export-pdf-default', 'import-excel-default'];
    protected $dynamicPermission = true;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Temp Monitoring';
        $this->generalUri = 'temp-monitoring';
        $this->arrPermissions = [];
        $this->actionButtons = ['btn_print', 'btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true],
                    ['name' => 'Warehouse', 'column' => 'warehouse', 'order' => true],
                    ['name' => 'Type', 'column' => 'warehouse_type', 'order' => true],
                    ['name' => 'Location', 'column' => 'location_name', 'order' => true],
                    ['name' => 'Code', 'column' => 'location_code', 'order' => true],
                    ['name' => 'Status', 'column' => 'location_status', 'order' => true],
                    ['name' => 'Description', 'column' => 'description', 'order' => true],
                    ['name' => 'Min', 'column' => 'min', 'order' => true],
                    ['name' => 'Max', 'column' => 'max', 'order' => true],
                    ['name' => 'Avg', 'column' => 'avg', 'order' => true],
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['location_id'],
            'headers' => [
                    ['name' => 'Location id', 'column' => 'location_id'],
                    ['name' => 'Description', 'column' => 'description'], 
            ]
        ];
    }


    protected function fields($mode = "create", $id = '-')
    {
        $edit = null;
        if ($id != '-') {
            $edit = $this->modelClass::where('id', $id)->first();
        }

        $location = Location::select(['id as value', 'name as text'])->get();

        $fields = [
                    [
                        'type' => 'select',
                        'label' => 'Location',
                        'name' =>  'location_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('location_id', $id),
                        'value' => (isset($edit)) ? $edit->location_id : '',
                        'options' => $location,
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Description',
                        'name' =>  'description',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('description', $id),
                        'value' => (isset($edit)) ? $edit->description : ''
                    ],
        ];
        
        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [
                    'location_id' => 'required|string',
                    'description' => 'required|string',
        ];

        return $rules;
    }


    


    protected function ScannerTemperature()
    {
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
        $layout = (request('from_ajax') && request('from_ajax') == true) ? 'easyadmin::backend.idev.list_drawer_ajax' : 'backend.idev.scanner-temperature';
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

        // $data['detail_device'] = $detailDevice;
        
        return view($layout, $data);
    }

    public function getPointDetails(Request $request)
    {
        $code = $request->input('code');

        try {
            // Find location by code first
            $location = Location::where('code', $code)
                ->where('status', 'mapping')
                ->orWhere('status', 'monitoring')
                ->first();
            
            if (!$location) {
                return response()->json([
                    'success' => false,
                    'message' => 'Location dengan code ' . $code . ' tidak ditemukan atau tidak aktif'
                ], 404);
            }

            // Try to find monitoring point first
            $monitoringPoint = MonitoringPoint::where('location_id', $location->id)
            ->whereHas('location', function ($query) {
                $query->where('status', 'monitoring');
            })
            ->with('location')
            ->first();
                
            if ($monitoringPoint) {
                // Get recent readings from this specific point
                $recentReadings = MonitoringReading::where('monitoring_point_id', $monitoringPoint->id)
                    ->with('user')
                    ->orderBy('recorded_at', 'DESC')
                    ->limit(5)
                    ->get()
                    ->map(function($reading) {
                        return [
                            'recorded_at' => $reading->recorded_at->format('d M Y, H:i'),
                            'value' => $reading->value,
                            'user_name' => $reading->user->name ?? 'Unknown'
                        ];
                    });

                // Check today's readings by time range FOR THIS LOCATION (all points)
                $today = date('Y-m-d');
                
                // Get all monitoring points for this location
                $monitoringPointIds = MonitoringPoint::where('location_id', $location->id)->pluck('id');
                // Get all mapping points for this location
                $mappingPointIds = MappingStudyPoint::where('location_id', $location->id)->pluck('id');
                
                // Get all readings from monitoring points at this location today
                $monitoringReadingsToday = MonitoringReading::whereIn('monitoring_point_id', $monitoringPointIds)
                    ->whereDate('recorded_at', $today)
                    ->get();
                    
                // Get all readings from mapping points at this location today
                $mappingReadingsToday = MappingStudyReading::whereIn('mapping_study_point_id', $mappingPointIds)
                    ->whereDate('recorded_at', $today)
                    ->get();

                $timeRangeStatus = [
                    'pagi' => null,
                    'siang' => null,
                    'sore' => null
                ];

                // Check monitoring readings
                foreach ($monitoringReadingsToday as $reading) {
                    $hour = (int) $reading->recorded_at->format('H');
                    if ($hour >= 0 && $hour < 12 && !$timeRangeStatus['pagi']) {
                        $timeRangeStatus['pagi'] = $reading->recorded_at->format('H:i');
                    } elseif ($hour >= 12 && $hour < 15 && !$timeRangeStatus['siang']) {
                        $timeRangeStatus['siang'] = $reading->recorded_at->format('H:i');
                    } elseif ($hour >= 15 && !$timeRangeStatus['sore']) {
                        $timeRangeStatus['sore'] = $reading->recorded_at->format('H:i');
                    }
                }
                
                // Check mapping readings
                foreach ($mappingReadingsToday as $reading) {
                    $hour = (int) $reading->recorded_at->format('H');
                    if ($hour >= 0 && $hour < 12 && !$timeRangeStatus['pagi']) {
                        $timeRangeStatus['pagi'] = $reading->recorded_at->format('H:i');
                    } elseif ($hour >= 12 && $hour < 15 && !$timeRangeStatus['siang']) {
                        $timeRangeStatus['siang'] = $reading->recorded_at->format('H:i');
                    } elseif ($hour >= 15 && !$timeRangeStatus['sore']) {
                        $timeRangeStatus['sore'] = $reading->recorded_at->format('H:i');
                    }
                }

                return response()->json([
                    'success' => true,
                    'data' => [
                        'id' => $monitoringPoint->id,
                        'type' => 'monitoring',
                        'location' => $location->name ?? '-',
                        'location_id' => $location->id,
                        'description' => $monitoringPoint->description ?? '-',
                        'recent_readings' => $recentReadings,
                        'today_status' => $timeRangeStatus
                    ]
                ]);
            }

            // If not found in monitoring, try mapping study point
            $mappingPoint = MappingStudyPoint::where('location_id', $location->id)
                ->whereHas('location', function ($query) {
                        $query->where('status', 'mapping');
                    })
                ->with('location')
                ->first();
                
            if ($mappingPoint) {
                // Get recent readings from this specific point
                $recentReadings = MappingStudyReading::where('mapping_study_point_id', $mappingPoint->id)
                    ->with('user')
                    ->orderBy('recorded_at', 'DESC')
                    ->limit(5)
                    ->get()
                    ->map(function($reading) {
                        return [
                            'recorded_at' => $reading->recorded_at->format('d M Y, H:i'),
                            'value' => $reading->value,
                            'user_name' => $reading->user->name ?? 'Unknown'
                        ];
                    });

                // Check today's readings by time range FOR THIS LOCATION (all points)
                $today = date('Y-m-d');
                
                // Get all monitoring points for this location
                $monitoringPointIds = MonitoringPoint::where('location_id', $location->id)->pluck('id');
                // Get all mapping points for this location
                $mappingPointIds = MappingStudyPoint::where('location_id', $location->id)->pluck('id');
                
                // Get all readings from monitoring points at this location today
                $monitoringReadingsToday = MonitoringReading::whereIn('monitoring_point_id', $monitoringPointIds)
                    ->whereDate('recorded_at', $today)
                    ->get();
                    
                // Get all readings from mapping points at this location today
                $mappingReadingsToday = MappingStudyReading::whereIn('mapping_study_point_id', $mappingPointIds)
                    ->whereDate('recorded_at', $today)
                    ->get();

                $timeRangeStatus = [
                    'pagi' => null,
                    'siang' => null,
                    'sore' => null
                ];

                // Check monitoring readings
                foreach ($monitoringReadingsToday as $reading) {
                    $hour = (int) $reading->recorded_at->format('H');
                    if ($hour >= 0 && $hour < 12 && !$timeRangeStatus['pagi']) {
                        $timeRangeStatus['pagi'] = $reading->recorded_at->format('H:i');
                    } elseif ($hour >= 12 && $hour < 15 && !$timeRangeStatus['siang']) {
                        $timeRangeStatus['siang'] = $reading->recorded_at->format('H:i');
                    } elseif ($hour >= 15 && !$timeRangeStatus['sore']) {
                        $timeRangeStatus['sore'] = $reading->recorded_at->format('H:i');
                    }
                }
                
                // Check mapping readings
                foreach ($mappingReadingsToday as $reading) {
                    $hour = (int) $reading->recorded_at->format('H');
                    if ($hour >= 0 && $hour < 12 && !$timeRangeStatus['pagi']) {
                        $timeRangeStatus['pagi'] = $reading->recorded_at->format('H:i');
                    } elseif ($hour >= 12 && $hour < 15 && !$timeRangeStatus['siang']) {
                        $timeRangeStatus['siang'] = $reading->recorded_at->format('H:i');
                    } elseif ($hour >= 15 && !$timeRangeStatus['sore']) {
                        $timeRangeStatus['sore'] = $reading->recorded_at->format('H:i');
                    }
                }

                return response()->json([
                    'success' => true,
                    'data' => [
                        'id' => $mappingPoint->id,
                        'type' => 'mapping',
                        'location' => $location->name ?? '-',
                        'location_id' => $location->id,
                        'description' => 'Mapping Study Point',
                        'recent_readings' => $recentReadings,
                        'today_status' => $timeRangeStatus
                    ]
                ]);
            }

            // If no point found for this location
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada monitoring atau mapping point untuk location: ' . $location->name
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function storeTemperature(Request $request)
    {
        $request->validate([
            'point_type' => 'required|in:monitoring,mapping',
            'point_id' => 'required|integer',
            'value' => 'required|numeric',
            'recorded_at' => 'required|date'
        ]);

        try {
            $type = $request->input('point_type');
            $pointId = $request->input('point_id');
            $value = $request->input('value');
            $recordedAt = $request->input('recorded_at');
            $recordedDate = date('Y-m-d', strtotime($recordedAt));
            $recordedHour = date('H', strtotime($recordedAt));

            // Determine time range
            if ($recordedHour >= 0 && $recordedHour < 12) {
                $timeRange = 'pagi';
                $timeRangeLabel = '00:00 - 11:59';
                $startTime = $recordedDate . ' 00:00:00';
                $endTime = $recordedDate . ' 11:59:59';
            } elseif ($recordedHour >= 12 && $recordedHour < 15) {
                $timeRange = 'siang';
                $timeRangeLabel = '12:00 - 14:59';
                $startTime = $recordedDate . ' 12:00:00';
                $endTime = $recordedDate . ' 14:59:59';
            } else {
                $timeRange = 'sore';
                $timeRangeLabel = '15:00 - 23:59';
                $startTime = $recordedDate . ' 15:00:00';
                $endTime = $recordedDate . ' 23:59:59';
            }

            // Get location_id from point
            $locationId = null;
            
            if ($type === 'monitoring') {
                // Verify monitoring point exists
                $point = MonitoringPoint::find($pointId);
                if (!$point) {
                    return redirect()->back()->withErrors(['error' => 'Monitoring point tidak ditemukan']);
                }
                $locationId = $point->location_id;

            } elseif ($type === 'mapping') {
                // Verify mapping study point exists
                $point = MappingStudyPoint::find($pointId);
                if (!$point) {
                    return redirect()->back()->withErrors(['error' => 'Mapping study point tidak ditemukan']);
                }
                $locationId = $point->location_id;
            }

            // Check if data already exists in this time range today FOR THIS LOCATION
            // Get all monitoring points for this location
            $monitoringPointIds = MonitoringPoint::where('location_id', $locationId)->pluck('id');
            // Get all mapping points for this location
            $mappingPointIds = MappingStudyPoint::where('location_id', $locationId)->pluck('id');
            
            // Check monitoring readings at this location in this time range
            $existingMonitoringReading = MonitoringReading::whereIn('monitoring_point_id', $monitoringPointIds)
                ->whereBetween('recorded_at', [$startTime, $endTime])
                ->first();

            if ($existingMonitoringReading) {
                return redirect()->back()->withErrors([
                    'error' => 'Data untuk lokasi ini sudah pernah ditambahkan untuk rentang waktu ' . $timeRangeLabel . ' hari ini. Waktu sebelumnya: ' . $existingMonitoringReading->recorded_at->format('d M Y H:i')
                ]);
            }
            
            // Check mapping readings at this location in this time range
            $existingMappingReading = MappingStudyReading::whereIn('mapping_study_point_id', $mappingPointIds)
                ->whereBetween('recorded_at', [$startTime, $endTime])
                ->first();

            if ($existingMappingReading) {
                return redirect()->back()->withErrors([
                    'error' => 'Data untuk lokasi ini sudah pernah ditambahkan untuk rentang waktu ' . $timeRangeLabel . ' hari ini. Waktu sebelumnya: ' . $existingMappingReading->recorded_at->format('d M Y H:i')
                ]);
            }

            // Save the reading
            if ($type === 'monitoring') {
                MonitoringReading::create([
                    'monitoring_point_id' => $pointId,
                    'value' => $value,
                    'recorded_at' => $recordedAt,
                    'user_id' => Auth::id()
                ]);
            } elseif ($type === 'mapping') {
                MappingStudyReading::create([
                    'mapping_study_point_id' => $pointId,
                    'value' => $value,
                    'recorded_at' => $recordedAt,
                    'user_id' => Auth::id()
                ]);
            }

            return redirect()->route('scanner-temperature')
                ->with('success', 'Temperature reading berhasil disimpan!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }
    }


    protected function defaultDataQuery()
    {
        $filters = [];
        $orThose = request('search');
        $orderBy = request('order', 'monitoring_points.id');
        $orderState = request('order_state', 'DESC');

        return TempMonitoring::join('locations', 'locations.id', '=', 'monitoring_points.location_id')
            ->join('warehouses', 'warehouses.id', '=', 'locations.warehouse_id')
            ->leftJoin(
                'monitoring_readings',
                'monitoring_readings.monitoring_point_id',
                '=',
                'monitoring_points.id'
            )
            ->where($filters)
            ->when($orThose, function ($query) use ($orThose) {
                $query->where(function ($q) use ($orThose) {
                    $q->where('warehouses.name', 'LIKE', "%$orThose%")
                    ->orWhere('warehouses.type', 'LIKE', "%$orThose%")
                    ->orWhere('locations.code', 'LIKE', "%$orThose%")
                    ->orWhere('locations.name', 'LIKE', "%$orThose%")
                    ->orWhere('locations.status', 'LIKE', "%$orThose%")
                    ->orWhere('monitoring_points.description', 'LIKE', "%$orThose%");
                });
            })
            ->groupBy(
                'monitoring_points.id',
                'monitoring_points.location_id',
                'monitoring_points.description',
                'monitoring_points.created_at',
                'monitoring_points.updated_at',
                'locations.id',
                'locations.code',
                'locations.name',
                'locations.status',
                'warehouses.name',
                'warehouses.type'
            )
            ->orderBy($orderBy, $orderState)
            ->select(
                'monitoring_points.id as id',
                'monitoring_points.description as description',
                'monitoring_points.created_at as created_at',
                'monitoring_points.updated_at as updated_at',
                
                'locations.id as location_id',
                'locations.code as location_code',
                'locations.name as location_name',
                'locations.status as location_status',
                
                'warehouses.name as warehouse',
                'warehouses.type as warehouse_type',
                
                DB::raw('ROUND(MIN(monitoring_readings.value), 2) as min'),
                DB::raw('ROUND(MAX(monitoring_readings.value), 2) as max'),
                DB::raw('ROUND(AVG(monitoring_readings.value), 2) as avg')
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


}
