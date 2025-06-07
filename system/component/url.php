<?php

     function get_protocol(){
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    }
    function get_host(){
        return $_SERVER['HTTP_HOST'];
    }
    function get_uri(){
        return parse_url($_SERVER['REQUEST_URI'])["path"];
    }
    function url($path = ""){
        $host = get_host(); 
        $requestUri = get_uri();
        $server_protocol = get_protocol();
        return "$server_protocol://$host/$path";
    }
    function is_url($path = ""){
        return get_uri() === "/$path"? true: false;
    }
    function get_full_url(){
        $host = get_host(); 
        $requestUri = get_uri();
        $server_protocol = get_protocol();
        $fullUrl = "$server_protocol://$host$requestUri";

        return $fullUrl; 
    }