<?php

    define('BASE_PATH', dirname(__DIR__));
    define('ENV_PATH', BASE_PATH.'/.env');
    require_once BASE_PATH."/system/component/url.php";
    function loadEnv($path)
    {
        if (!file_exists($path)) {
            throw new Exception(".env file not found at: " . $path);
        }
        
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lines as $line) {
            if (str_starts_with(trim($line), '#')) {
                continue;
            }
            
            list($key, $value) = explode('=', $line, 2);
            
            $value = trim($value, '"\'');
            
            putenv(trim($key) . '=' . $value);
            $_ENV[trim($key)] = $value;
            $_SERVER[trim($key)] = $value;
        }
    }
    function env($name, $default = ''){
        if(!file_exists(ENV_PATH)){
            $error_message = ".env File Not Found: ".ENV_PATH;
            require_once BASE_PATH."/system/views/server_error.view.php";
        }
        return getenv($name) !== false ? getenv($name) : $default;
    }
    function dump($data){
        echo "<pre>";
        print_r($data);
    }
    function dd($data){
        echo "<pre>";
        print_r($data);
        die();
    }
    function routeTo($controller){
        $controller_path = BASE_PATH."/controllers/$controller[0].php";
        if(!file_exists($controller_path)){
            $error_message = "Controller file not exist: $controller_path";
            require_once BASE_PATH."/system/views/server_error.view.php";
        }
        require_once $controller_path;
        if(!function_exists($controller[1])){
            $error_message = "Function not exist: $controller[1]()";
            require_once BASE_PATH."/system/views/server_error.view.php";
        }
        $controller[1]();
    }
    function route($urlpattern, $fallback = "/system/views/404.view.php"){
        $current_uri = get_uri();
        if(array_key_exists($current_uri, $urlpattern)){
            routeTo($urlpattern[$current_uri]);
        } else {
            require_once BASE_PATH.$fallback;
        }
    }
    function view($view, $data = []){
        $view_path = BASE_PATH."/views/$view.view.php";
        if(!file_exists($view_path)){
            $error_message = "View file not exist: $view_path";
            require_once BASE_PATH."/system/views/server_error.view.php";
        }
        require_once $view_path;
    }
    if(file_exists(ENV_PATH)){
        loadEnv(ENV_PATH);
    }