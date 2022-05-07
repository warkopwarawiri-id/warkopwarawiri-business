<?php
defined('BASEPATH') or exit('No direct script access allowed');

// TODO: Product Controller
class Product extends \BaseController {
    function __construct($Router) {
        $Router->respond('GET', '', function($request) {
            parent::__construct($request);
            $this->main();
        });
    }

    private function main() : void {
        echo "page of main product";
    }
}