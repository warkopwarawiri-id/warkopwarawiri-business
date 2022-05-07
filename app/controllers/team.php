<?php
defined('BASEPATH') or exit('No direct script access allowed');

// TODO: Team Controller
class Team extends \BaseController {
    function __construct($Router) {
        $Router->respond('GET', '', function($request) {
            parent::__construct($request);
            $this->main();
        });
    }

    private function main() : void {
        echo "page of main team";
    }
}