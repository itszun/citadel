<?php

namespace Itszun\Citadel\Layouts;

use Itszun\Citadel\Component;
use Itszun\Citadel\Traits\UseLibraryView;

class Section extends Component
{
    use UseLibraryView;

    protected $headers = [];

    protected $template = "";
    protected $see_more = true;
    protected $schema = [];

    public function headers(array $headers)
    {
        $this->headers = $headers;
        return $this;
    }

    public function seeMore(bool $see_more = true) {
        $this->see_more = $see_more;
        return $this;
    }

    public function schema(array $schema) {
        $this->schema = $schema;
        return $this;
    }

    protected function getData(&$data)
    {
        $headers = static::renderChildComponents($this->headers, $data, $parent = $this);
        $view = $this->getView($data);
        $schema = static::renderChildComponents($this->schema, $data, $parent = $this);
        $data = array_merge($data, [
            'label' => $this->label,
            'id' => $this->id,
            'see_more' => $this->see_more,
            'headers' => array_reverse($headers),
            'renderView' => function() use ($view, $schema) {
                if(count($schema) > 0) {
                    $view = "";
                    foreach ($schema as $v) {
                        $view .= $v->render();
                    }
                    return $view;
                }
                return $view->render();
            }
        ]);
        return array_merge(parent::render(), $data);
    }

    public function render($data = [])
    {
        return view(config('citadel.section'), $this->getData($data));
    }
}
