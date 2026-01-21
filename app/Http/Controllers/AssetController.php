<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Specification;
use Exception;
use Idev\EasyAdmin\app\Helpers\Constant;
use Idev\EasyAdmin\app\Helpers\Validation;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;

class AssetController extends DefaultController
{
    protected $modelClass = Asset::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    protected $arrPermissions = ['list', 'show', 'create', 'edit', 'delete', 'export-excel-default', 'export-pdf-default', 'import-excel-default'];
    protected $dynamicPermission = true;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Asset';
        $this->generalUri = 'asset';
        $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true],
                    ['name' => 'Code', 'column' => 'code', 'order' => true],
                    ['name' => 'Category', 'column' => 'category', 'order' => true],
                    ['name' => 'Merk', 'column' => 'merk', 'order' => true],
                    ['name' => 'Model', 'column' => 'model', 'order' => true],
                    ['name' => 'Serial number', 'column' => 'serial_number', 'order' => true],
                    ['name' => 'Year buy', 'column' => 'year_buy', 'order' => true],
                    ['name' => 'Status Device', 'column' => 'is_status', 'order' => true], 
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['code'],
            'headers' => [
                    ['name' => 'Code', 'column' => 'code'],
                    ['name' => 'Category', 'column' => 'category'],
                    ['name' => 'Merk', 'column' => 'merk'],
                    ['name' => 'Model', 'column' => 'model'],
                    ['name' => 'Serial number', 'column' => 'serial_number'],
                    ['name' => 'Year buy', 'column' => 'year_buy'],
                    ['name' => 'Is status', 'column' => 'is_status'], 
            ]
        ];


        $this->importScripts = [
            ['source' => asset('vendor/custom/asset-toggle.js')],
        ];
    }


    protected function fields($mode = "create", $id = '-')
    {
        $edit = null;
        $specifications = [];

        if ($id != '-') {
            $edit = $this->modelClass::where('id', $id)->first();

            // Ambil specifications jika edit mode
            if ($edit) {
                $specs = Specification::where('asset_id', $edit->id)->get();
                foreach ($specs as $spec) {
                    $specifications[$spec->spec_key] = $spec->spec_value;
                }
            }
        }

        $status = [
            ['value' => '', 'text' => '-- Select Status --'],
            ['value' => 'active', 'text' => 'Active'],
            ['value' => 'standby', 'text' => 'Standby'],
            ['value' => 'backup', 'text' => 'Backup'],
        ];

        $category = [
            ['value' => '', 'text' => '-- Select Category --'],
            ['value' => 'Laptop', 'text' => 'Laptop'],
            ['value' => 'PC', 'text' => 'PC'],
            ['value' => 'Accessories', 'text' => 'Accessories'],
        ];

        $years = [
            ['value' => '', 'text' => '-- Select Year --'],
        ];

        for ($year = 1990; $year <= date('Y'); $year++) {
            $years[] = [
                'value' => $year,
                'text'  => (string) $year,
            ];
        }

        $fields = [
                // Asset Fields
                    [
                        'type' => 'text',
                        'label' => 'Code',
                        'name' =>  'code',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('code', $id),
                        'value' => (isset($edit)) ? $edit->code : ''
                    ],
                    [
                        'type' => 'select',
                        'label' => 'Category',
                        'name' =>  'category',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('category', $id),
                        'value' => (isset($edit)) ? $edit->category : '',
                        'options' => $category,
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Merk',
                        'name' =>  'merk',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('merk', $id),
                        'value' => (isset($edit)) ? $edit->merk : '-'
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Model',
                        'name' =>  'model',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('model', $id),
                        'value' => (isset($edit)) ? $edit->model : '-'
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Serial number',
                        'name' =>  'serial_number',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('serial_number', $id),
                        'value' => (isset($edit)) ? $edit->serial_number : '-'
                    ],
                    [
                        'type' => 'select',
                        'label' => 'Year buy',
                        'name' =>  'year_buy',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('year_buy', $id),
                        'value' => (isset($edit)) ? $edit->year_buy : '',
                        'options' => $years,
                    ],
                    [
                        'type' => 'select',
                        'label' => 'Status Device',
                        'name' =>  'is_status',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('is_status', $id),
                        'value' => (isset($edit)) ? $edit->is_status : '',
                        'options' => $status,
                    ],
                    // Specification Fields
                    [
                        'type' => 'text',
                        'label' => 'CPU',
                        'name' =>  'cpu',
                        'class' => 'col-md-12 my-2',
                        'required' => false,
                        'value' => $specifications['cpu'] ?? ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'RAM',
                        'name' =>  'ram',
                        'class' => 'col-md-12 my-2',
                        'required' => false,
                        'value' => $specifications['ram'] ?? ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Storage',
                        'name' =>  'storage',
                        'class' => 'col-md-12 my-2',
                        'required' => false,
                        'value' => $specifications['storage'] ?? ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Operating System',
                        'name' =>  'os',
                        'class' => 'col-md-12 my-2',
                        'required' => false,
                        'value' => $specifications['os'] ?? ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'GPU',
                        'name' =>  'gpu',
                        'class' => 'col-md-12 my-2',
                        'required' => false,
                        'value' => $specifications['gpu'] ?? ''
                    ],
        ];
        
        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [
                    // 'code' => 'required|string',
                    'category' => 'required|string',
                    'merk' => 'required|string',
                    'model' => 'required|string',
                    // 'serial_number' => 'required|string',
                    'year_buy' => 'required|string',
                    'is_status' => 'required|string',
        ];

        return $rules;
    }


    public function store(Request $request)
    {
        $rules = $this->rules();
        
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            $messageErrors = (new Validation)->modify($validator, $rules);
            return response()->json([
                'status' => false,
                'alert' => 'danger',
                'message' => 'Required Form',
                'validation_errors' => $messageErrors,
            ], 200);
        }

        DB::beginTransaction();

        try {
            // Simpan data Asset
            $asset = new Asset();
            $asset->code = $request->code;
            $asset->category = $request->category;
            $asset->merk = $request->merk;
            $asset->model = $request->model;
            $asset->serial_number = $request->serial_number;
            $asset->year_buy = $request->year_buy;
            $asset->is_status = $request->is_status;
            $asset->save();

            // Simpan Specifications
            $specFields = ['cpu', 'ram', 'storage', 'os', 'gpu'];
            
            foreach ($specFields as $field) {
                if ($request->has($field) && !empty($request->$field)) {
                    Specification::create([
                        'asset_id' => $asset->id,
                        'spec_key' => $field,
                        'spec_value' => $request->$field,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'alert' => 'success',
                'message' => 'Asset and Specifications Created Successfully',
                'redirect_to' => route('asset.index'),
            ], 200);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'alert' => 'danger',
                'message' => 'Failed to create asset: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Override update method dengan transaction
    public function update(Request $request, $id)
    {
        $rules = $this->rules($id);
        
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            $messageErrors = (new Validation)->modify($validator, $rules);
            return response()->json([
                'status' => false,
                'alert' => 'danger',
                'message' => 'Required Form',
                'validation_errors' => $messageErrors,
            ], 200);
        }

        DB::beginTransaction();

        try {
            // Update data Asset
            $asset = Asset::findOrFail($id);
            $asset->code = $request->code;
            $asset->category = $request->category;
            $asset->merk = $request->merk;
            $asset->model = $request->model;
            $asset->serial_number = $request->serial_number;
            $asset->year_buy = $request->year_buy;
            $asset->is_status = $request->is_status;
            $asset->save();

            // Update atau Create Specifications (agar ID tidak berubah)
            $specFields = ['cpu', 'ram', 'storage', 'os', 'gpu'];
            
            foreach ($specFields as $field) {
                if ($request->has($field) && !empty($request->$field)) {
                    // Update jika ada, create jika belum ada
                    Specification::updateOrCreate(
                        [
                            'asset_id' => $asset->id,
                            'spec_key' => $field
                        ],
                        [
                            'spec_value' => $request->$field
                        ]
                    );
                } else {
                    // Hapus jika field kosong
                    Specification::where('asset_id', $asset->id)
                        ->where('spec_key', $field)
                        ->delete();
                }
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'alert' => 'success',
                'message' => 'Asset and Specifications Updated Successfully',
                'redirect_to' => route('asset.index'),
            ], 200);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'alert' => 'danger',
                'message' => 'Failed to update asset: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function index()
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
        $layout = (request('from_ajax') && request('from_ajax') == true) ? 'easyadmin::backend.idev.list_drawer_ajax' : 'easyadmin::backend.idev.list_drawer';
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
        
        return view($layout, $data);
    }


    protected function show($id)
    {
        $singleData = $this->defaultDataQuery()->where('id', $id)->first();
        unset($singleData['id']);

        $data['detail'] = $singleData;

        return view('easyadmin::backend.idev.show-default', $data);
    }

}
