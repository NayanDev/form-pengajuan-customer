<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\DeviceUser;
use App\Models\Employee;
use App\Models\Transaction;
use Exception;
use Idev\EasyAdmin\app\Helpers\Validation;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends DefaultController
{
    protected $modelClass = Transaction::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Transaction';
        $this->generalUri = 'transaction';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true],
                    ['name' => 'Nama', 'column' => 'nama', 'order' => true],
                    ['name' => 'Nik', 'column' => 'nik', 'order' => true],
                    ['name' => 'Asset', 'column' => 'data_asset', 'order' => true],
                    ['name' => 'Assigned date', 'column' => 'assigned_date', 'order' => true],
                    ['name' => 'Return date', 'column' => 'return_date', 'order' => true],
                    ['name' => 'Notes', 'column' => 'notes', 'order' => true],
                    ['name' => 'Is active', 'column' => 'is_active', 'order' => true], 
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['nik'],
            'headers' => [
                    ['name' => 'Nik', 'column' => 'nik'],
                    ['name' => 'Asset id', 'column' => 'asset_id'],
                    ['name' => 'Assigned date', 'column' => 'assigned_date'],
                    ['name' => 'Return date', 'column' => 'return_date'],
                    ['name' => 'Notes', 'column' => 'notes'],
                    ['name' => 'Is active', 'column' => 'is_active'], 
            ]
        ];


        $this->importScripts = [
            ['source' => asset('vendor/select2/select2.min.js')],
            ['source' => asset('vendor/select2/select2-initialize.js')],
            ['source' => asset('vendor/signaturepad/signature_pad.min.js')],
        ];
        $this->importStyles = [
            ['source' => asset('vendor/select2/select2.min.css')],
            ['source' => asset('vendor/select2/select2-style.css')],
            ['source' => asset('vendor/signaturepad/signature.css')],
        ];
    }


    protected function fields($mode = "create", $id = '-')
    {
        $edit = null;
        if ($id != '-') {
            $edit = $this->modelClass::where('id', $id)->first();
        }

        $assets = Asset::get();
        $asset = $assets->map(function ($item){
            return [
                'value' => $item->id,
                'text' => ($item->code . ' - ' . $item->category . ' - ' . $item->merk . ' - ' . $item->model),
            ];
        })->toArray();
        $isActive = [
            ['value' => 'backup', 'text' => 'Backup'],
            ['value' => 'active', 'text' => 'Active'],
            ['value' => 'standby', 'text' => 'Standby'],
        ];
        $employees = Employee::select('nik as value', 'nama as text')->get();

        $fields = [
                    [
                        'type' => 'select2',
                        'label' => 'Nik',
                        'name' =>  'nik',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('nik', $id),
                        'value' => (isset($edit)) ? $edit->nik : '',
                        'options' => $employees,
                    ],
                    [
                        'type' => 'select2',
                        'label' => 'Asset',
                        'name' =>  'asset_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('asset_id', $id),
                        'value' => (isset($edit)) ? $edit->asset_id : '',
                        'options' => $asset,
                    ],
                    [
                        'type' => 'datetime',
                        'label' => 'Assigned date',
                        'name' =>  'assigned_date',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('assigned_date', $id),
                        'value' => (isset($edit)) ? $edit->assigned_date : ''
                    ],
                    [
                        'type' => 'datetime',
                        'label' => 'Return date',
                        'name' =>  'return_date',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('return_date', $id),
                        'value' => (isset($edit)) ? $edit->return_date : ''
                    ],
                    [
                        'type' => 'textarea',
                        'label' => 'Notes',
                        'name' =>  'notes',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('notes', $id),
                        'value' => (isset($edit)) ? $edit->notes : ''
                    ],
                    [
                        'type' => 'select2',
                        'label' => 'Is active',
                        'name' =>  'is_active',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('is_active', $id),
                        'value' => (isset($edit)) ? $edit->is_active : '',
                        'options' => $isActive,
                    ],
        ];
        
        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [
                    // 'nik' => 'required|string',
                    'asset_id' => 'required|string',
                    // 'assigned_date' => 'required|string',
                    // 'return_date' => 'required|string',
                    // 'notes' => 'required|string',
                    'is_active' => 'required|string',
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
        
        $dataQueries = Transaction::join('assets', 'assets.id', '=', 'transactions.asset_id')
        ->join('employees', 'employees.nik', '=', 'transactions.nik')
        ->where($filters)
            ->where(function ($query) use ($orThose) {
                $query->where('transactions.nik', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('employees.nama', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('assets.category', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('assets.merk', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('assets.model', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('transactions.assigned_date', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('transactions.return_date', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('transactions.notes', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('transactions.is_active', 'LIKE', '%' . $orThose . '%');
            });
        $dataQueries = $dataQueries
        ->select('transactions.*', 'assets.category as category', 'assets.merk as merk', 'assets.model as model', 'employees.nama as nama')
        ->orderBy($orderBy, $orderState);

        return $dataQueries;
    }


    protected function store(Request $request)
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

        $beforeInsertResponse = $this->beforeMainInsert($request);
        if ($beforeInsertResponse !== null) {
            return $beforeInsertResponse; // Return early if there's a response
        }

        DB::beginTransaction();

        try {
            $appendStore = $this->appendStore($request);
            
            if (array_key_exists('error', $appendStore)) {
                return response()->json($appendStore['error'], 200);
            }

            $insert = new $this->modelClass();
            foreach ($this->fields('create') as $key => $th) {
                if ($request[$th['name']]) {
                    $insert->{$th['name']} = $request[$th['name']];
                }
            }
            if (array_key_exists('columns', $appendStore)) {
                foreach ($appendStore['columns'] as $key => $as) {
                    $insert->{$as['name']} = $as['value'];
                }
            }

            $insert->save();

            // Update is_active to null for all transactions with the same asset_id
            Transaction::where('asset_id', $request->asset_id)
                ->where('id', '!=', $insert->id)
                ->update(['is_active' => null]);

            // Create or Update DeviceUser if nik is provided
            if ($request->nik) {
                $employee = Employee::where('nik', $request->nik)->first();
                if ($employee) {
                    // Check if DeviceUser already exists for this asset_id
                    $deviceUser = DeviceUser::where('asset_id', $request->asset_id)->first();
                    
                    if ($deviceUser) {
                        // Update existing DeviceUser
                        $deviceUser->employee_id = $employee->id;
                        $deviceUser->transaction_id = $insert->id;
                        $deviceUser->save();
                    } else {
                        // Create new DeviceUser (only once)
                        DeviceUser::create([
                            'asset_id' => $request->asset_id,
                            'employee_id' => $employee->id,
                            'transaction_id' => $insert->id,
                        ]);
                    }
                }
            }

            $this->afterMainInsert($insert, $request);

            DB::commit();

            return response()->json([
                'status' => true,
                'alert' => 'success',
                'message' => 'Data Was Created Successfully',
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

}
