<?php

namespace Itszun\Citadel\Control;

use Itszun\Citadel\Component;
use Itszun\Citadel\Traits\ActionGroupChild;
use Itszun\Citadel\Traits\CanRequest;
use Itszun\Citadel\Traits\IsInteractive;
use Itszun\Citadel\Traits\UseURL;

class Action extends Component
{
    use UseURL, CanRequest, IsInteractive, ActionGroupChild;

    protected $as_group;
    protected $parent_name;


    public function getData()
    {
        $data = [
            'id' => $this->id,
            'label' => $this->label,
            'name' => $this->name,
            'color' => $this->color,
            'icon' => $this->icon,
            'as_group' => $this->as_group,
            'getUrl' => fn () => $this->is_interactive ? "javascript:void(0)" : $this->url,
            'onClick' => $this->is_interactive ? optional($this->interactive_onclick)->compile() : null,
            'is_interactive' => $this->is_interactive,
        ];
        return $data;
    }

    public function asGroup($asGroup = true)
    {
        $this->as_group = $asGroup;
        return $this;
    }

    public function setParent(string $name)
    {
        $this->parent_name = $name;
        return $this;
    }

    public function render()
    {
        $is_show = $this->isShow();
        if (!$is_show) return optional();
        $data = $this->getData();

        return view(config('citadel.action'), $data);
    }
}
