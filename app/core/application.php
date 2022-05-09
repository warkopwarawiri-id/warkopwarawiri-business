<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Application {
    function __construct()
    {
        self::_load_requirements();
        self::_load_helpers();
        self::_init_main();

        self::_load_router(new \Klein\Klein());
    }

    private function _init_main() : void {
        define('ENVIRONMENT', isset($_ENV['ENVIRONMENT']) ? $_ENV['ENVIRONMENT'] : 'development');

        switch (ENVIRONMENT) {
            case 'development':
                error_reporting(E_ALL);
                ini_set('display_errors', TRUE);
                ini_set('display_startup_errors', TRUE);

                if (is_dir(public_dist())) {
                    if ($handle = opendir(public_dist())) {
                        $i = 0;
                        while (false !== ($entry = readdir($handle))) {
                            if ($entry != "." && $entry != "..") {
                                $i++;
                            }
                        }
                        closedir($handle);
            
                        if ($i > 10) {
                            if ($handle = opendir(public_dist())) {
                                while (false !== ($entry = readdir($handle))) {
                                    if ($entry != "." && $entry != ".." && $entry != 'index.html' && $entry !== 'index.php') {
                                        unlink(public_dist($entry));
                                    }
                                }
                                closedir($handle);
                            }
                        }
                    }
                }
                break;

            case 'testing':
            case 'production':
                ini_set('display_errors', 0);
                error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
                break;
            
            default:
                # code...
                break;
        }
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