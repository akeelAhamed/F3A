<?php 

namespace App\Helpers;

class View
{
    /**
     * Views directory path
     *
     * @var string
     */
    private static $path = ROOT_DIR.'/views';

    /**
     * Render a view
     *
     * @param string $view
     * @param array $parameters
     * @param bool  $return
     * @param bool  $isInclude
     * 
     * @return mixed
     */
    public static function render($view, $parameters = array(), $return=false, $isInclude=false)
    {
        $view = \str_replace('.', '/', $view).'.php';
        $file = self::$path . '/' . $view;
        if(!$isInclude){
            # not for include view
            $file = is_file($file)?$file:self::$path . '/' . 'errors/404.php';
        }
        return self::getContents($file, $parameters, $return);
    }

    /**
     * Get contents of the view
     *
     * @param string $file
     * @param array $parameters
     * @param bool  $return
     * 
     * @return mixed
     */
    public static function getContents($file, $parameters = array(), $return=false) 
    {
        $parameters['_url'] = \App\Helpers\Route::$current;
        
        extract($parameters, EXTR_SKIP);
        unset($parameters);

        ob_start();
        require $file;
        unset($file);
        
        $html = ob_get_clean();
        if($return){
            return $html;
        }
        echo($html);
    }
}