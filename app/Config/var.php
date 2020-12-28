<?php

/**
 * All configuration variables goes here(Should be on top)
 * ROOT should be defined before include config.php for every pages.
 */

 /**
  * Author url
  */
define('AUTHOR', '<p>Powered by <a href="https://www.linkedin.com/in/i-m-ahamed" style="color:#37b914;text-decoration: underline;">A<sup>3</sup></a></p>');

define('APP_NAME' , 'F3A'); // APP NAME

define('VERSION' , 1.0); // APP VERSION

define('APP_ENV' , '0'); // 0 => local | 1 => production

$prefix = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

$WEBSITE = "$prefix$_SERVER[REQUEST_URI]";

define('WEBSITE', $WEBSITE);// current url

define('ADMIN', 'WR$^124erye#%!dftioc3q#%#QV66$W&$');

define('ROOT_URL', $prefix.substr($_SERVER['PHP_SELF'], 0, - (strlen($_SERVER['SCRIPT_FILENAME']) - strlen(ROOT_DIR))));

define('PRE' , 'F3A'); // Prefix value for some variables

define('KEY' , 'QWtlZWwgYWhhbWVkIHRoZSB3ZWIgZGV2ZWxvcGVy'); // Application Key

define('SALT' , 'YWtlZWwgYWhhbWVkIHByb2plY3QgNg=='); // Salt for security

define('SALT_LENGTH' , strlen(SALT)); // Salt length

define('LOGIN_KEY' , 'clientserverplatformlsk$@'); // LOGIN SESSION KEY

define('CSRF_KEY' , PRE.'token'); //   CSRF SESSION KEY VALUE

define('CSRF_FORM' , PRE.'ftoken'); // NAME OF THE CSRF input field(SHOULD BE WITH EVERY REQUEST)

define('REQUEST_TYPE' , PRE.'rtype'); //IDENTIFY REQUEST FROM CLIENT(SHOULD BE WITH EVERY REQUEST AFTER LOGIN)

define('CSRFS', array(CSRF_KEY, CSRF_FORM)); // csrf keys that do not want to safe

/**
 * Database Hostname
 */
define('DB_HOST', 'localhost');

/**
 * Database Name
 */
define('DB_NAME', 'angler');

/**
 * Database Username
 */
define('DB_USER', 'root');

/**
 * Database Password
 */
define('DB_PASSWORD', '');

/**
 * Base URL of the site
 * 
 * Note: Place websiite's entry point URL 
 * if it's being hosted from subdirectory in the server
 */
define('BASE_URL', baseUrl());

/**
 * Google reCAPTCHA site key
 */
define('CAPTCHA_SITEKEY', '');

/**
 * Google secret  site key
 */
define('CAPTCHA_SECRETKEY', '');

//// CUSTOM CONFIG VARIABLE ////