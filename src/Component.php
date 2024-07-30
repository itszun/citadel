<?php

namespace Itszun\Citadel;

use App\Services\LibraryView;
use Closure;
use Illuminate\Support\Str;

class Component
{
    protected $id = "";
    protected $name = "";
    protected $label = "__component__";
    protected $icon = "";
    protected $view = "";
    protected $color = "default";
    protected $show = true;
    protected $parentComponent = null;


    public static function make($name = '', $label = "")
    {
        $obj = new static;
        $obj->name = $name ?? "__component__";
        $obj->label = empty($label) ? Str::title($name) : $label;
        $obj->id = $name . "-" . rand(1000, 9999);

        return $obj;
    }

    public function setParentComponent(?Component $component)
    {
        $this->parentComponent = $component;
        return $this;
    }

    public function color($color)
    {
        $this->color = $color;
        return $this;
    }

    public function show($show)
    {
        $this->show = $show;
        return $this;
    }

    /**
     * Get show parameter value
     *
     * @return boolean
     */
    public function isShow()
    {
        $this->show = boolval(is_callable($this->show) ? Closure::fromCallable($this->show)->call($this) : $this->show);
        return $this->show;
    }

    public function icon(string $icon)
    {
        $this->icon = $icon;
        return $this;
    }

    public function label($label)
    {
        $this->label = $label;
        return $this;
    }

    public function view($view, $data = [], $mergeData = [])
    {
        $this->view = $view;
        return $this;
    }

    protected static function renderChildComponents($components, $data, $parent = null)
    {
        $array = [];
        foreach ($components as $component) {
            $component->setParentComponent($parent);
            $array[] = $component->render($data);
        }
        return $array;
    }

    public function render()
    {
        return [
            'class' => get_class($this),
            'model' => $this,
        ];
    }
}
