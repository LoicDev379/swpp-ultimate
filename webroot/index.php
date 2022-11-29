<?php

$debut = microtime(true);

define("DS", DIRECTORY_SEPARATOR);
define("WEBROOT", __DIR__ . DS);
define("ROOT", dirname(WEBROOT) . DS);
define("CORE", ROOT . "core" . DS);
define("BASE_URL", dirname(dirname($_SERVER["SCRIPT_NAME"])));

require CORE . "includes.php";
new Dispatcher();

echo "<div class='microtime'>";
echo "Page générée en " . round((microtime(true) - $debut), 5) . " secondes";
echo "<div>";
