<?php

namespace App\Middleware;

use App\Controllers\Auth\AuthController AS Authenicate;

/**
 * Auth middleware to confirm the requeste is Auth
 */
class Auth{
    
    public function after()
    {
        if(Authenicate::isLoggedIn()){
            return true;
        }

        return redirect();
    }
}