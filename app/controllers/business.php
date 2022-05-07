<?php
defined('BASEPATH') or exit('No direct script access allowed');

// TODO: Business Controller
class Business extends \BaseController {
    function __construct($Router) {
        $Router->respond('GET', '/add-new', function($request) {
            parent::__construct($request);
            $this->add_business();
        });

        $Router->respond('GET', '/[:slug]/info', function($request) {
            parent::__construct($request);
            $this->info($request->slug);
        });
    }

    private function add_business() : void {
        echo "create new business";
    }

    private function info(String $slug) : void {
        echo "fetch detail business with slug <b>$slug</b>";
    }
}