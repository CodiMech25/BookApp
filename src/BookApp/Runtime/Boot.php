<?php

namespace BookApp\Runtime;


class Boot
{
    private $_router;


    public function __construct(Router $router) {
        $this->_router = $router;
    }

    public function start(): void {
        $uri = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : null;

        if (isset($_SERVER['QUERY_STRING'])) {
            $uri = str_replace('?' . $_SERVER['QUERY_STRING'], '', $uri);
        }

        if ($uri !== null && ($route = $this->_router->getRoute($uri))) {
            $controller_class = '\BookApp\Control\\' . $route['controller'];
            $controller_file = __DIR__ . '/../Control/' . $route['controller'] . '.php';
            $action_name = 'action' . $route['action'];

            if (is_file($controller_file)) {
                require_once($controller_file);

                if (class_exists($controller_class) && method_exists($controller_class, $action_name)) {
                    $controller = new $controller_class($route['controller'], $route['action']);
                    $controller->{$action_name}();
                    return;
                }
            }
        }

        http_response_code(404);
        return;
    }
}
