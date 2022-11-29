<?php

class Conf
{
    public static $debug = 1;
    public static $databases = [
        "default" => [
            "host"      => "localhost",
            "login"     => "loicdev",
            "passwd"  => "pwdroot",
            "dbname"    => "swpp"
        ]
    ];
}

// [REGLE] | Permet de connecter deux url
// Router::connect("/post/:slug-:id", "posts/view/id:(?P<id>[0-9]+)/slug:(?P<slug>[a-z0-9\-]*)");
// Router::connect("post/:slug-:id", "posts/view/id:([0-9]+)/slug:([a-z0-9\-]+)");

// Router::connect("/", "posts/index");
Router::connect("blog/:slug-:id", "posts/view/id:([0-9]+)/slug:([a-z0-9\-]+)");
Router::connect("blog/:action", "posts/:action");   // Pour rediriger tous le controller "posts" sur "blog"
