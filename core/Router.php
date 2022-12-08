<?php

class Router
{
    static array $routes = [];  // Contient les infos sur les routes
    public object $request;     //Objet request de notre appli
    public string $url;         //url entree par l'utilisateur
    static $prefixes = [];

    public static function prefix($url, $prefix)
    {
        self::$prefixes[$url] = $prefix;
    }

    /**
     * Permet de parser une url
     * @param string $url       | Url a parser
     * @param object $request   | Objet request
     * @return array contenant les parametres
     */
    public static function parse(string $url, object $request)
    {
        $url = trim($url, "/");

        if (empty($url)) {
            $url = Router::$routes[0]["url"];
            // debug("Regarder \"<b>//line 20</b> |<b>Conf.php</b> \" pour corriger l'erreur!");
        }
        // On verifie si l'on tombe dans l'une des regles du catcher
        foreach (Router::$routes as $k => $v) {
            if (preg_match($v["catcher"], $url, $match)) {
                $request->controller = $v["controller"];
                $request->action = isset($match["action"]) ? $match["action"] : $v["action"];
                $request->params = [];
                foreach ($v["params"] as $k => $v) {
                    $request->params[$k] = $match[$k];
                }
                if (!empty($match["args"])) {
                    $request->params += explode("/", trim($match["args"], "/"));
                }
                return $request;
            }
        }

        $params = explode("/", $url);

        if (in_array($params[0], array_keys(self::$prefixes))) {
            $request->prefix = self::$prefixes[$params[0]];
            array_shift($params);
        }

        $request->controller = $params[0];
        $request->action = isset($params[1]) ? $params[1] : "index";
        $request->params = array_slice($params, 2);
        return true;
    }

    /**
     * Undocumented function
     *
     * @param string $redir | Url final de [redirection]
     * @param string $url   | Url de depart 
     * @return void
     */
    public static function connect(string $redir, string $url)
    {
        $r = [];
        $r["params"] = [];
        $r["url"] = $url;
        $r["redir"] = $redir;   # Url final

        $r["origin"] = str_replace(":action", "(?P<action>([a-z0-9]+))", $url);
        // Router::connect("/post/:slug-:id", "posts/view/id:(?P<id>[0-9]+)/slug:(?P<slug>[a-z0-9\-]*)");
        $r["origin"] = preg_replace("/([a-z0-9]+):([^\/]+)/", "$1:(?P<$1>$2)", $r["origin"]);
        // On retire les "/", on les remplace par des "\"
        $r["origin"] = "/^" . str_replace("/", "\/", $r["origin"]) . "(?P<args>\/?.*)$/";

        // On explose la chaine(url) originele
        $params = explode("/", $url);
        foreach ($params as $k => $v) {
            if (strpos($v, ":")) {
                $p = explode(":", $v);
                $r["params"][$p[0]] = $p[1];
            } else {
                if ($k == 0) {
                    $r["controller"] = $v;
                } elseif ($k == 1) {
                    $r["action"] = $v;
                }
            }
        }

        $r["catcher"] = $redir;
        $r["catcher"] = str_replace(":action", "(?P<action>([a-z0-9]+))", $r["catcher"]);
        foreach ($r["params"] as $k => $v) {
            $r["catcher"] = str_replace(":$k", "(?P<$k>$v)", $r["catcher"]);
        }
        $r["catcher"] = "/^" . str_replace("/", "\/", $r["catcher"]) . "(?P<args>\/?.*)$/";

        self::$routes[] = $r;
        // debug($r);
    }

    /**
     * url | Permet d'afficher les url
     * @param string $url   | Url a afficher
     * @return void
     */
    public static function url(string $url)
    {
        // On parcours toutes les regles
        foreach (self::$routes as $v) {
            //On verifir si l'url entree par l'utilisateur matche avec $r['origin']
            if (preg_match($v["origin"], $url, $match)) {
                // On parcours tous les match et on effectue les changements si l'index n'est pas numeric 
                foreach ($match as $k => $w) {
                    if (!is_numeric($k)) {  // Si l'index n'est pas numeric
                        $v["redir"] = str_replace(":$k", $w, $v["redir"]);
                    }
                }
                return BASE_URL . $v["redir"] . $match["args"];
            }
        }
        foreach (self::$prefixes as $k => $v) {
            if (strpos($url, $v) === 0) {
                $url = str_replace($v, $k, $url);
            }
        }
        return BASE_URL . $url;
    }
}
