<?php

namespace App\Helpers;

use App\Libraries\Utill;
use App\Helpers\Exception;

class Route
{
    /**
     * Keep all the routes
     *
     * @var array
     */
    private static $routes = array();

    /**
     * Route Request Method
     *
     * @var string
     */
    private $method;

    /**
     * Route Path
     *
     * @var string
     */
    private $path;

    /**
     * Current route
     *
     * @var string
     */
    public static $current;

    /**
     * Route Middleware
     *
     * @var string
     */
    private $middleware;

    /**
     * Route Action
     *
     * @var string
     */
    private $action;

    /**
     * Route is ajax
     *
     * @var string
     */
    private $ajax;

    /**
     * Constructor
     *
     * @param string $method
     * @param string $path
     * @param string $action
     * @param string $middleware
     * @param bool   $ajax
     */
    public function __construct($method, $path, $action, $middleware=null, $ajax=false)
    {
        $this->method = $method;
        $this->path = $path;
        $this->action = $action;
        $this->middleware = $middleware;
        $this->ajax = $ajax;
    }

    /**
     * Add GET requests to routes
     *
     * @param string $path
     * @param string $action
     * @param string $middleware
     * @param bool   $ajax
     * @return void
     */
    public static function get($path, $action, $middleware = null, $ajax=false)
    {
        $route = new Route('get', $path, $action, $middleware, $ajax);
        self::$routes[] = $route;
        return $route;
    }
    
    /**
     * Add POST requests to routes
     *
     * @param string $path
     * @param string $action
     * @param string $middleware
     * @param bool   $ajax
     * 
     * @return void
     */
    public static function post($path, $action, $middleware = null, $ajax=false)
    {
        self::$routes[] = new Route('post', $path, $action, $middleware, $ajax);
    }

    /**
     * Get the routes array
     *
     * @return array
     */
    public static function getRoutes()
    {
        return self::$routes;
    }

    /**
     * Get current url
     */
    public static function current()
    {
        return self::$current;
    }

    /**
     * Terminate the route
     *
     * @param string $code
     * @return void
     */
    public static function terminate($code)
    {
        http_response_code($code);
        $code = '_'.$code;
        return Exception::$code();
    }

    /**
     * Handle route to destinated controller function
     *
     * @param string $path
     * @return void
     */
    public static function init($path)
    {
        $path = rtrim($path,"/"); // Remove slash at the end
        $desired_route = null;
        $pnf = false; // page not found

        foreach (self::$routes as $route) {
            $pattern = $route->path;
            $pattern = str_replace('/', '\/', $pattern);

            $pattern = '/^' . $pattern . '$/i';
            $pattern = preg_replace('/{[A-Za-z0-9]+}/', '([A-Za-z0-9-_\s=]+)', $pattern);
            
            if (preg_match($pattern, $path, $match) && $route->method == strtolower($_SERVER['REQUEST_METHOD'])) {
                $pnf = true;
                $desired_route = $route;
                break;
            }
        }

        if($pnf){
            $url_parts = explode('/', $path);
            self::$current = url(ltrim($path, "\/"), true);
            $route_parts = explode('/', $desired_route->path);
    
            foreach ($route_parts as $key => $value) {
                if (!empty($value)) {
                    $value = str_replace('{', '', $value, $count1);
                    $value = str_replace('}', '', $value, $count2);
    
                    if ($count1 == 1 && $count2 == 1) {
                        Params::set($value, $url_parts[$key]);
                    }
                }
            }    
        }
        
        if ($desired_route) {
            if ($desired_route->method != strtolower($_SERVER['REQUEST_METHOD'])) {
                return self::terminate(405);
            } else {

                if($desired_route->method == 'post'){
                    if (!Utill::validateCsrf()) {
                        return self::terminate(419);
                    }
                }
                $proceed = true;
                if($desired_route->ajax){
                    $proceed = request()->ajax();
                }

                if($proceed){
                    if(!is_object($desired_route->action)){
                        // TO CONTROLLER
                        $actions = explode('@', $desired_route->action);
        
                        $class = '\\App\\Controllers\\' . $actions[0];
    
                        $obj = new $class();
    
                        if($desired_route->middleware != null && !false){
                            $middleware = '\\App\\Middleware\\' . $desired_route->middleware;
                            $middleware = new $middleware();
                            if(call_user_func(array($middleware, 'after'))){
                                print_r(
                                    call_user_func_array(
                                        array($obj, $actions[1]), 
                                        Params::get()
                                    )
                                );
                            }else{
                                return self::terminate(419);
                            }
                        }else{
                            print_r(
                                call_user_func_array(
                                    array($obj, $actions[1]), 
                                    Params::get()
                                )
                            );
                        }
                    }else{
                        // CLOSURE OBJECT
                        $closure = $desired_route->action;
                        print_r($closure());
                    }
                }else{
                    return self::terminate(404);
                }
            }

        } else {
            return self::terminate(404);
        }
    }
}