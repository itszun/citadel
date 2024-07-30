<?php

namespace Itszun\Citadel\Traits;

trait ActionGroupChild
{
    public function setParent(string $name)
    {
        return $this;
    }

    public function asGroup($asGroup)
    {
        $this->as_group = $asGroup;
        return $this;
    }
}
