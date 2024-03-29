<?php

namespace App\Helpers;

class Request
{
    /**
     * Keep all the request inputs
     *
     * @var array
     */
    public $input = array();

    /**
     * Request Method
     *
     * @var string
     */
    public $method = 'GET';

    /**
     * Server header info
     *
     * @var object
     */
    public $header;

    /**
     * Holds this
     *
     * @var string
     */
    public $request;

    /**
     * Constructor
     *
     */
    public function __construct()
    {
        $this->header = new Header();
        $this->setMethod($this->header->get('REQUEST_METHOD'));
        $this->setInputs();
    }

    /**
     * Set request method
     * 
     * @param string $method HTTP Method
     *
     */
    protected function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * Set request inputs from method
     * 
     */
    protected function setInputs()
    {
        $get = $this->method == 'POST'?$_GET:[];
        global  ${'_'.$this->method};
        $this->input = array_merge(${'_'.$this->method}, $_FILES, $get);
    }
    
    /**
     * Request method
     *
     * @return string
     */
    public function method()
    {
        return $this->method;
    }

    /**
     * Get all file from the input
     *
     * @param string|null $key Input key
     *  
     * @return array|null|string
     */
    public function file($key=null)
    {
        if($key != null){
            return isset($_FILES[$key])?$_FILES[$key]:null;
        }else{
            return $_FILES;
        }
    }

    /**
     * Get all inputs from the input
     *
     * @param string|null $key Input key
     *  
     * @return array|null|string
     */
    public function input($key=null)
    {
        if($key == null){
            return $this->input;
        }else{
            return $this->hasInput($key, true);
        }
    }

    /**
     * Check for the input exist
     *
     * @param string $key Input key
     * 
     * @return bool
     */
    public function hasInput($key, $echo = false)
    {
        $current = $this->input;
        $p = strtok($key, '.');

        while ($p !== false) {
            if (!isset($current[$p])) {
                return ($echo)?null:false;
            }
            $current = $current[$p];
            $p = strtok('.');
        }

        return ($echo)?$current:true;
    }

    /**
     * Returns the IPv4 address or a string containing the unmodified hostname on failure
     *
     * @return string
     */
    public function ip()
    {
        return \gethostbyname($this->header->get('HTTP_HOST'));
    }

    /**
     * Determine if the request is the result of an AJAX call.
     *
     * @return bool
     */
    public function ajax()
    {
        return $this->isXmlHttpRequest();
    }

    /**
     * Returns true if the request is a XMLHttpRequest.
     *
     * It works if your JavaScript library sets an HTTP_X_REQUESTED_WITH HTTP header.
     * It is known to work with common JavaScript frameworks:
     *
     * @see http://en.wikipedia.org/wiki/List_of_Ajax_frameworks#JavaScript
     *
     * @return bool true if the request is an XMLHttpRequest, false otherwise
     */
    public function isXmlHttpRequest()
    {
        return 'XMLHttpRequest' == $this->header->get('HTTP_X_REQUESTED_WITH');
    }
}

/**
 * Server header class
 */
class Header {

    /**
     * Server information
     * 
     */
    protected $server = [];


    public function __construct()
    {
        $this->server = $_SERVER;
    }

    /**
     * 
     * Returns a header value by name.
     *
     * @param string|null $key     The header name
     * @param string|null $default The default value
     * 
     * @return string|array|null The first header value or default value if $first is true, an array of values otherwise
     */
    public function get($key='', $default = null)
    {
        $header = $this->server;

        if ($key == '') {
            return $header;
        }

        if (!\array_key_exists($key, $header)) {
            return $default;
        }

        return $header[$key];
    }
}