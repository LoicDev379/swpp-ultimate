<?php

/**
 * debug    | Permet de formater l'affichage
 * @param all $var  | Nom de variable, tableau ou objet a afficher
 * @return void
 */
function debug($var)
{
    if (Conf::$debug > 0) {
        $debug = (debug_backtrace());

        echo '<p>&nbsp;</p><p><a href="#" style="colo:#fff" onclick="$(this).parent().next(\'ol\').slideToggle(); return false;"><strong>' . $debug[0]["file"] . ' </strong>| ' . $debug[0]["line"] . ' </a></p>';
        echo "<ol style='display:none'>";
        foreach ($debug as $k => $v) {
            if ($k > 0) {
                echo '<li style="color:#000"><strong>' . $v["file"] . ' </strong>| ' . $v["line"] . ' </li>';
            }
        }
        echo "</ol>";
        echo "<div class='jumbotron'><pre>";
        print_r($var);
        echo "</pre></div>";
    }
}
