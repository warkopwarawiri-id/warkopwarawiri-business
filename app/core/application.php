<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Application {
    function __construct()
    {
        self::_load_requirements();
        self::_load_helpers();

        self::_load_router(new \Klein\Klein());
    }

    private function _load_requirements() : void {
        $autoload_file = BASEPATH . '/vendor/autoload.php';
        if(!file_exists($autoload_file))
            throw new Exception("You have not installed the required dependencies. make sure you have run 'composer install' first.", 1);

        require_once $autoload_file;

        $dotenv = Dotenv\Dotenv::createImmutable(BASEPATH);
        $dotenv->load();
    }

    private function _load_helpers() : void {
        require_once APPPATH . '/core/helpers.php';
    }

    private function _load_router($Router) : void {
        function include_controller($name) : void {
            $result = APPPATH . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . "$name.php";
            if(!file_exists($result))
                throw new Exception("No file found $result.", 1);
                
            include($result);
        }

        require_once APPPATH . '/core/base_controller.php';
        require_once APPPATH . '/config/router.php';

        $Router->dispatch();
    }
}