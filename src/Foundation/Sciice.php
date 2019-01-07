<?php

namespace Platform\Foundation;

use BadMethodCallException;

class Sciice
{
    /**
     * @var array
     */
    public static $menuBar = [];

    /**
     * @var array
     */
    public static $headerBar = [];

    /**
     * @return string
     */
    public static function version()
    {
        return '1.0.0';
    }

    /**
     * 注册菜单
     *
     * @param array $menuBar
     * @return Sciice
     */
    public static function registeredMenuBar(array $menuBar)
    {
        static::$menuBar = array_merge(static::$menuBar, $menuBar);

        return new static;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public static function menuBar()
    {
        return collect(static::$menuBar)->sortBy('sort')->values();
    }

    /**
     * @param array $headerBar
     * @return Sciice
     */
    public static function registeredHeaderBar(array $headerBar)
    {
        static::$headerBar = array_merge(static::$headerBar, $headerBar);

        return new static;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public static function headerBar()
    {
        return collect(static::$headerBar)->sortBy('sort')->values();
    }

    /**
     * @param $path
     * @param $key
     *
     * @return void
     */
    public static function mergeConfigFrom($path, $key)
    {
        $config = config($key, []);

        app('config')->set($key, array_merge_recursive(require $path, $config));
    }

    /**
     * @param $method
     * @param $parameters
     *
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        if (! property_exists(get_called_class(), $method)) {
            throw new BadMethodCallException("Method {$method} does not exist.");
        }

        return static::${$method};
    }
}
