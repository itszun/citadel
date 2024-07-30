<?php

namespace Itszun\Citadel\Control;

use Itszun\Citadel\Component;

class ActionGroup extends Component
{
    protected $schema = [];

    public function schema(array $schema)
    {
        $this->schema = $schema;
        return $this;
    }

    public function renderChild($components, $data)
    {
        $array = [];
        foreach ($components as $component) {
            $component->setParent($this->name);
            $component->asGroup(true);
            $array[] = $component->render($data);
        }
        return $array;
    }

    public function render($data = [])
    {
        return view(config('citadel.action_group'), array_merge(parent::render(), [
            'items' => static::renderChild($this->schema, $data),
            'label' => $this->label,
            'icon' => $this->icon,
            'id' => $this->id,
            'name' => $this->name,
            'color' => $this->color,
        ]));
    }
}
