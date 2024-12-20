<?php

namespace Kelompok2\SistemTataTertib\App;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Router
{

    private static array $routes = [];

    private static function add(string $method,
                               string $path,
                               string $controller,
                               string $function,
                               array  $middlewares = []): void
    {
        self::$routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'function' => $function,
            'middleware' => $middlewares
        ];
    }

    public static function get(string $path,
                               string $controller,
                               string $function,
                               array  $middlewares = []): void
    {
        self::add('GET', $path, $controller, $function, $middlewares);
    }

    public static function post(string $path,
                                string $controller,
                                string $function,
                                array  $middlewares = []): void
    {
        self::add('POST', $path, $controller, $function, $middlewares);
    }

    public static function run(): void
    {
        $path = '/';
        if (isset($_SERVER['PATH_INFO'])) {
            $path = $_SERVER['PATH_INFO'];
        }

        $method = $_SERVER['REQUEST_METHOD'];

        foreach (self::$routes as $route) {
            $pattern = "#^" . $route['path'] . "$#";
            if (preg_match($pattern, $path, $variables) && $method == $route['method']) {

                // call middleware
                foreach ($route['middleware'] as $middleware){
                    $instance = new $middleware;
                    $instance->before();
                }

                $function = $route['function'];
                $controller = new $route['controller'];
                // $controller->$function();

                array_shift($variables);
                call_user_func_array([$controller, $function], $variables);

                return;
            }
        }

        http_response_code(404);
        View::render('404', [
            'title' => '404 Not Found'
        ], false);
    }

}