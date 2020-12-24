<?php

namespace App\Controllers\Auth;

use App\Libraries\Classes\Crypto;
use App\Libraries\Utill;

/**
 * Authentication
 *
 * PHP version > 7.0
 */
class AuthController
{
    /**
     * Stores user details
     */
    public static $user = [];

    /**
     * Redirect after employer login
     *
     * @var string
     */
    public static $redirect = 'employer/dashboard';

    /**
     * Redirect after admin login
     *
     * @var string
     */
    public static $redirectAdmin = 'admin/dashboard';

    /**
     * Login the user
     * 
     * @param bool $candidate
     *
     * @return void
     */
    public static function login($candidate=false)
    {
        
    }
   
    /**
     * Logout the user
     *
     * @return void
     */
    public static function logout()
    {
      // Unset all of the session variables
      $_SESSION = [];

      // Delete the session cookie
      if (ini_get('session.use_cookies')) {
          $params = session_get_cookie_params();

          setcookie(
              session_name(),
              '',
              time() - 42000,
              $params['path'],
              $params['domain'],
              $params['secure'],
              $params['httponly']
          );
      }

      // Finally destroy the session
      session_destroy();

      return redirect('');
    }

    /**
     * Get auth type
     */
    private static function type()
    {
        return Utill::getSession('AUTH_TYPE');
    }

    /**
     * Redirect to account page
     *
     * @param bool $return
     * 
     * @return void
     */
    private static function redirect($return=false)
    {
        $url = strtolower(self::$user->utype).'/dashboard';

        if($return){
            echo $url;
            return;
        }
        return redirect($url);
    }

    /**
     * Return indicator of whether a user is logged in or not
     *
     * @param bool $user Return User onject
     *
     * @return boolean
     */
    private static function isLoggedIn($user = true)
    {
        if(Utill::hasSession('AUTH')){
            return property_exists(self::$user, 'id') && self::exist();
        }

        return false;
    }

    /**
     * Capture incomming method
     */
    public static function __callStatic($method, $arguments)
    {
        if(Utill::hasSession('AUTH')){
            $AUTH = Utill::getSession('AUTH');
            self::$user = (object) json_decode(Crypto::decrypt($AUTH));
        }
        return call_user_func_array(array(\get_called_class(),$method),$arguments);
    }
    
}