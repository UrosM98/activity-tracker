<?php

declare(strict_types=1);

namespace App\Core;

final class Router
{
    private array $routes = [];

    public function add(string $method, string $path, string $controller, string $action): void
    {
        $this->routes[strtoupper($method) . ' ' . $path] = [$controller, $action];
    }

    public function get(string $path, string $controller, string $action): void
    {
        $this->add('GET', $path, $controller, $action);
    }

    public function post(string $path, string $controller, string $action): void
    {
        $this->add('POST', $path, $controller, $action);
    }

    public function dispatch(Request $request): void
    {
        $key = $request->method() . ' ' . $request->path();

        if (!isset($this->routes[$key])) {
            http_response_code(404);
            echo '404 - not found';
            return;
        }

        [$controllerClass, $action] = $this->routes[$key];
        $controller = new $controllerClass();
        $controller->{$action}($request);
    }
}