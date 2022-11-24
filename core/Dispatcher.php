<?php

use Router;
use Request;

class Dispatcher
{
    private object $request;

    public function __construct()
    {
        $this->request = new Request();
        Router::parse($this->request->url, $this->request);
        $controller = $this->loadController();
        if (!in_array($this->request->action, get_class_methods($controller))) {
            $this->error("Le controller <b>" . $this->request->controller . "</b> n'a pas de methode <b>" . $this->request->action. "</b>");
        }
        call_user_func_array([$controller, $this->request->action], $this->request->params);
        $controller->render($this->request->action);
    }

    public function loadController()
    {
        $controllerName = ucfirst($this->request->controller) . "Controller";
        require ROOT . "controllers" . DS . $controllerName . ".php";
        return new $controllerName($this->request);
    }

    public function error($message)
    {
        header("HTTP/1.0 404 Not Found");
        $controller = new Controller($this->request);
        $controller->set("message", $message);
        $controller->render("/errors/404");
        die();
    }
}

// Ultimate Project | Using PHP(OOP) for Back-end and a little (Bootstrap, CSS, JS) for Front-end
