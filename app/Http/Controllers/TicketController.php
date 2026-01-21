<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Ticket;
use Exception;
use Idev\EasyAdmin\app\Helpers\Validation;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TicketController extends DefaultController
{
    protected $modelClass = Ticket::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    protected $arrPermissions = ['list', 'show', 'create', 'edit', 'delete', 'export-excel-default', 'export-pdf-default', 'import-excel-default', 'detail'];
    protected $dynamicPermission = true;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Ticket';
        $this->generalUri = 'ticket';
        $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true],
                    ['name' => 'Code', 'column' => 'code', 'order' => true],
                    ['name' => 'Description', 'column' => 'description', 'order' => true],
                    ['name' => 'Employee', 'column' => 'nama', 'order' => true],
                    ['name' => 'Teknician', 'column' => 'teknician', 'order' => true],
                    ['name' => 'Level', 'column' => 'level', 'order' => true],
                    ['name' => 'Date', 'column' => 'date', 'order' => true],
                    ['name' => 'Status', 'column' => 'status', 'order' => true],
                    ['name' => 'Is complete', 'column' => 'is_complete', 'order' => true], 
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['code'],
            'headers' => [
                    ['name' => 'Code', 'column' => 'code'],
                    ['name' => 'Description', 'column' => 'description'],
                    ['name' => 'Employee id', 'column' => 'employee_id'],
                    ['name' => 'Teknician', 'column' => 'teknician'],
                    ['name' => 'Level', 'column' => 'level'],
                    ['name' => 'Date', 'column' => 'date'],
                    ['name' => 'Status', 'column' => 'status'],
                    ['name' => 'Is complete', 'column' => 'is_complete'], 
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
        
        
        $category = [
            ['value' => '', 'text' => '-- Pilih Kategori --'],
            ['value' => 'maserp', 'text' => 'MasERP'],
            ['value' => 'itsupport', 'text' => 'IT Support'],
        ];

        $employees = Employee::select('id as value', 'nama as text')->get();
        $levels = [
            ['value' => 'Low', 'text' => 'Low'],
            ['value' => 'Medium', 'text' => 'Medium'],
            ['value' => 'High', 'text' => 'High'],
        ];
        $status = [
            ['value' => 'open', 'text' => 'Open'],
            ['value' => 'process', 'text' => 'Process'],
            ['value' => 'closed', 'text' => 'Closed'],
        ];
        $isComplete = [
            ['value' => 'nodata', 'text' => 'No Data'],
            ['value' => 'like', 'text' => 'Like'],
            ['value' => 'dislike', 'text' => 'Dislike'],
        ];

        $fields = [
                    [
                        'type' => 'select',
                        'label' => 'Category',
                        'name' =>  'category',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('category', $id),
                        'value' => (isset($edit)) ? $edit->category : '',
                        'options' => $category,
                    ],
                    // [
                    //     'type' => 'text',
                    //     'label' => 'Code',
                    //     'name' =>  'code',
                    //     'class' => 'col-md-12 my-2',
                    //     'required' => $this->flagRules('code', $id),
                    //     'value' => (isset($edit)) ? $edit->code : $code
                    // ],
                    [
                        'type' => 'textarea',
                        'label' => 'Description',
                        'name' =>  'description',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('description', $id),
                        'value' => (isset($edit)) ? $edit->description : '-'
                    ],
                    [
                        'type' => 'select2',
                        'label' => 'Employee id',
                        'name' =>  'employee_id',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('employee_id', $id),
                        'value' => (isset($edit)) ? $edit->employee_id : '',
                        'options' => $employees,
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Teknician',
                        'name' =>  'teknician',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('teknician', $id),
                        'value' => (isset($edit)) ? $edit->teknician : 'Nayantaka'
                    ],
                    [
                        'type' => 'select',
                        'label' => 'Level',
                        'name' =>  'level',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('level', $id),
                        'value' => (isset($edit)) ? $edit->level : '',
                        'options' => $levels,
                    ],
                    [
                        'type' => 'datetime',
                        'label' => 'Date',
                        'name' =>  'date',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('date', $id),
                        'value' => (isset($edit)) ? $edit->date : ''
                    ],
                    [
                        'type' => 'select',
                        'label' => 'Status',
                        'name' =>  'status',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('status', $id),
                        'value' => (isset($edit)) ? $edit->status : '',
                        'options' => $status,
                    ],
                    [
                        'type' => 'select2',
                        'label' => 'Is complete',
                        'name' =>  'is_complete',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('is_complete', $id),
                        'value' => (isset($edit)) ? $edit->is_complete : '',
                        'options' => $isComplete,
                    ],
        ];
        
        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [
                    'category' => 'required|string|in:maserp,itsupport',
                    'description' => 'required|string',
                    'employee_id' => 'required|string',
                    'teknician' => 'required|string',
                    'level' => 'required|string',
                    'date' => 'required|string',
                    'status' => 'required|string',
                    'is_complete' => 'required|string',
        ];

        return $rules;
    }

    /**
     * Generate ticket code based on category
     * Format: MRP-0126001 atau ITS-0126001
     */
    protected function generateTicketCode($category)
    {
        $prefix = $category === 'maserp' ? 'MRP' : 'ITS';
        $month = date('m');
        $year = date('y');
        $pattern = $prefix . '-' . $month . $year;
        
        // Get last ticket with same prefix-month-year pattern
        $lastTicket = Ticket::where('code', 'LIKE', $pattern . '%')
            ->orderBy('id', 'DESC')
            ->first();
        
        if ($lastTicket) {
            // Extract last 3 digits and increment
            $lastSequence = (int) substr($lastTicket->code, -3);
            $newSequence = $lastSequence + 1;
        } else {
            $newSequence = 1;
        }
        
        $sequenceFormatted = str_pad($newSequence, 3, '0', STR_PAD_LEFT);
        
        return $pattern . $sequenceFormatted;
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
        
        $dataQueries = Ticket::join('employees', 'employees.id', '=', 'tickets.employee_id')
        ->where($filters)
            ->where(function ($query) use ($orThose) {
                $query->where('tickets.code', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('tickets.description', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('employees.nama', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('tickets.teknician', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('tickets.level', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('tickets.date', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('tickets.status', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('tickets.is_complete', 'LIKE', '%' . $orThose . '%');
            });
        $dataQueries = $dataQueries
        ->select('tickets.*', 'employees.nama as nama')
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
            
            // Generate code based on category
            if ($request->category) {
                $generatedCode = $this->generateTicketCode($request->category);
                $insert->code = $generatedCode;
            }
            
            // Loop through fields and save, but skip category (not in database)
            foreach ($this->fields('create') as $key => $th) {
                $fieldName = $th['name'];
                // Skip category because it's not saved to database, only used for code generation
                if ($fieldName === 'category') {
                    continue;
                }
                if (isset($request[$fieldName])) {
                    $insert->{$fieldName} = $request[$fieldName];
                }
            }
            if (array_key_exists('columns', $appendStore)) {
                foreach ($appendStore['columns'] as $key => $as) {
                    $insert->{$as['name']} = $as['value'];
                }
            }

            $insert->save();

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
