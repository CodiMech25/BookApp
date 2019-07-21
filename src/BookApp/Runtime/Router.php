<?php

namespace BookApp\Runtime;


class Router
{
    private $_routes = [];


    public function addRoute(string $uri, string $controller, string $action = 'Default'): void {
        $this->_routes[] = [
            'uri' => rtrim($uri, '/'),
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function getRoute(string $uri): ?array {
        $uri = rtrim($uri, '/');

        foreach ($this->_routes as $route) {
            if ($route['uri'] === $uri) {
                return $route;
            }
        }

        return null;
    }
}
