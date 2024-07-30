<?php

namespace Itszun\Citadel\Layouts;

use Itszun\Citadel\Component;
use Error;

class Tabs extends Component
{
    protected $schema = [];

    public function schema(array $schema)
    {
        $this->schema = $schema;
        return $this;
    }

    private function renderSchema($data)
    {
        $tab_title = [];
        $tab_content = [];
        foreach ($this->schema as $tab) {
            if (!($tab instanceof Tab)) throw new Error("Tabs schema should having Tab Component Only");
            $tab_title[] = $tab->getTitle();
            $tab_content[] = $tab->getContent($data);
        }
        return compact('tab_title', 'tab_content');
    }

    public function render($data = [])
    {
        $data = array_merge(parent::render(), $this->renderSchema($data), ['tabs_id' => $this->id . "-"]);
        return view(config('citadel.tabs'), $data);
    }
}
