<?php

class Controller
{
    private array $vars         = [];            // Variables a passer a la vue
    private string $layout      = "default";     // Layout a utiliser pour rendre la vue
    private $rendered           = false;         // Pour savoir si la vue a deja ete rendue
    protected object $request;                   // Object request

    /**
     * Constructeur
     * @param object $request   | Objet request de notre application
     */
    public function __construct(object $request = null)
    {
        if ($request) {
            $this->request = $request;
        }
    }

    /**
     * render | Permet de rendre une vue
     * @param string $viewName | Fichier a rendre a la vue(Nom de la vue)
     * @return void
     */
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

    /**
     * set  | Permet de passer une ou plusieurs variables a la vue
     * @param string|array $key     | Nom de la variable ou tableau de variable
     * @param string|null $value    | Valeur de la variable
     * @return void
     */
    public function set(string|array $key, string|array|object $value = null)
    {
        if (is_array($key)) {
            $this->vars += $key;
        } else {
            $this->vars[$key] = $value;
        }
    }

    /**
     * loadModel    | Permet de charger un model
     * @param string $modelName | Nom du model a charger
     * @return void
     */
    public function loadModel(string $modelName)
    {
        $modelPath = ROOT . "models" . DS . $modelName . ".php";
        require_once $modelPath;
        if (!isset($this->$modelName)) {
            $this->$modelName = new $modelName();
        }
    }

    /**
     * e4040 | Permet de gerer les erreurs 404
     * @param string $message   | Message d'erreur a afficher
     * @return void
     */
    public function e404($message)
    {
        header("HTTP/1.0 404 Not Found");
        $this->set("message", $message);
        $this->render("/errors/404");
        die();
    }

    /**
     * request | Permet d'appeller un controller depuis une vue
     * @param string $controller    |
     * @param string $action        |
     * @return void
     */
    public function request(string $controller, string $action)
    {
        $controller .= "Controller";
        require_once ROOT . "controllers" . DS . $controller . ".php";
        $c = new $controller();
        return $c->$action();
    }

    /**
     * Redirect     | Permet de rediriger un user vers la bonne page
     * @param string $url   | Url correct vers lequel on redirige l'utilisateur
     * @param int $code     | Code de redirection
     * @return void
     */
    public function redirect($url, $code)
    {
        if ($code == 301) {
            header("HTTP/1.1 Moved Permanently");
        }
        header("Location: " . Router::url($url));
        debug($code);
    }
}
