<?php

namespace App\Controllers;

use App\Controllers\Auth\AuthController;
use App\Helpers\View;
use App\Helpers\DB;
use App\Helpers\Mail;

class PageController
{

    /**
     * Application home
     *
     * @return void
     */
    public function index()
    {
        return View::render('page.index');
    }

}