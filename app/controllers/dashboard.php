<?php
defined('BASEPATH') or exit('No direct script access allowed');

// TODO: Dashboard Controller
class Dashboard extends \BaseController {
    function __construct($request) {
        parent::__construct($request);

        $this->include_css([
            main_dist('css/tabler.min.css'),
            main_dist('css/tabler-flags.min.css'),
            main_dist('css/tabler-payments.min.css'),
            main_dist('css/tabler-vendors.min.css'),
            main_dist('css/demo.min.css')
        ]);

        $this->include_js([
            main_dist('libs/apexcharts/dist/apexcharts.min.js'),
            main_dist('libs/jsvectormap/dist/js/jsvectormap.min.js'),
            main_dist('libs/jsvectormap/dist/maps/world.js'),
            main_dist('libs/jsvectormap/dist/maps/world-merc.js'),
            main_dist('js/tabler.min.js'),
            main_dist('js/demo.min.js'),

            main_dist('js/pages/dashboard.js'),
        ]);

        $this->render('pages/dashboard/dashboard');
    }
}