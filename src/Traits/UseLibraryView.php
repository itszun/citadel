<?php

namespace Itszun\Citadel\Traits;

use App\Services\LibraryView;

trait UseLibraryView
{

    public function getView($mergeData = [])
    {

        if (is_callable($this->view) && !empty($this->view)) {
            $view = &$this->view;
            $view = $view();
        } else {
            $view = &$this->view;
        }

        if ($view instanceof LibraryView) {
            $data = $view->getData();
            return view($data['view'], $data['data'], $mergeData);
        }
        if (is_string($view) && !empty($view)) {
            return view($view, $mergeData);
        }
        return optional($view);
    }
}
