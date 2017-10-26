<?php
/************************************************
Archivo principal del API

Proyecto: API Rest Full - Codeando.org
Author: Paulo Andrade
Email: source.compug@mail.com

Nota: Guia de cambios https://www.slimframework.com/docs/start/upgrade.html
************************************************/

// Definimos la constante de seguridad
define('SEGURIDAD', true);

// Incorporamos las clases Request y Response
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// Cargamos el framework slim
require __DIR__.'/../vendor/autoload.php';

// Configuracion de la app
$config = [
    'displayErrorDetails' => true,
    'addContentLengthHeader' => false,
    'db' => [
        'host' => 'localhost',
        'user' => 'root',
        'pass' => 'root',
        'dbname' => 'codeando'
    ]
];

// Creamos la aplicacion
$app = new \Slim\App(['settings' => $config]);

// Contenedor de dependencias
require_once __DIR__.'/app/container/container.php';

/*
// Access-Control headers are received during OPTIONS requests
if(isset($_SERVER['HTTP_ORIGIN'])){
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache para 1 dia
}
if($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])){
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");         
    }

    if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])){
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    }
}
*/

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

// Incluimos los archivos de la aplicacion
//require_once 'app/db.php';
//require_once 'app/hook.php';
//require_once 'app/middleware/middleware.php';
//require_once 'app/filters.php';
require_once 'app/routes/routes.php';
require_once 'app/routes/routes_recursos.php';

// Corremos la aplicacion
$app->run();
