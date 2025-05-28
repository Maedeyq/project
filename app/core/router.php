<?php

namespace App\Core;

class Router
{
    protected $routes = [];

    /**
     * 
     * @param string $uri
     * @param mixed $callback (string Controller@method or callable function)
     */
    public function get($uri, $callback)
    {
        $this->addRoute('GET', $uri, $callback);
    }

    /**
     * 
     * @param string $uri
     * @param mixed $callback (string Controller@method or callable function)
     */
    public function post($uri, $callback)
    {
        $this->addRoute('POST', $uri, $callback);
    }

    /**
     *
     * @param string $method
     * @param string $uri
     * @param mixed $callback
     */
    protected function addRoute($method, $uri, $callback)
    {
        
        $uri = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([a-zA-Z0-9_]+)', $uri);
        $this->routes[$method][$uri] = $callback;
    }

    /**
     * 
     * @param string $uri
     * @param string $method
     */
    public function dispatch($uri, $method)
    {
       
        $uri = strtok($uri, '?');
      
       
        if (empty($uri)) {
            $uri = '/';
        }

        if (array_key_exists($method, $this->routes)) {
            foreach ($this->routes[$method] as $routeUri => $callback) {
                // مقایسه URI با الگوهای Regex
                if (preg_match("#^" . $routeUri . "$#", $uri, $matches)) {
                    array_shift($matches); // حذف اولین عنصر (full match)

                    if (is_callable($callback)) {
                        call_user_func_array($callback, $matches);
                    } elseif (is_string($callback)) {
                        // فرض می‌کنیم Callback به شکل "ControllerName@methodName" است
                        list($controller, $method) = explode('@', $callback);
                        $controllerName = "App\\Controllers\\" . $controller;

                        if (class_exists($controllerName)) {
                            $controllerInstance = new $controllerName();
                            if (method_exists($controllerInstance, $method)) {
                                call_user_func_array([$controllerInstance, $method], $matches);
                                return;
                            }
                        }
                    }
                }
            }
        }


        $this->abort404();
    }

    protected function abort404()
    {
        http_response_code(404);
        echo "404 Not Found";
        exit;
    }
}

