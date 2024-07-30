<?php

namespace Itszun\Citadel\Layouts;

use Itszun\Citadel\Component;
use Itszun\Citadel\Traits\UseLibraryView;
use App\Services\LibraryView;

class Tab extends Component
{
    use UseLibraryView;

    protected $disabled = false;

    public function disabled($disabled)
    {
        $this->disabled = $disabled;
        return $this;
    }

    public function getTitle()
    {
        return array_merge([
            'label' => $this->label,
            'name' => $this->name,
            'icon' => $this->icon,
            'id' => $this->id,
            'title_id' => 'tab-' . $this->id,
            'data_target' => 'tab-content-' . $this->id,
        ], $this->getData());
    }

    public function getData()
    {
        return [
            'disabled' => $this->disabled
        ];
    }

    public function getContent($data = [])
    {
        return array_merge([
            'view' => $this->getView($data),
            'id' => $this->id,
            'content_id' => 'tab-content-' . $this->id,
        ], $this->getData());
    }
}
