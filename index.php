<?php
/**
 * Session Started
 */
session_start();

/**
 * Autoload Classes
 */
require 'vendor/autoload.php';

/**
 * Require configuration file
 */
require 'app/config.php';

/**
 * Require routes file
 */
require 'app/routes.php';

/**
 * App bootstrap
 */
require 'app/bootstrap.php';