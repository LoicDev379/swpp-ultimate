<?php

class Request
{
    public string $url;    //url entree par l'utilisateur

    public function __construct()
    {
        $this->url = trim($_SERVER["PATH_INFO"], "/");
    }
}
