<?php
defined('BASEPATH') or exit('No direct script access allowed');

// TODO: Authentication Controller
class Authentication extends \BaseController {
    function __construct($request) {
        parent::__construct($request);

        echo "Authentication page.";
    }
}