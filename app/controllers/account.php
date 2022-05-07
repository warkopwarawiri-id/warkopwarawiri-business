<?php
defined('BASEPATH') or exit('No direct script access allowed');

// TODO: Account Controller
class Account extends \BaseController {
    function __construct($Router) {
        $Router->respond('GET', '/profile', function($request) {
            parent::__construct($request);
            $this->profile();
        });
    }

    private function profile() : void {
        echo "profile of account page";
    }
}