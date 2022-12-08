<?php

class Request
{
    public string $url;    //url entree par l'utilisateur
    public $page = 1;
    public $prefix = false;
    public $data;

    public function __construct()
    {
        $this->url = isset($_SERVER["PATH_INFO"]) ? $_SERVER["PATH_INFO"] : "/";
        // $this->url = trim($_SERVER["PATH_INFO"], "/");

        if (isset($_GET["page"])) {
            if (is_numeric($_GET["page"])) {
                if ($_GET["page"] > 0) {
                    $this->page = round($_GET["page"]);
                }
            }
        }
        // Si les donnees ont ete postees
        if (!empty($_POST)) {
            $this->data = new stdClass();
            foreach ($_POST as $k => $v) {
                $this->data->$k = $v;
            }
        }
    }
}
