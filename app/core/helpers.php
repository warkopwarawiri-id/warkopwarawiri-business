<?php
defined('BASEPATH') or exit('No direct script access allowed');

if(!function_exists('base_url')) {
    function base_url($path = '') : String {
        $base_url = $_ENV['BASE_URL'];

        return "$base_url/$path";
    }
}

if(!function_exists('main_dist')) {
    function main_dist($path = '') {
        $paths = explode('/', $path);
        $path = DISTPATH;
        foreach ($paths as $value) {
            $path .= DIRECTORY_SEPARATOR;
            $path .= $value;
        }

        return $path;
    }
}

if(!function_exists('public_dist')) {
    function public_dist($path = '') {
        $paths = explode('/', $path);
        $path = PUBLICPATH . DIRECTORY_SEPARATOR . 'dist';

        $init = "$path/index.html";
        if(!file_exists($init)) {
            mkdir($path, 0755, true);
            file_put_contents($init, '');
        }

        foreach ($paths as $value) {
            $path .= DIRECTORY_SEPARATOR;
            $path .= $value;
        }

        return $path;
    }
}

if(!function_exists('load_library')) {
    function load_library(String $name) : void {
        $library = APPPATH . "/libraries/$name.php";

        if(!file_exists($library))
            throw new Exception("No file found $library.", 1);

        include($library);
    }
}