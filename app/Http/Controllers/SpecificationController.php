<?php

namespace App\Http\Controllers;

use App\Models\Specification;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;

class SpecificationController extends DefaultController
{
    protected $modelClass = Specification::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    // protected $arrPermissions;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Specification';
        $this->generalUri = 'specification';
        // $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true],
                    ['name' => 'Asset id', 'column' => 'asset_id', 'order' => true],
                    ['name' => 'Spec key', 'column' => 'spec_key', 'order' => true],
                    ['name' => 'Spec value', 'column' => 'spec_value', 'order' => true], 
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['asset_id'],
            'headers' => [
                    ['name' => 'Asset id', 'column' => 'asset_id'],
                    ['name' => 'Spec key', 'column' => 'spec_key'],
                    ['name' => 'Spec value', 'column' => 'spec_value'], 
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
                        'label' => 'Spec key',
                        'name' =>  'spec_key',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('spec_key', $id),
                        'value' => (isset($edit)) ? $edit->spec_key : ''
                    ],
                    [
                        'type' => 'text',
                        'label' => 'Spec value',
                        'name' =>  'spec_value',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('spec_value', $id),
                        'value' => (isset($edit)) ? $edit->spec_value : ''
                    ],
        ];
        
        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [
                    'asset_id' => 'required|string',
                    'spec_key' => 'required|string',
                    'spec_value' => 'required|string',
        ];

        return $rules;
    }

}
