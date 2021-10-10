<?php

namespace app\core;

use app\core\exception\NotFoundException;
use Exception;

class Router
{
    protected $routes = [];
    public Request $request;
    public Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback)
    {
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['POST'][$path] = $callback;
    }

    public function renderView($view, $params = [])
    {
        include_once Application::$ROOT_DIR . "/views/$view.php";
    }

    public function resolve()
    {




        $method = $this->request->getMethod();
        $path = $this->request->getPath();

        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            throw new NotFoundException();
        }

        if (is_string($callback)) {
            return $this->renderView($callback);
        }

        if (is_array($callback)) {
            Application::$app->controller = new $callback[0]();
            Application::$app->controller->action = $callback[1];
            $callback[0] = Application::$app->controller;

            foreach (Application::$app->controller->getMiddlewares() as $middleware) {
                $middleware->execute();
            }

            // $callback[0] = new $callback[0]();
        }

        return call_user_func($callback, $this->request);
    }
}
