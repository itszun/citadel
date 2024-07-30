<?php

namespace Itszun\Citadel\Layouts;

use Itszun\Citadel\Component;
use App\Services\LibraryView;

class Floater extends Component
{
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

    public function getContent()
    {
        return array_merge([
            'view' => $this->getView(),
            'id' => $this->id,
            'content_id' => 'tab-content-' . $this->id,
        ], $this->getData());
    }

    public function getView()
    {
        if ($this->view instanceof LibraryView) {
            $data = $this->view->getData();
            return view($data['view'], $data['data']);
        }
        if (is_string($this->view) && !empty($this->view)) {
            return view($this->view);
        }
        return optional($this->view);
    }
}
