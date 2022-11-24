<?php

class Controller
{
    private array $vars = [];
    protected object $request;
    private string $layout = "default";
    private $rendered = false;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function render(string  $viewName)
    {
        if ($this->rendered) {
            return false;
        }
        extract($this->vars);
        if (strpos($viewName, "/") === 0) {
            $viewPath = ROOT . "views" . DS . $viewName . ".php";
        } else {
            $viewPath = ROOT . "views" . DS . $this->request->controller . DS . $viewName . ".php";
        }
        ob_start();
        require $viewPath;
        $content_for_layout = ob_get_clean();
        require ROOT . "views" . DS . "layout" . DS . $this->layout . ".php";
        $this->rendered = true;
    }

    public function set($key, string $value = null)
    {
        if (is_array($key)) {
            $this->vars += $key;
        } else {
            $this->vars[$key] = $value;
        }
    }
}
