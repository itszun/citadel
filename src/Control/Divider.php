<?php

namespace Itszun\Citadel\Control;

use Itszun\Citadel\Component;
use Itszun\Citadel\Layouts\Section;
use Itszun\Citadel\Traits\ActionGroupChild;

class Divider extends Component
{
    use ActionGroupChild;

    public function render()
    {
        if ($this->parentComponent instanceof ActionGroup) {
            return view(config('citadel.divider'));
        }

        if ($this->parentComponent instanceof Section) {
            return view(config('citadel.vertical_divider'));
        }

        return view(config('citadel.divider'));
    }
}
