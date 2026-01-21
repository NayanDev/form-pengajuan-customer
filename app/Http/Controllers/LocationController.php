<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Warehouse;
use Barryvdh\DomPDF\Facade\Pdf;
use Idev\EasyAdmin\app\Helpers\Constant;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;

class LocationController extends DefaultController
{
    protected $modelClass = Location::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    protected $arrPermissions = ['list', 'show', 'create', 'edit', 'delete', 'export-excel-default', 'export-pdf-default', 'import-excel-default'];
    protected $dynamicPermission = true;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Location';
        $this->generalUri = 'location';
        $this->arrPermissions = [];
        $this->actionButtons = ['btn_qrcode', 'btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true],
                    ['name' => 'Warehouse', 'column' => 'warehouse', 'order' => true],
                    ['name' => 'Code', 'column' => 'code', 'order' => true],
                    ['name' => 'Name', 'column' => 'name', 'order' => true],
                    ['name' => 'Status', 'column' => 'status', 'order' => true], 
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['warehouse_id'],
            'headers' => [
                    ['name' => 'Warehouse id', 'column' => 'warehouse_id'],
                    ['name' => 'Code', 'column' => 'code'],
                    ['name' => 'Name', 'column' => 'name'],
                    ['name' => 'Status', 'column' => 'status'], 
            ]
        ];
    }


    protected function fields($mode = "create", $id = '-')
    {
        $edit = null;
        if ($id != '-') {
            $edit = $this->modelClass::where('id', $id)->first();
        }

        $warehouse = Warehouse::select(['id as value', 'name as text'])->get();
        $code = "LOC-" . strtoupper(substr(uniqid(), -6));
        $fields = [
                    [
                        'type' => 'select',
                        'label' => 'Warehouse',
                        'name' =>  'warehouse_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('warehouse_id', $id),
                        'value' => (isset($edit)) ? $edit->warehouse_id : '',
                        'options' => $warehouse,
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Code',
                        'name' =>  'code',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('code', $id),
                        'value' => (isset($edit)) ? $edit->code : $code,
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Name',
                        'name' =>  'name',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('name', $id),
                        'value' => (isset($edit)) ? $edit->name : ''
                    ],
                    [
                        'type' => 'select',
                        'label' => 'Status',
                        'name' =>  'status',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('status', $id),
                        'value' => (isset($edit)) ? $edit->status : '',
                        'options' => [
                            ['value' => 'mapping', 'text' => 'Mapping'],
                            ['value' => 'monitoring', 'text' => 'Monitoring'],
                            ['value' => 'off', 'text' => 'Off'],
                        ],
                    ],
        ];
        
        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [
                    'warehouse_id' => 'required|string',
                    'code' => 'required|string',
                    'name' => 'required|string',
                    'status' => 'required|string',
        ];

        return $rules;
    }


    protected function defaultDataQuery()
    {
        $filters = [];
        $orThose = null;
        $orderBy = 'id';
        $orderState = 'DESC';
        if (request('search')) {
            $orThose = request('search');
        }
        if (request('order')) {
            $orderBy = request('order');
            $orderState = request('order_state');
        }

        $dataQueries = Location::join('warehouses', 'warehouses.id', '=', 'locations.warehouse_id')
            ->where($filters)
            ->where(function ($query) use ($orThose) {
                $query->where('warehouses.name', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('locations.code', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('locations.name', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('locations.status', 'LIKE', '%' . $orThose . '%');
            })  
            ->orderBy($orderBy, $orderState)
            ->select('locations.*', 'warehouses.name as warehouse');

        return $dataQueries;
    }

    protected function exportPdf()
    {
        $code = request('code');
        if($code){
            $location = Location::with('warehouse')->where('code', $code)->first();
        } else {
            $location = Location::with('warehouse')->get();
        }

        $data = [
            'locations' => $location,
        ];

        $pdf = PDF::loadView('pdf.barcode-location', $data)
            ->setPaper('A4', 'portrait');

        return $pdf->stream("Certification" . ($request->year ?? date('Y')) . ".pdf");
    }

    protected function indexApi()
    {
        $permission = (new Constant)->permissionByMenu($this->generalUri);
        $permission[] = 'qrcode';

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
