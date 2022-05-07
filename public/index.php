<?php

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('BASEPATH', dirname(__DIR__));
define('APPPATH', BASEPATH . DIRECTORY_SEPARATOR . 'app');
define('PUBLICPATH', BASEPATH . DIRECTORY_SEPARATOR . 'public');
define('DISTPATH', BASEPATH.DIRECTORY_SEPARATOR . 'dist');

require_once APPPATH . '/core/application.php';

new Application();