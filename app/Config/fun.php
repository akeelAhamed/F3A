<?php

use App\Helpers\Route;
use App\Libraries\Utill;

/**
 * Gets BASE URL
 *
 * @return string
 */
function baseUrl()
{
    $currentPath = $_SERVER['PHP_SELF'];
    $pathInfo = pathinfo($currentPath);
    $hostName = $_SERVER['HTTP_HOST'];
    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';
    return $protocol.$hostName.'/'.basename(getcwd()).'/';
}

/**
 * Generate a url for application
 * 
 * @param null $url Path
 */
function url($url=null, $return=false)
{
	$url = ($url != null)?$url:'';
	$url = ROOT_URL.$url;
	if($return){
		return $url;
	}
	echo $url;
}

/**
 * Generate an asset path for application 
 * 
 * @param string $url    Path
 * @param bool   $return Is to return or echo
 */
function asset($path, $return=false)
{
	if (filter_var($path, FILTER_VALIDATE_URL) === FALSE) {
		$file = str_replace('/', DS, $path);
		$file = ROOT_DIR.'assets'.DS .$file;
		$path = ROOT_URL.'assets/'.$path;
		if(is_file($file)){
			$path .= (!empty($path))?'?version='.VERSION:'';
		}
	}
	
	if($return){
		return $path;
	}
	echo $path;
}

/**
 * Redirect to a route
 * 
 * @param string $to      Path
 * @param string|array  $message Redirect with message
 * @param bool   $danger  Error | Message
 * 
 * @return redirect
 */
function redirect($to='', $message='', $success=false)
{
	$to = ($to == '')?'./':$to;
	$to = filter_var($to, FILTER_VALIDATE_URL)?$to:url($to, true);
	if($message !== ''){
		$message = (is_array($message))?$message:[$message];
		Utill::alert($message, $success);
	}
	echo ('<script type="text/javascript">window.location.href = "'.$to.'";</script>');
}

/**
 * Go to previous page
 * 
 * @param string|array  $message Redirect with message
 * @param bool   $danger  Error | Message
 * 
 * @return redirect
 */
function back($message='', $success=false)
{
	if($message !== ''){
		$message = (is_array($message))?$message:[$message];
		Utill::alert($message, $success);
	}
	echo ('<script type="text/javascript">window.history.go(-1);</script>');
}

/**
 * Similar to laravel DD Die function
 */
function dd(...$agrs)
{
	for ($i=0; $i < count($agrs); $i++) { 
		if($agrs[$i] !== null){
			echo '<div style="background: #000;color: #FFF;white-space: pre;word-break: break-word;padding: 0rem 0.2rem;border: 2px solid #8BC34A;margin-bottom: 1rem;">';
			if(!is_null($agrs[$i])){
				echo var_dump($agrs[$i]);
			}
			echo '</div>';
		}
	}
	
	die();
}

/**
 * Abort operation
 *
 * @param int $code
 * @return void
 */
function abort($code=404)
{
	Route::terminate($code);
	die();
}

/**
 * Include a view from view 
 * 
 * @param string $view
 * @param array $parameters
 * 
 * @return mixed
 */
function include_view($view, $parameters = array())
{
	return \App\Helpers\View::render($view, $parameters, false, true);
}

/**
 * Encrytion function
 * 
 * @param bool $echo Echo
 */
function en($data, $echo=true)
{
	$e = Utill::en($data);
	if($echo){
		echo $e;
	}
	return $e;
}

/**
 * Decrytion function
 * 
 * @param bool $echo Echo
 */
function de($data, $echo=true)
{
	$e = Utill::de($data);
	if($echo){
		echo $e;
	}
	return $e;
}

/**
 * CSRF token generator
 */
function getCsrf($e=false)
{
	$csrf = Utill::getCsrf();
	if($e){
		echo $csrf;
		return;
	}
	return $csrf;
}

/**
 * Return form CSRF field
 * 
 * @param string $slug Type of request
 * 
 * @return CSRF AND API Field
 */
function csrf($slug=null)
{
	echo '<input type="hidden" name="slug" value="'.$slug.'" readonly/><input type="hidden" name="'.CSRF_KEY.'" value="'.getCsrf().'" readonly/>';
}

/**
 * Get public folder
 *
 * @return string
 */
function public_folder()
{
	return getcwd().'/assets/';
}