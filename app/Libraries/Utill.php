<?php
namespace App\Libraries;

use App\Libraries\Classes\Crypto;

/**
 * Utility for app
 */
class Utill{
	
	/**
	 * Check the key is exists in Session
	 * 
	 * @param string $key Search key
	 * 
	 * @return bool
	 */
	public static function hasSession($key)
    {
        return array_key_exists($key, $_SESSION);
    }

    /**
	 * Check the key is exists in Post
	 * 
	 * @param string $key Search key
	 * 
	 * @return bool
	 */
	public static function hasPostExist($key)
    { 
        return array_key_exists($key, $_POST)?!empty($_POST[$key]):false;
	}
	
	/**
	 * Check the key is exists in array
	 * 
	 * @param string $array Array to find
	 * @param string $key   Search key
	 * 
	 * @return bool
	 */
	public static function hasKeyExist(array $array, $key)
    { 
        return array_key_exists($key, $array)?!empty($array[$key]):false;
    }

    /**
	 * Set new session with the key and value
	 * 
	 * @return ...
	 */
	public static function setSession($key, $value)
    { 
        return $_SESSION[$key] = $value;
	}

	/**
	 * Get Session value
	 * 
	 * @param null|string $key Search key
	 * 
	 * @return bool
	 */
	public static function getSession($key=null)
    {
		if(is_null($key)){
			return $_SESSION;
		}else if(Utill::hasSession($key)){
			return $_SESSION[$key];
		}
		return null;
    }

	/**
	 * Unset variabl with the key and value
	 * 
	 * @param any $key Session key
	 * 
	 * @return ...
	 */
	public static function unsetSession($key='*')
    {
		if($key == '*'){
			session_destroy();
			session_start();
			session_regenerate_id(true);
		}else{
			if(!is_array($key)){
				$key = [$key];
			}
			foreach ($key as $i => $k) {
				unset($_SESSION[$k]);
			}
		}
	}

	/**
	 * Check if array has key(s)
	 *
	 * @param string|array $key
	 * @param array 	   $inputs
	 * @return bool
	 */
	public static function arrayHas($keys, array $inputs)
	{
		$keys = \is_array($keys)?$keys:[$keys];
		if (count(array_intersect_key(array_flip($keys), $inputs)) === count($keys)) {
			return true;
		}
		return false;
	}

	/**
	 * Unset a key or multiple key from a given array
	 *
	 * @param string $remove
	 * @param array  $inputs
	 * @return void
	 */
	public static function unsetArray($remove='*', array $inputs)
    {
		$remove = (is_array($remove))?$remove:\explode('', $remove);

        return array_diff_key($inputs, array_flip($remove));
	}
	
	/**
	 * Function to check the given array contain given value
	 * 
	 * @param array  $array Search array
	 * @param string $key 	Find value in key
	 * @param string $sval	Search value in array
	 * 
	 * @return array_search status
	 */
	public static function searchArray(array $array, $skey, $sval)
	{
		foreach ($array as $key => $val) {
			if (isset($array[$key]) && $val[$skey] === $sval) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Function to check the given multi dimentional array contain given value 
	 * 
	 * @param array  $array Search array
	 * @param string $key 	Find value in key
	 * @param string $value	Search value in array
	 * 
	 * @return array
	 */
	public static function searchArray2(array $array, $key, $value)
	{
		$ret = current(array_filter($array, function($item) use($key, $value) {
            return isset($item[$key]) && $value == $item[$key];
		}));
		
		return $ret;
	}

	/**
     * Upload file to server
     * 
     * @param array $file File name in request
     * @param string $path Move path
     * @param string $name Rename to
     * @param null   $op   optional parameter for further use
     * 
     */
    public static function moveFile($file, $path, $name='', $op=null){
		$op = (is_null($op))?'':$op;
		$path = 'assets/'.$path.'/';
        $name = preg_replace('/[^A-Za-z0-9\-]/', '', $name);
		$name = \str_replace(' ', '_', $name);
        $name = strtolower('MED_'.\time().'_'.$name.$op.'.'.pathinfo($file['name'], PATHINFO_EXTENSION));
        move_uploaded_file($file['tmp_name'], $path.$name);
        return '/'.$name;
	}

	/**
     * Delete file from server
     * 
     * @param string $file Full File name with path
     * 
     */
	public static function unlink($file){
		$file = 'assets/'.$file;
        return \file_exists($file)?unlink($file):true;
    }
	
	/**
	 * To generate new user id
	 * 
	 * @param int $len length of the user id
	 * 
	 * @return Unique 8 digit user id
	 */
	public static function generateUid($len=4)
	{
		$uid='';
        $codeAlphabet = "123456789";
        $codeAlphabet.= str_replace(0, rand(1,9), time());
        $max = strlen($codeAlphabet);
   
        for ($i=0; $i < $len; $i++) {
            $uid .= $codeAlphabet[random_int(0, $max-1)];
        }
       
        return $uid;
	}

	/**
	 * Open SSL encrypt data
	 * 
	 * @param string $data Data to encrypt
	 * 
	 * @return string Encrypted data
	 */
	public static function en($data)
	{
		return Crypto::encrypt($data);
	}

	/**
	 * Open SSL decrypt data
	 * 
	 * @param string $data Data to decrypt
	 * 
	 * @return string Decrypted data
	 */
	public static function de($data)
	{
		return Crypto::decrypt($data);
	}

	/**
	 * Create a new CSRF token to prevent cross site access
	 * @return CSRF token
	 */
	public static function getCsrf()
	{
	  	if (!self::hasSession(CSRF_KEY)) {
			$_SESSION[CSRF_KEY] = Crypto::encrypt(bin2hex(random_bytes(8)));
		}
		return $_SESSION[CSRF_KEY];
	}
  
	/**
	 * Validate CSRF token
	 * 
	 * @return bool
	 */
	public static function validateCsrf()
	{
		$request = request();
		return ($request->input(CSRF_KEY) == self::getSession(CSRF_KEY));
	}
  
	/**
	 * Clean and safe string to prevent xss and other attack
	 * @return clean data
	 */
	public static function safe(array $inputs)
	{
		foreach ($inputs as $key => $input) {
			$safe = ( !in_array($key, CSRFS) )?filter_var(htmlspecialchars($input), FILTER_SANITIZE_STRING):$input;
			$inputs[$key] = $safe;
		}

		return $inputs;
	}

	/**
	 * Set alert message session for msg variable
	 * 
	 * @param string $msg  Message
	 * @param bool   $type Alert type
	 * 
	 * @return bool
	 */
	public static function alert($msg, $type = false)  
	{
		$_SESSION['type'] = ($type)?'alert-success':'alert-danger';
		return $_SESSION['alert'] = $msg;
	}

	/**
	 * Set old input from form
	 * 
	 * @param array $inputs  inputs
	 * 
	 * @return bool
	 */
	public static function old($inputs)  
	{
		return $_SESSION['__old'] = $inputs;
	}

	/**
	 * Date difference
	 */
	public static function dateDiff($from, $formate='m', $to = null)
	{
		$to = (is_null($to))?\date('Y-m-d H:i:s'):$to;
		$date2=date_create(\date('Y-m-d H:i:s', \strtotime($to)));
		$date1=date_create(\date('Y-m-d H:i:s', \strtotime($from)));
		$diff=date_diff($date1, $date2);
		$diff = explode(',', $diff->format('%R,%y,%m,%d,%H,%i'));
		$sy = $diff[0];
		$formate = str_replace('%', '', $formate);

		switch (strtolower($formate)) {
			case 'y':
				# Year
				$diff = $diff[1];
				break;

			case 'm':
				# Month...
				$diff = ($diff[1] * 12) + $diff[2];
				break;

			case 'd':
				# Date...
				$diff = (($diff[1] * 12) + $diff[2]) * 30 + $diff[3];
				break;

			case 'h':
				# Hours...
				$diff = ((($diff[1] * 12) + $diff[2]) * 30 + $diff[3]) * 24 + $diff[4];
				break;

			case 'i':
				# Minuts...
				$diff = (((($diff[1] * 12) + $diff[2]) * 30 + $diff[3]) * 24 + $diff[4]) * 60 + $diff[5];
				break;
			
			default:
				# Month...
				$diff = ($diff[1] * 12) + $diff[2];
				break;
		}

		return $sy.$diff;
	}

	/**
	 * Create new password hash
	 * 
	 * @param string $password Password to hash
	 * 
	 * @return string Hashed password
	 */
	public static function hashPassword($password, $bcrypt=PASSWORD_DEFAULT)
	{
		return password_hash($password, $bcrypt);
	}
}