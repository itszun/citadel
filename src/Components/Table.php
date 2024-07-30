<?php

namespace Itszun\Citadel\Components;

use Itszun\Citadel\Component;
use App\Services\Table\Action;
use App\Services\Table\Column;
use App\Services\Table\Core;
use App\Services\Table\Filter;
use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use stdClass;

class Table extends Component
{
    protected $name = "";

    protected $title = "";

    protected $idField = "";

    protected $columns = [];
    protected $actions = [];
    protected $filters = [];
    protected $action_position = "start";

    protected $numbering = false;

    protected $striped = true;
    protected $sidePagination = 'server';
    protected $smartDisplay = false;
    protected $cookie = true;
    protected $cookieExpire = '1h';
    protected $showExport = false;
    protected $exportTypes = ['json', 'xml', 'csv', 'txt', 'excel'];
    protected $showFilter = true;
    protected $flat = true;
    protected $keyEvents = false;
    protected $showMultiSort = false;
    protected $reorderableColumns = false;
    protected $resizable = false;
    protected $pagination = true;
    protected $cardView = false;
    protected $detailView = false;
    protected $search = true;
    protected $showRefresh = true;
    protected $showToggle = true;
    protected $clickToSelect = true;
    protected $singleSelect = false;
    protected $showColumns = true;
    protected $showColumnsSearch = true;
    protected $showColumnsToggleAll = true;

    protected $columnDefaultAlign = "center";

    protected $default_sort_by = "id";
    protected $default_sort_order = "asc";

    protected $pageSize = 10;
    protected $pageList = [10, 25, 50, 100];

    protected $request_get_config = true;
    protected $query = null;

    protected static $like_keyword = "like";

    public function __construct()
    {
        $this->request_get_config = request()->get('get_config');
        if (config('database.default') === "pgsql") {
            static::$like_keyword = "ilike";
        }
    }

    public function idField($field)
    {
        $this->idField = $field;
        return $this;
    }

    public function search($search = true)
    {
        $this->search = $search;
        return $this;
    }

    public function pageSize($pageSize){
        $this->pageSize = $pageSize;
        return $this;
    }

    //using  order fiield
    public function default_sort_order($default_sort_order){
        $this->default_sort_order = $default_sort_order;
        return $this;
    }

    //choose order field name
    public function default_sort_by($default_sort_by){
        $this->default_sort_by = $default_sort_by;
        return $this;
    }


    public function pageList($pageList = [5,10,25,50,100,200]){
        $this->pageList = $pageList;
        return $this;
    }

    public function columns($columns)
    {
        foreach ($columns as $column) {
            $this->columns[$column->getField()] = $column;
        }
        return $this;
    }



    public function actions($actions)
    {
        $this->actions = $actions;
        return $this;
    }

    public function filters($filters = [])
    {
        $this->filters = $filters;
        return $this;
    }

    public function showColumns($show = true)
    {
        $this->showColumns = $show;
        return $this;
    }

    public function singleSelect($value = true)
    {
        $this->singleSelect = $value;
        return $this;
    }

    public function actionPosition($position = "start")
    {
        $this->action_position = $position;
        return $this;
    }

    public function numbering($numbering = true)
    {
        $this->numbering = $numbering;
        return $this;
    }

    public function columnDefaultAlign($align = "center") {
        $this->columnDefaultAlign = $align;
        return $this;
    }

    public function query(string|Builder|EloquentBuilder $query)
    {
        if (is_string($query)) {
            $query = ($query)::query();
        }
        $this->query = $query;
        return $this;
    }

    public function get_columns_array()
    {
        $columns = [];
        foreach ($this->columns as $col) {
            $col->defaultAlign($this->columnDefaultAlign);
            $columns[] = $col->get_array();
        }
        return $columns;
    }

    public function get_searchable_column_names()
    {
        $names = [];
        foreach ($this->columns as $col) {
            if ($col->isSearchable()) {
                $names[] = $col->getName();
            }
        }
        return $names;
    }

    /**
     * Get All Columns
     */
    public function get_column_names()
    {
        $names = [];
        foreach ($this->columns as $col) {
            $names[] = $col->getName();
        }
        return $names;
    }


    /**
     * Get table configuration
     */
    public function get_array()
    {
        $columns = $this->get_columns_array();
        if (count($this->actions) > 0) {
            if ($this->action_position == "start") {
                $pos = 0;
            } else if ($this->action_position == "end") {
                $pos = count($columns);
            } else {
                $pos = $this->action_position;
            }
            array_splice($columns, $pos, 0, [
                Column::make('action', __('Aksi'))
                    ->width('100')
                    ->get_array()
            ]);
        }
        if ($this->numbering) {
            array_splice($columns, 0, 0, [Column::make('x_number', "No")
                ->get_array()]);
        }

        $tableConfig = [
            'columns' => $columns,
            'idField' => $this->idField,
            "striped" => $this->striped,
            "sidePagination" => $this->sidePagination,
            "smartDisplay" => $this->smartDisplay,
            "cookie" => $this->cookie,
            "cookieExpire" => $this->cookieExpire,
            "showExport" => $this->showExport,
            "exportTypes" => $this->exportTypes,
            "showFilter" => $this->showFilter,
            "flat" => $this->flat,
            "keyEvents" => $this->keyEvents,
            "showMultiSort" => $this->showMultiSort,
            "reorderableColumns" => $this->reorderableColumns,
            "resizable" => $this->resizable,
            "pagination" => $this->pagination,
            "cardView" => $this->cardView,
            "detailView" => $this->detailView,
            "search" => $this->search,
            "showRefresh" => $this->showRefresh,
            "showToggle" => $this->showToggle,
            "clickToSelect" => $this->clickToSelect,
            "singleSelect" => $this->singleSelect,
            "showColumns" => $this->showColumns,
            "showColumnsSearch" => $this->showColumnsSearch,
            "showColumnsToggleAll" => $this->showColumnsToggleAll,
            "pageList" => $this->pageList,
            "pageSize" => $this->pageSize,
            "default_sort_order" => $this->default_sort_order,
            "default_sort_by" => $this->default_sort_by
        ];
        

        $filters = view('components.bootstrap-table-filter', [
            'filters' => collect($this->filters)
                ->filter(fn(Filter $i) => $i->show)
                ->map(fn($i) => $i->getArray())->toArray(),
            'table_id' => $this->getTableId(),
            'filter_class' => "bt-filter-{$this->getTableId()}",
        ])->render();
        return compact('tableConfig','filters');
    }

    public function defaultSortBy($sort, $order) {
        $this->default_sort_by = $sort;
        $this->default_sort_order = $order;
        return $this;
    }

    /**
     * Get qualified and calculated data
     */
    public function get_data()
    {
        $request = request();
        $order = $request->order;
        $search = $request->get('search');
        $query = $this->query->clone();
        $actions = $this->actions;
        $has_action = !empty($this->actions);
        $numbering = $this->numbering;
        $number = request()->get('offset', 0) + 1;
        $columns = $this->columns;

        $idField = empty($this->idField) ? "id" : $this->idField;
        $sortBy = request()->get('sort', $this->default_sort_by);
        $order = $request->has('sort') ? request()->get('order', $this->default_sort_order) : $this->default_sort_order;

        
        Core::applySearch($query, $this->columns, $search);
        Core::applyFilter($query, $this->filters, $search);
        $total = $query->count();
        
        $query->orderBy($sortBy, $order);
        $query->offset(request()->get('offset', 0))->limit(request()->get('limit', $this->pageSize));
        // $query->offset(request()->get('offset', 0))->limit(request()->get('limit', $this->perPage));

        $rows = $query->get();

        $rows = $rows->map(function ($model) use ($columns, $has_action, $actions, $numbering, &$number) {
            $assoc = static::modelToArray($model);
            if ($has_action) {
                $assoc['action'] = static::renderAction($model, $actions, $this->getTableId());
            }
            if ($numbering) {
                $assoc['x_number'] = $number++;
            }
            foreach ($columns as $column) {
                $field_name = $column->getField();
                // $columns_[] = $column->getField();
                // if recursive

                if (array_key_exists($field_name, $assoc)) {
                    $assoc[$field_name] = $column->applyValue($model->{$field_name}, $model);
                    // $assoc[$field_name] = $column->applyValue($assoc[$field_name], $model);
                } else {
                    $data = null;
                    if ($model instanceof Model) {
                        $model_recursive = static::knockRecursive($field_name, $model);
                        $field = explode('.', $field_name);
                        try {
                            $data = $model_recursive->{$field[count($field) - 1]};
                        } catch (\Throwable $th) {
                        }
                    }
                    $assoc[$field_name] = $column->applyValue($data, $model);
                }
            }

            return $assoc;
        });
        // dd("uwu");

        // $total = $this->query->clone()->count();
        // $total = $query->count();
        // fix bug by kamil
        return compact('rows', 'total');
    }

    public static function modelToArray($model)
    {
        if ($model instanceof stdClass) {
            return (array) $model;
        }
        return $model->toArray();
    }

    /**
     * There is a case of a field named 'relationship_model.inner_relationship.custom_field_name' that need to be touched to trigger data fetching. This function do exactly that
     *
     */
    public static function knockRecursive($field_name, &$model)
    {
        $split = explode('.', $field_name);
        $is_final = count($split) < 2;

        if (!$is_final) {
            $data = $model->{$split[0]};
            array_shift($split);
            $field_name = implode('.', $split);
            if ($data) {
                static::knockRecursive($field_name, $data);
            }
        } else {
            $field = $split[0];
            try {
                $model->append($field);
                $model->{$field};
                $model->toArray();
            } catch (\Throwable $th) {
                if (!$model) return;
                // Error nih, ternyata pas dites toArray, append Attributenya ga ketemu
                $appends = $model->getAppends(); // ambil list appends
                $found_key = array_search($field, $appends); // get key appends yang bermasalah (current split field name)
                unset($appends[$found_key]); // unset field tersebut
                $appends = array_values($appends); // re-indexing lagi datanya
                $model->setAppends($appends); // rollback/balikin list appends ke sebelumnya;
            }
            $data = $model->{$field};
        }
        // $assoc[$field_name] = ;
        return $data;
    }

    public static function renderAction($model, $actions, $table_id)
    {
        $actions = collect($actions)->reduce(function ($acc, Action $action) use ($model, $table_id) {
            $action->tableId($table_id);
            // $renderedAction = $action->render($model, 'dropdown');
            // if(!empty($renderedAction)) {
            //     $acc .= $renderedAction;
            // }
            $acc[] = $action->processed($model);
            return $acc;
        }, []);

        return view('components.table-action-group', [
            'model' => $model,
            'actions' => $actions
        ])->render();
    }

    public function render()
    {
        if ($this->request_get_config) {
            return $this->get_array();
        }
        return view(config('citadel.table'), [
            'id' => $this->id,
            'renderFilters' => fn() => "",
            'class' => $this->name,
            'name' => $this->name,
            'src' => url(url()->current(), [
                'table_config' => $this->name
            ])
        ]);
    }

    public function renderPage($control_actions) {
        return view('template.index_page', [
            'control_action' => $control_actions,
            'table_id' => $this->getTableId(),
            'table_src' => url(),
        ]);
    }

    public function getTableId()
    {
        return "table_".($this->name);
    }
}
