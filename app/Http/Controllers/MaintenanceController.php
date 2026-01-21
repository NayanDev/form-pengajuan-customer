<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;

class MaintenanceController extends DefaultController
{
    protected $modelClass = Maintenance::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    protected $arrPermissions = ['list', 'show', 'create', 'edit', 'delete', 'export-excel-default', 'export-pdf-default', 'import-excel-default', 'detail'];
    protected $dynamicPermission = true;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Maintenance';
        $this->generalUri = 'maintenance';
        $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true],
                    ['name' => 'Name', 'column' => 'name', 'order' => true],
                    ['name' => 'Date', 'column' => 'date', 'order' => true],
                    ['name' => 'Notes', 'column' => 'notes', 'order' => true],
                    ['name' => 'Technicial', 'column' => 'technicial', 'order' => true],
                    ['name' => 'Asset', 'column' => 'asset_model', 'order' => true],
                    ['name' => 'Sparepart', 'column' => 'sparepart', 'order' => true], 
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['name'],
            'headers' => [
                    ['name' => 'Name', 'column' => 'name'],
                    ['name' => 'Date', 'column' => 'date'],
                    ['name' => 'Notes', 'column' => 'notes'],
                    ['name' => 'Technicial', 'column' => 'technicial'],
                    ['name' => 'Asset id', 'column' => 'asset_id'],
                    ['name' => 'Sparepart', 'column' => 'sparepart'], 
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
                        'label' => 'Name',
                        'name' =>  'name',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('name', $id),
                        'value' => (isset($edit)) ? $edit->name : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Date',
                        'name' =>  'date',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('date', $id),
                        'value' => (isset($edit)) ? $edit->date : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Notes',
                        'name' =>  'notes',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('notes', $id),
                        'value' => (isset($edit)) ? $edit->notes : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Technicial',
                        'name' =>  'technicial',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('technicial', $id),
                        'value' => (isset($edit)) ? $edit->technicial : ''
                    ],
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
                        'label' => 'Sparepart',
                        'name' =>  'sparepart',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('sparepart', $id),
                        'value' => (isset($edit)) ? $edit->sparepart : ''
                    ],
        ];
        
        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [
                    'name' => 'required|string',
                    'date' => 'required|string',
                    'notes' => 'required|string',
                    'technicial' => 'required|string',
                    'asset_id' => 'required|string',
                    'sparepart' => 'required|string',
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

        $dataQueries = Maintenance::join('assets', 'assets.id', '=', 'maintenances.asset_id')
        ->where($filters)
        ->where(function ($query) use ($orThose){
            $query->where('maintenances.name', 'LIKE', '%' . $orThose . '%');
            $query->orWhere('maintenances.date', 'LIKE', '%' . $orThose . '%');
            $query->orWhere('maintenances.notes', 'LIKE', '%' . $orThose . '%');
            $query->orWhere('maintenances.technicial', 'LIKE', '%' . $orThose . '%');
            $query->orWhere('assets.model', 'LIKE', '%' . $orThose . '%');
            $query->orWhere('maintenances.sparepart', 'LIKE', '%' . $orThose . '%');
        });

        $dataQueries = $dataQueries
        ->select('maintenances.*', 'assets.model as asset_model')
        ->orderBy($orderBy, $orderState);

        return $dataQueries;
    }

}
