<?php

class Dispatcher
{
    private object $request;

    public function __construct()
    {
        $this->request = new Request();
        Router::parse($this->request->url, $this->request);
        $controller = $this->loadController();

        $action = $this->request->action;
        if ($this->request->prefix) {
            $action = $this->request->prefix . "_" . $action;
        }

        if (!in_array($action, array_diff(get_class_methods($controller), get_class_methods(get_parent_class($controller))))) {
            $this->error("Le controller <b>" . $this->request->controller . "</b> n'a pas de methode <b>" . $action . "</b>");
        }
        call_user_func_array([$controller, $action], $this->request->params);
        $controller->render($action);
    }

    public function loadController()
    {
        $controllerName = ucfirst($this->request->controller) . "Controller";
        require ROOT . "controllers" . DS . $controllerName . ".php";
        $controller = new $controllerName($this->request);
        // Initialisation d'une nouvelle session
        $controller->Session = new Session();
        $controller->Form = new Form($controller);

        return $controller;
    }

    public function error($message)
    {
        $controller = new Controller($this->request);
        $controller->Session = new Session();
        $controller->e404($message);
    }
}

// Ultimate Project | Using PHP(OOP) for Back-end and a little (Bootstrap, CSS, JS) for Front-end
