<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AssetMinifier {
    public static function create(Array $files, $type) {
        $fixed_files = array();

        $callback = function ($value, $key) use (&$fixed_files) {
            if (!file_exists($value))
                throw new Exception("No file found $value");

            array_push($fixed_files, $value);
            $fixed_files = array_unique($fixed_files);
        };

        array_walk_recursive($files, $callback);
        
        $combined = '';
        foreach ($fixed_files as $file) {
            $combined .= file_get_contents($file);
            $combined .= ';';
        }

        if($_ENV['ENVIRONMENT'] !== 'development') {
            switch ($type) {
                case 'css':
                    $minified = self::_get_minified($_ENV['CSS_MINIFIER_API'], $combined);
                    break;

                case 'js':
                    $minified = self::_get_minified($_ENV['JS_MINIFIER_API'], $combined);
                    break;
                
                default:
                    throw new Exception("AssetMinifier::create only css and js at type parameters.", 1);
                    break;
            }

            $combined = $minified;
        }

        $filename = md5($combined) . ".min.$type";
        if(!file_exists(public_dist($filename))) {
            file_put_contents(public_dist($filename), $combined);
        }

        return "dist/$filename";
    }

    private static function _get_minified(String $url, String $content) : String {
        $postdata = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query(['input' => $content]), 
            ]
        ];

        return file_get_contents($url, false, stream_context_create($postdata));
    }
}