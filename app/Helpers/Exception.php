<?php

namespace App\Helpers;

use App\Helpers\View;

class Exception
{
    /**
     * Base error folder
     */
    private static $eFolder = 'errors.';

    /**
     * 404 Error page 
     */
    private static function _404()
    {
        return View::render(self::$eFolder.'404');
    }

    /**
     * 405 Error page 
     */
    private static function _405()
    {
        return View::render(self::$eFolder.'405');
    }

    /**
     * 419 Unauthorized access
     */
    private static function _419()
    {
        return View::render(self::$eFolder.'419');
    }

    /**
     * Triggered when invoking inaccessible methods
     *
     * @param string $method
     * @param array $args
     * @return void
     */
    public static function __callStatic($method, $args)
    {
        if (method_exists(get_called_class(), $method)) {
            return call_user_func(array(get_called_class(), $method), $args);
        }

        return self::_404();
    }
}