<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\DeviceUser;
use Idev\EasyAdmin\app\Helpers\Constant;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;

class DeviceUserController extends DefaultController
{
    protected $modelClass = DeviceUser::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    protected $arrPermissions = ['list', 'show', 'create', 'edit', 'delete', 'export-excel-default', 'export-pdf-default', 'import-excel-default', 'detail'];
    protected $dynamicPermission = true;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Device User';
        $this->generalUri = 'device-user';
        $this->arrPermissions = [];
        $this->actionButtons = ['btn_detail', 'btn_show', 'btn_edit', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true],
                    ['name' => 'Asset', 'column' => 'merk', 'order' => true],
                    ['name' => 'Category', 'column' => 'category', 'order' => true],
                    ['name' => 'Model', 'column' => 'model', 'order' => true],
                    ['name' => 'Employee', 'column' => 'nama', 'order' => true],
                    ['name' => 'Transaction', 'column' => 'assigned_date', 'order' => true], 
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


    protected function defaultDataQuery()
    {
        $filters = [];
        $orThose = null;
        $orderBy = request('order', 'assets.id');
        $orderState = request('order_state', 'DESC');
        if (request('search')) {
            $orThose = request('search');
        }
        if (request('order')) {
            $orderBy = request('order');
            $orderState = request('order_state');
        }
        
        $dataQueries = Asset::query()
        ->leftJoin('device_users', 'device_users.asset_id', '=', 'assets.id')
        ->leftJoin('employees', 'employees.id', '=', 'device_users.employee_id')
        ->leftJoin('transactions', 'transactions.id', '=', 'device_users.transaction_id')
        ->where($filters)
            ->where(function ($query) use ($orThose) {
                $query->where('assets.merk', 'LIKE', '%' . $orThose . '%');
                $query->where('assets.category', 'LIKE', '%' . $orThose . '%');
                $query->where('assets.model', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('employees.nama', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('transactions.assigned_date', 'LIKE', '%' . $orThose . '%');
            });
        $dataQueries = $dataQueries
        ->select('assets.merk as merk', 'employees.nama as nama', 'transactions.assigned_date as assigned_date', ''.'assets.category as category', 'assets.model as model', 'device_users.*')
        ->orderBy($orderBy, $orderState);

        return $dataQueries;
    }


    public function indexApi()
    {
        $permission = (new Constant)->permissionByMenu($this->generalUri);
        $permission[] = 'detail';

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
