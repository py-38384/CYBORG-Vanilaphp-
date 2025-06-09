<?php

    namespace System;

    class Route{
        private static $instance;
        protected $routes = [];
        private static function checkInstance(){
            if(!self::$instance){
                self::$instance = new Route();
            }
        }
        public static function get($uri, $controller){
            self::checkInstance();
            self::$instance->routes[] = [
                'url' => $uri,
                'controller' => $controller,
                'method' => 'get'
            ];
            return self::$instance;
        }
        public static function post($uri, $controller){
            self::checkInstance();
            self::$instance->routes[] = [
                'url' => $uri,
                'controller' => $controller,
                'method' => 'get'
            ];
            return self::$instance;
        }
        public static function put($uri, $controller){
            self::checkInstance();
            self::$instance->routes[] = [
                'url' => $uri,
                'controller' => $controller,
                'method' => 'get'
            ];
            return self::$instance;
        }
        public static function patch($uri, $controller){
            self::checkInstance();
            self::$instance->routes[] = [
                'url' => $uri,
                'controller' => $controller,
                'method' => 'get'
            ];
            return self::$instance;
        }
        public static function delete($uri, $controller){
            self::checkInstance();
            self::$instance->routes[] = [
                'url' => $uri,
                'controller' => $controller,
                'method' => 'get'
            ];
            return self::$instance;
        }
        public static function showRoutesArray(){
            dd(self::$instance->routes);
        }
        function replace_with_placeholders(string $pattern, string $actualUrl): string {
            // Extract placeholder names from the pattern
            preg_match_all('/\{(\w+)\}/', $pattern, $paramMatches);
            $paramNames = $paramMatches[1];

            // Convert pattern into regex to match values in the URL
            $regex = preg_replace('/\{(\w+)\}/', '([^/]+)', $pattern);
            $regex = "#^" . $regex . "$#";

            // Match actual URL to extract values
            if (preg_match($regex, $actualUrl, $valueMatches)) {
                array_shift($valueMatches); // remove full match
                $params = array_combine($paramNames, $valueMatches);

                // Replace actual values in URL with placeholders
                foreach ($params as $key => $value) {
                    $actualUrl = str_replace($value, "{" . $key . "}", $actualUrl);
                }

                return $actualUrl;
            }
            // If no match, return the original URL unchanged
            return $actualUrl;


            // Input [1] = ('user/posts/{id}/comments/{commentId}','user/posts/3/comments/38')
            // Output [1] = 'user/posts/{id}/comments/{commentId}'
            
            // Input [2] = ('user/posts/{id}','	/browse/post')
            // Output [2] = '/browse/post'

        }

        function extract_placeHolder_params($route) {
            preg_match_all('/\{(\w+)\}/', $route, $matches);
            return $matches[1]; // array of param names

            //input [1] = "user/posts/{id}/comments/{commentId}"
            //output [1] = ['id', 'commentId']
        }
        public static function get_params(string $routePattern, string $actualUrl): array {
            // Extract parameter names from the pattern
            preg_match_all('/\{(\w+)\}/', $routePattern, $paramMatches);
            $paramNames = $paramMatches[1]; // e.g. ['id', 'commentId']

            // Replace placeholders with regex to match any non-slash sequence
            $regex = preg_replace('/\{(\w+)\}/', '([^/]+)', $routePattern);
            $regex = "#^" . $regex . "$#";

            // Match the actual URL to extract values
            if (preg_match($regex, $actualUrl, $valueMatches)) {
                array_shift($valueMatches); // Remove full match
                return array_combine($paramNames, $valueMatches);
            }
            
            return [];


            //input [1] = ('user/posts/{id}/comments/{commentId}','user/posts/3/comments/38')
            //output [1] = ['id' => 3, 'commentId' => 38]
        }

        public static function redirectToRoute(){
            self::checkInstance();
            $routes = self::$instance->routes;
            $current_uri = get_uri();
            $request_method = get_request_method();
            $current_controller = null;
            foreach($routes as $route){
                if($route['url'] === $current_uri && $route['method'] === $request_method){
                    $current_controller = $route['controller'];
                }
            }
            if($current_controller){
                $className = $current_controller[0];
                $methodName = $current_controller[1];
    
                $instance = new $className();
                $instance->$methodName();
            } else {
                require_once (BASE_PATH.'/System/views/404.view.php');
            }
        }
    }