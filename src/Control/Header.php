<?php

namespace Itszun\Citadel\Control;

use Itszun\Citadel\Component;
use Itszun\Citadel\Traits\ActionGroupChild;

class Header extends Component
{
    use ActionGroupChild;

    public function render()
    {
        return view(config('citadel.divider'));
    }
}
