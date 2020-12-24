<?php 
/**
 * Bootstrap app
 */
use App\Helpers\Route;
use App\Helpers\Request;

$request = new Request();
$route = (isset($_GET['url']))?'/'.$_GET['url']:'/';

/**
 * App request fuction
 * 
 * @return Object App\Helpers\Request()->$request
 */
function request()
{
    return $GLOBALS['request'];
}

/**
 * Init route
 */
Route::init($route);