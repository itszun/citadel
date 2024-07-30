<?php

namespace Itszun\Citadel\Traits;

trait UseURL
{
    protected $url = "";

    /**
     * Shorthad for set url with laravel route() helper
     *
     * @param string $name
     * @param mixed $parameters
     * @param bool $absolute
     * @return static
     */
    public function route(string $name, mixed $parameters = [], $absolute = true)
    {
        $this->url = route($name, $parameters, $absolute);
        return $this;
    }

    /**
     * Shorthand for set url with laravel url() helper
     *
     * @param string $path
     * @param mixed $parameters
     * @param bool|null $secure
     * @return static
     */
    public function url(string $path = null, mixed $parameters = [], bool $secure = null)
    {
        $this->url = url($path, $parameters, $secure);
        return $this;
    }

    /**
     * Raw url location target
     *
     * @param string $path
     * @return static
     */
    public function to(string $path = "#")
    {
        $this->url = $path;
        return $this;
    }
}
