<?php
defined('BASEPATH') or exit('No direct script access allowed');

// TODO: Dashboard Router
$Router->respond('GET', '/', function($request) : void {
    include_controller('dashboard');
    new Dashboard($request);
});

// TODO: Authentication Router
$Router->respond('GET', '/authentication', function($request) : void {
    include_controller('authentication');
    new Authentication($request);
});

// TODO: Business Router
$Router->with('/business', function() use ($Router) : void {
    include_controller('business');
    new Business($Router);
});

// TODO: Team Router
$Router->with('/teams', function() use ($Router) : void {
    include_controller('team');
    new Team($Router);
});

// TODO: Product Router
$Router->with('/products', function() use ($Router) : void {
    include_controller('product');
    new Product($Router);
});

// TODO: Sales History Router
$Router->with('/sales-history', function() use ($Router) : void {
    include_controller('sales_history');
    new SalesHistory($Router);
});

// TODO: Account Router
$Router->with('/account', function() use ($Router) : void {
    include_controller('account');
    new Account($Router);
});