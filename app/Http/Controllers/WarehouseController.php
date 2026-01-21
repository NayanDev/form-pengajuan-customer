<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;

class WarehouseController extends DefaultController
{
    protected $modelClass = Warehouse::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    protected $arrPermissions = ['list', 'show', 'create', 'edit', 'delete', 'export-excel-default', 'export-pdf-default', 'import-excel-default'];
    protected $dynamicPermission = true;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Warehouse';
        $this->generalUri = 'warehouse';
        $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true],
                    ['name' => 'Name', 'column' => 'name', 'order' => true],
                    ['name' => 'Type', 'column' => 'type', 'order' => true], 
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['name'],
            'headers' => [
                    ['name' => 'Name', 'column' => 'name'],
                    ['name' => 'Type', 'column' => 'type'], 
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
                        'type' => 'select',
                        'label' => 'Type',
                        'name' =>  'type',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('type', $id),
                        'value' => (isset($edit)) ? $edit->type : '',
                        'options' => [
                            ['value' => 'narkotika', 'text' => 'Narkotika'],
                            ['value' => 'psikotropika', 'text' => 'Psikotropika'],
                            ['value' => 'oot', 'text' => 'Obat-obatan tertentu'],
                            ['value' => 'prekursor', 'text' => 'Prekursor'],
                            ['value' => 'non-prekursor', 'text' => 'Non-Prekursor'],
                        ],
                    ],
        ];
        
        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [
                    'name' => 'required|string',
                    'type' => 'required|string',
        ];

        return $rules;
    }

}
