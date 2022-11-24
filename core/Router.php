<?php

class Router
{
    public string $url;         //url entree par l'utilisateur
    public object $request;     //Objet request de notre appli

    /**
     * Permet de parser une url
     *
     * @param string $url       | Url a parser
     * @param object $request   | Objet 
     * @return array contenant les parametres
     */
    public static function parse(string $url, object $request)
    {
        $params = explode("/", $url);

        $request->controller = $params[0];
        $request->action = isset($params[1]) ? $params[1] : "index";
        $request->params = array_slice($params, 2);
    }
}
