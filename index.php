<?php

require __DIR__ . '/vendor/autoload.php';

use App\Router;




session_start();
// header("Access-Control-Allow-Origin: http://localhost:3000");
// require_once("./autoloader.php");

// We wanna make sure we get the last part of the link so here we go
// Tip By Maxime Maisonas
define('BASE_URI', str_replace('\\', '/', substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT']))));

$uri = str_replace(BASE_URI, '', $_SERVER['REQUEST_URI']);



$router = new Router;
$router->route($uri);
