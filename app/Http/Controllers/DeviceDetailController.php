<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\DeviceDetail;
use App\Models\Maintenance;
use App\Models\Specification;
use Idev\EasyAdmin\app\Helpers\Constant;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;
use Illuminate\Http\Request;

class DeviceDetailController extends DefaultController
{
    protected $modelClass = DeviceDetail::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Device Detail';
        $this->generalUri = 'device-detail';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true],
                    ['name' => 'Asset id', 'column' => 'asset_id', 'order' => true],
                    ['name' => 'Employee id', 'column' => 'employee_id', 'order' => true],
                    ['name' => 'Transaction id', 'column' => 'transaction_id', 'order' => true], 
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['asset_id'],
            'headers' => [
                    ['name' => 'Asset id', 'column' => 'asset_id'],
                    ['name' => 'Employee id', 'column' => 'employee_id'],
                    ['name' => 'Transaction id', 'column' => 'transaction_id'], 
            ]
        ];


        $this->importScripts = [
            ['source' => asset('vendor/select2/select2.min.js')],
            ['source' => asset('vendor/select2/select2-initialize.js')],
        ];
        $this->importStyles = [
            ['source' => asset('vendor/select2/select2.min.css')],
            ['source' => asset('vendor/select2/select2-style.css')],
            ['source' => asset('custom/css/detail_device.css')],
        ];
    }


    protected function fields($mode = "create", $id = '-')
    {
        $edit = null;
        if ($id != '-') {
            $edit = $this->modelClass::where('id', $id)->first();
        }

        $fields = [
                    [
                        'type' => 'text',
                        'label' => 'Asset id',
                        'name' =>  'asset_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('asset_id', $id),
                        'value' => (isset($edit)) ? $edit->asset_id : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Employee id',
                        'name' =>  'employee_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('employee_id', $id),
                        'value' => (isset($edit)) ? $edit->employee_id : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Transaction id',
                        'name' =>  'transaction_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('transaction_id', $id),
                        'value' => (isset($edit)) ? $edit->transaction_id : ''
                    ],
        ];
        
        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [
                    'asset_id' => 'required|string',
                    'employee_id' => 'required|string',
                    'transaction_id' => 'required|string',
        ];

        return $rules;
    }


    protected function show($id)
    {
        $asset = Asset::where('id', $id)->first();
        $detailDevice = DeviceDetail::where('asset_id', $asset->id)->with([
            'asset.specs', 
            'employee', 
            'asset.transactions' => function ($query) {
                $query->latest();
            },
            'asset.maintenances' => function ($query) {
                $query->latest();
            }
        ])->first();


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
        $layout = (request('from_ajax') && request('from_ajax') == true) ? 'easyadmin::backend.idev.list_drawer_ajax' : 'backend.idev.device_detail';
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

        $data['detail_device'] = $detailDevice;
        
        return view($layout, $data);
    }

    public function storeMaintenance(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'notes' => 'required|string',
            'technicial' => 'required|string|max:255',
            'specification_id' => 'required|string',
            'sparepart_value' => 'nullable|string|max:255',
        ]);

        $sparepartInfo = 'NA';
        
        // Update specification if not NA
        if ($validated['specification_id'] !== 'NA' && !empty($validated['sparepart_value'])) {
            $specification = Specification::find($validated['specification_id']);
            if ($specification) {
                $oldValue = $specification->spec_value;
                $specification->spec_value = $validated['sparepart_value'];
                $specification->save();
                
                $sparepartInfo = $specification->spec_key . ': ' . $oldValue . ' → ' . $validated['sparepart_value'];
            }
        }

        // Create maintenance record
        Maintenance::create([
            'asset_id' => $validated['asset_id'],
            'name' => $validated['name'],
            'date' => $validated['date'],
            'notes' => $validated['notes'],
            'technicial' => $validated['technicial'],
            'sparepart' => $sparepartInfo,
        ]);

        return redirect()->back()->with('success', 'Log maintenance berhasil ditambahkan dan specification telah diupdate!');
    }

}
