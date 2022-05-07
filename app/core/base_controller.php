<?php
defined('BASEPATH') or exit('No direct script access allowed');

// TODO: Base Controller
class BaseController {
    protected Object $request;

    private Array $cdn_css = array();
    private Array $cdn_js = array();
    private Array $included_css = array();
    private Array $included_js = Array();

    function __construct($request) {
        $this->request = $request;
    }

    protected function render($view) : void {
        load_library('asset_minifier');

        $loader = new \Twig\Loader\FilesystemLoader(APPPATH . '/views/');
        
        if($_ENV['ENVIRONMENT'] == 'development') {
            $twig = new \Twig\Environment($loader);
        } else {
            $twig = new \Twig\Environment($loader, [
                'cache' => APPPATH . '/views/.cache/',
            ]);
        }

        $this->include_js('https://code.jquery.com/jquery-3.6.0.min.js', true);
        $data = array(
            'css' => base_url(AssetMinifier::create($this->included_css, 'css')),
            'js' => base_url(AssetMinifier::create($this->included_js, 'js')),
            'cdn_css' => $this->cdn_css,
            'cdn_js' => $this->cdn_js,
            'settings' => [
                'base_url' => base_url()
            ]
        );

        exit($twig->render("$view.html", $data));
    }

    protected function include_css($files, bool $is_cdn = false, String $type = 'stylesheet') : void {
        if(is_string($files)) {
            if($is_cdn || filter_var($files, FILTER_VALIDATE_URL)) {
                array_push($this->cdn_css, ["type" => "$type", "url" => $files]);
                $this->cdn_css = array_unique($this->cdn_css);
            } else {
                self::include_css([$files]);
            }
        } else {
            $this->included_css = array_merge($this->included_css, $files);
            $this->included_css = array_unique($this->included_css);
        }
    }

    protected function include_js($files, bool $is_cdn = false, String $type = 'text/javascript') : void {
        if(is_string($files)) {
            if($is_cdn || filter_var($files, FILTER_VALIDATE_URL)) {
                array_push($this->cdn_js, ["type" => "$type", "url" => "$files"]);
                $this->cdn_js = array_unique($this->cdn_js);
            } else {
                self::include_js([$files]);
            }
        } else {
            $this->included_js = array_merge($this->included_js, $files);
            $this->included_js = array_unique($this->included_js);
        }
    }
}