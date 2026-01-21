<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Support\Facades\Http;
use Exception;
use Idev\EasyAdmin\app\Helpers\Validation;
use Illuminate\Support\Facades\Log;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends DefaultController
{
    protected $modelClass = Employee::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    protected $arrPermissions = ['list', 'show', 'create', 'edit', 'delete', 'export-excel-default', 'export-pdf-default', 'import-excel-default'];
    protected $dynamicPermission = true;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Employee';
        $this->generalUri = 'employee';
        $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true],
                    ['name' => 'Company', 'column' => 'company', 'order' => true],
                    ['name' => 'Email', 'column' => 'email', 'order' => true],
                    ['name' => 'Nik', 'column' => 'nik', 'order' => true],
                    ['name' => 'No ktp', 'column' => 'no_ktp', 'order' => true],
                    ['name' => 'Nama', 'column' => 'nama', 'order' => true],
                    ['name' => 'Divisi', 'column' => 'divisi', 'order' => true],
                    ['name' => 'Jabatan', 'column' => 'jabatan', 'order' => true],
                    ['name' => 'Unit kerja', 'column' => 'unit_kerja', 'order' => true],
                    ['name' => 'Status', 'column' => 'status', 'order' => true],
                    ['name' => 'Jk', 'column' => 'jk', 'order' => true],
                    ['name' => 'Telp', 'column' => 'telp', 'order' => true], 
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['company'],
            'headers' => [
                    ['name' => 'Company', 'column' => 'company'],
                    ['name' => 'Email', 'column' => 'email'],
                    ['name' => 'Nik', 'column' => 'nik'],
                    ['name' => 'No ktp', 'column' => 'no_ktp'],
                    ['name' => 'Nama', 'column' => 'nama'],
                    ['name' => 'Divisi', 'column' => 'divisi'],
                    ['name' => 'Jabatan', 'column' => 'jabatan'],
                    ['name' => 'Unit kerja', 'column' => 'unit_kerja'],
                    ['name' => 'Status', 'column' => 'status'],
                    ['name' => 'Jk', 'column' => 'jk'],
                    ['name' => 'Telp', 'column' => 'telp'], 
            ]
        ];


        $this->importScripts = [
            ['source' => asset('vendor/select2/select2.min.js')],
            ['source' => asset('vendor/select2/select2-initialize.js')],
            ['source' => asset('vendor/custom/employee-autofill.js')],
        ];
        $this->importStyles = [
            ['source' => asset('vendor/select2/select2.min.css')],
            ['source' => asset('vendor/select2/select2-style.css')],
        ];
    }


    protected function fields($mode = "create", $id = '-')
    {
        $edit = null;
        if ($id != '-') {
            $edit = $this->modelClass::where('id', $id)->first();
        }

        $employees = $this->getEmployeeOptions();

        $fields = [
                    [
                        'type' => 'select2',
                        'label' => 'Employee',
                        'name' =>  'employee_selector',
                        'id' => 'employee_selector',
                        'class' => 'col-md-12 my-2',
                        'required' => false,
                        'value' => (isset($edit)) ? $edit->nik : '',
                        'options' => $employees,
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Company',
                        'name' =>  'company',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('company', $id),
                        'value' => (isset($edit)) ? $edit->company : '',
                        'readonly' => true,
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Email',
                        'name' =>  'email',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('email', $id),
                        'value' => (isset($edit)) ? $edit->email : '',
                        'readonly' => true,
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Nik',
                        'name' =>  'nik',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('nik', $id),
                        'value' => (isset($edit)) ? $edit->nik : '',
                        'readonly' => true,
                    ],
                    [
                        'type' => 'text',
                        'label' => 'No ktp',
                        'name' =>  'no_ktp',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('no_ktp', $id),
                        'value' => (isset($edit)) ? $edit->no_ktp : '',
                        'readonly' => true,
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Nama',
                        'name' =>  'nama',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('nama', $id),
                        'value' => (isset($edit)) ? $edit->nama : '',
                        'readonly' => true,
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Divisi',
                        'name' =>  'divisi',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('divisi', $id),
                        'value' => (isset($edit)) ? $edit->divisi : '',
                        'readonly' => true,
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Jabatan',
                        'name' =>  'jabatan',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('jabatan', $id),
                        'value' => (isset($edit)) ? $edit->jabatan : '',
                        'readonly' => true,
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Unit kerja',
                        'name' =>  'unit_kerja',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('unit_kerja', $id),
                        'value' => (isset($edit)) ? $edit->unit_kerja : '',
                        'readonly' => true,
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Status',
                        'name' =>  'status',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('status', $id),
                        'value' => (isset($edit)) ? $edit->status : '',
                        'readonly' => true,
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Jk',
                        'name' =>  'jk',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('jk', $id),
                        'value' => (isset($edit)) ? $edit->jk : '',
                        'readonly' => true,
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Telp',
                        'name' =>  'telp',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('telp', $id),
                        'value' => (isset($edit)) ? $edit->telp : '',
                        'readonly' => true,
                    ],
        ];
        
        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [
                    'company' => 'required|string',
                    'email' => 'required|string',
                    'nik' => 'required|string',
                    'no_ktp' => 'required|string',
                    'nama' => 'required|string',
                    'divisi' => 'required|string',
                    'jabatan' => 'required|string',
                    'unit_kerja' => 'required|string',
                    'status' => 'required|string',
                    'jk' => 'required|string',
                    'telp' => 'required|string',
        ];

        return $rules;
    }


    protected function getEmployeeOptions()
    {
        try {

            $response = Http::withOptions([
            'verify' => false,
            ])->timeout(30)->get('https://simco.sampharindogroup.com/api/pegawai');


            if ($response->successful()) {
                $employees = $response->json();
                $options = [];

                if (is_array($employees)) {
                    foreach ($employees as $employee) {
                        if (isset($employee['nik']) && isset($employee['nama']) 
                        && isset($employee['company']) 
                        && $employee['company'] === 'PT. SAMPHARINDO PUTRA TRADING') {
                            $options[] = [
                            'value' => $employee['nik'],
                            'text'  => $employee['nama'] . ' (' . $employee['nik'] . ')',
                            'data-email' => $employee['email'] ?? '',
                            'data-nama' => $employee['nama'] ?? '',
                            'data-company' => $employee['company'] ?? '',
                            'data-divisi' => $employee['divisi'] ?? '',
                            'data-jabatan' => $employee['jabatan'] ?? '',
                            'data-no_ktp' => $employee['no_ktp'] ?? '',
                            'data-unit_kerja' => $employee['unit_kerja'] ?? '',
                            'data-status' => $employee['status'] ?? '',
                            'data-jk' => $employee['jk'] ?? '',
                            'data-telp' => $employee['telp'] ?? '',
                        ];
                        }
                    }
                }
                return $options;
            }
        } catch (Exception $e) {
            Log::error("Gagal mengambil data pegawai untuk options: " . $e->getMessage());
        }

        return [];
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
            // Simpan data Employee
            $employee = new Employee();
            $employee->company = $request->company;
            $employee->email = $request->email;
            $employee->nik = $request->nik;
            $employee->no_ktp = $request->no_ktp;
            $employee->nama = $request->nama;
            $employee->divisi = $request->divisi;
            $employee->jabatan = $request->jabatan;
            $employee->unit_kerja = $request->unit_kerja;
            $employee->status = $request->status;
            $employee->jk = $request->jk;
            $employee->telp = $request->telp;
            $employee->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'alert' => 'success',
                'message' => 'Employee Created Successfully',
                'redirect_to' => route('employee.index'),
            ], 200);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'alert' => 'danger',
                'message' => 'Failed to create employee: ' . $e->getMessage(),
            ], 500);
        }
    }

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
            // Update data Employee
            $employee = Employee::findOrFail($id);
            $employee->company = $request->company;
            $employee->email = $request->email;
            $employee->nik = $request->nik;
            $employee->no_ktp = $request->no_ktp;
            $employee->nama = $request->nama;
            $employee->divisi = $request->divisi;
            $employee->jabatan = $request->jabatan;
            $employee->unit_kerja = $request->unit_kerja;
            $employee->status = $request->status;
            $employee->jk = $request->jk;
            $employee->telp = $request->telp;
            $employee->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'alert' => 'success',
                'message' => 'Employee Updated Successfully',
                'redirect_to' => route('employee.index'),
            ], 200);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'alert' => 'danger',
                'message' => 'Failed to update employee: ' . $e->getMessage(),
            ], 500);
        }
    }

}
