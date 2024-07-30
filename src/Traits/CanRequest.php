<?php

namespace Itszun\Citadel\Traits;

trait CanRequest
{
    /**
     * Set custom method to url
     *
     * @param string $method
     * @param string $url
     * @return static
     */
    public function method(string $method, string $url = "")
    {
        return $this;
    }

    /**
     * GET method 
     *
     * @param string $url
     * @return static
     */
    public function get(string $url)
    {
        return $this;
    }

    /**
     * POST method
     *
     * @param string $url
     * @return static
     */
    public function post(string $url)
    {
        return $this;
    }

    /**
     * Delete Method
     *
     * @param string $url
     * @return static
     */
    public function delete(string $url)
    {
        return $this;
    }
}
