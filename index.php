<?php
/************************************************
Archivo principal del API

Proyecto: API Rest Full - Codeando.org
Author: Paulo Andrade
Email: source.compug@mail.com
Web: http://www.pauloandrade1.com
************************************************/

// Para sesiones
session_cache_expire(false);
session_start();

// Seguridad
if(empty($_SESSION['logged_in'])){
	$_SESSION['logged_in'] = false;
}

// Cargamos el framework slim
require_once 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

// Creamos una aplicacion
$app = new \Slim\Slim();

// Configuramos las vistas
$app->config(array(
    'templates.path' => 'app/views',
));

// Configuramos la pagina 404
$app->notFound(function () use ($app) {
    $app->render('404.php', array('title_page'=>'Página no encontrada | '));
});

// Definimos la constante de seguridad
define('SEGURIDAD', true);

// Incluimos los archivos de la aplicacion
require_once 'app/db.php';
//require_once 'app/hook.php';
require_once 'app/middleware/middleware.php';
require_once 'app/filters.php';
require_once 'app/routes/routes.php';
require_once 'app/routes/routes_recursos.php';

// Corremos la aplicacion
$app->run();
