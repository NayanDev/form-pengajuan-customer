<?php

namespace App\Http\Controllers;

use App\Models\CategoryMapping;
use App\Models\Warehouse;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;
use Illuminate\Support\Facades\DB;

class CategoryMappingController extends DefaultController
{
    protected $modelClass = CategoryMapping::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    // protected $actionButtons;
    protected $arrPermissions = ['list', 'show', 'create', 'edit', 'delete', 'export-excel-default', 'export-pdf-default', 'import-excel-default'];
    protected $dynamicPermission = true;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Category Mapping';
        $this->generalUri = 'category-mapping';
        $this->arrPermissions = [];
        $this->actionButtons = ['btn_edit', 'btn_show', 'btn_delete'];

        $this->tableHeaders = [
                    ['name' => 'No', 'column' => '#', 'order' => true],
                    ['name' => 'Warehouse', 'column' => 'warehouse_name', 'order' => true],
                    ['name' => 'Name', 'column' => 'name', 'order' => true],
                    ['name' => 'Year', 'column' => 'year', 'order' => true],
                    ['name' => 'Min', 'column' => 'min', 'order' => true],
                    ['name' => 'Max', 'column' => 'max', 'order' => true],
                    ['name' => 'Avg', 'column' => 'avg', 'order' => true],
                    ['name' => 'Created at', 'column' => 'created_at', 'order' => true],
                    ['name' => 'Updated at', 'column' => 'updated_at', 'order' => true],
        ];


        $this->importExcelConfig = [ 
            'primaryKeys' => ['warehouse_id'],
            'headers' => [
                    ['name' => 'Warehouse id', 'column' => 'warehouse_id'],
                    ['name' => 'Name', 'column' => 'name'],
                    ['name' => 'Year', 'column' => 'year'], 
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
                        'label' => 'Name',
                        'name' =>  'name',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('name', $id),
                        'value' => (isset($edit)) ? $edit->name : ''
                    ],
                    [
                        'type' => 'select',
                        'label' => 'Year ',
                        'name' =>  'year',
                        'class' => 'col-md-12 my-2',
                        'required' => $this->flagRules('year', $id),
                        'value' => (isset($edit)) ? $edit->year : '',
                        'options' => $years,
                    ],
        ];
        
        return $fields;
    }


    protected function rules($id = null)
    {
        $rules = [
                    'warehouse_id' => 'required|string',
                    'name' => 'required|string',
                    'year' => 'required|string',
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

        $dataQueries = CategoryMapping::join('warehouses', 'warehouses.id', '=', 'mapping_studies.warehouse_id')
            ->leftJoin('mapping_study_points', 'mapping_study_points.mapping_study_id', '=', 'mapping_studies.id')
            ->leftJoin('mapping_study_readings', 'mapping_study_readings.mapping_study_point_id', '=', 'mapping_study_points.id')
            ->where($filters)
            ->where(function ($query) use ($orThose) {
                $query->where('warehouses.name', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('mapping_studies.name', 'LIKE', '%' . $orThose . '%');
                $query->orWhere('mapping_studies.year', 'LIKE', '%' . $orThose . '%');
            })
            ->groupBy('mapping_studies.id', 'mapping_studies.warehouse_id', 'mapping_studies.name', 'mapping_studies.year', 'mapping_studies.created_at', 'mapping_studies.updated_at', 'warehouses.name')
            ->orderBy($orderBy, $orderState)
            ->select(
                'mapping_studies.*', 
                'warehouses.name as warehouse_name',
                DB::raw('ROUND(MIN(mapping_study_readings.value), 2) as min'),
                DB::raw('ROUND(MAX(mapping_study_readings.value), 2) as max'),
                DB::raw('ROUND(AVG(mapping_study_readings.value), 2) as avg')
            );

        return $dataQueries;
    }

}
