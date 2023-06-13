<?php

if (!function_exists('env')) {
    /**
     * Get env value
     *
     * @param string $name Name of the env variable
     * @param mixed $fallback Fallback value to return if variable not found
     * @return mixed
     */
    function env(string $name, $fallback = null)
    {
        return array_key_exists($name, $_ENV) ? $_ENV[$name] : $fallback;
    }
}
