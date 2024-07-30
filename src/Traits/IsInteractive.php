<?php

namespace Itszun\Citadel\Traits;

use Itszun\Citadel\InteractiveComponent;

trait IsInteractive
{
    protected ?InteractiveComponent $interactive_onclick = null;
    protected bool $is_interactive = false;

    public function interactive(bool $interactive = true)
    {
        $this->is_interactive = $interactive;
        return $this;
    }

    public function onClick(InteractiveComponent|array $interactive)
    {
        if (is_array($interactive)) return $this;
        $this->interactive_onclick = $interactive;
        return $this;
    }
}
