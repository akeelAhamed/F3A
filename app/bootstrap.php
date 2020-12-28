<?php 
/**
 * Bootstrap app
 */
use App\Helpers\Route;

$route = (isset($_GET['url']))?'/'.$_GET['url']:'/';

/**
 * Init route
 */
Route::init($route);