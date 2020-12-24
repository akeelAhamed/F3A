<?php

namespace App\Helpers;

class Params
{
    /**
     * Keep all the parameters
     *
     * @var array
     */
    private static $params = array();

    /**
     * Check for parameter exist
     *
     * @param string $key
     * @return bool
     */
    public static function has($key)
    {
        return array_key_exists($key, self::$params);
    }

    /**
     * Get parameter value
     *
     * @param string $key
     * @return null|array
     */
    public static function get($key=null)
    {
        if ($key == null) {
            return self::$params;
        } else if(self::has($key)) {
            return self::$params[$key];
        }else{
            return null;
        }
    }

    /**
     * Set paramters key & value
     *
     * @param string $key
     * @param string $value
     * @return void
     */
    public static function set($key, $value)
    {
        self::$params[$key] = $value;
        return self::$params[$key];
    }

    /**
     * Get the parameter array
     *
     * @return array
     */
    public static function all()
    {
        return self::$params;
    }
}