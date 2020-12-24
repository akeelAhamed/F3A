<?php

use App\Helpers\Route;

/**
 * Application pages
 */
Route::get('/', 'PageController@index');

/**
 * API POST V1 Authenticated Route
 */
Route::post('/api/v1/json', 'Ajax\PostController@index', '', true);