<?php

namespace App\Middleware;

use App\Controllers\Auth\AuthController AS Authenicate;

/**
 * Auth middleware to confirm the requeste is not Auth
 */
class Web{
    
    public function after()
    {

        if(!Authenicate::isLoggedIn()){
            return true;
        }

        return redirect(Authenicate::redirect());
    }
}