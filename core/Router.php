<?php

class Router
{

  public $routes = [
    'GET' => [],
    'POST' => [],
    'PATCH' => [],
    'DELETE' => []
  ];

  public static function load($file)
  {
    $router = new static;

    require 'app/' . $file;

    return $router;
  }

  public function direct($uri, $requestMethod)
  {
    if (!isset($this->routes[$requestMethod])) {
      throw new Exception("Nessuna rotta definita per il metodo $requestMethod");
    }

    foreach ($this->routes[$requestMethod] as $route => $controllerAction) {
      // Converte la rotta in un pattern regex.
      // Utilizza preg_replace_callback per trasformare ogni segmento dinamico
      // da ":id" in una capture group nominata "(?P<id>[^/]+)"
      $pattern = preg_replace_callback('/\:([^\/]+)/', function ($matches) {
        return '(?P<' . $matches[1] . '>[^/]+)';
      }, $route);

      // Escapa le slash e aggiunge delimitatori all'espressione regolare
      $pattern = '#^' . str_replace('/', '\/', $pattern) . '$#';

      if (preg_match($pattern, $uri, $matches)) {
        // Rimuove le chiavi numeriche dall'array dei match
        $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
        // Chiama l'azione del controller passando i parametri come array associativo
        return $this->callAction($controllerAction, $params);
      }
    }

    throw new Exception("No route defined for this URI.");
  }

  protected function callAction($controllerAction, $params)
  {
    list($controller, $action) = explode('@', $controllerAction);
    $controller = new $controller;
    if (!method_exists($controller, $action)) {
      throw new Exception("{$controller} does not respond to the action {$action}");
    }
    return call_user_func_array([$controller, $action], [$params]);
  }

  public function get($uri, $controller)
  {
    $this->routes['GET'][$uri] = $controller;
  }
  public function post($uri, $controller)
  {
    $this->routes['POST'][$uri] = $controller;
  }
  public function patch($uri, $controller)
  {
    $this->routes['PATCH'][$uri] = $controller;
  }
  public function delete($uri, $controller)
  {
    $this->routes['DELETE'][$uri] = $controller;
  }
}
