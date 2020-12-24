<?php

define('DS', DIRECTORY_SEPARATOR); // Directory separotor

define('ROOT_DIR' , getcwd().DS); // root directory

define('APP_DIR' , ROOT_DIR.'app'.DS); // app directory

/**
 * Include some more spice
 */
require APP_DIR.'Config/fun.php';

require APP_DIR.'Config/var.php';