<?php
/************************************************
Creamos las rutas de la aplicación

Proyecto: API Rest Full - Codeando.org
Author: Paulo Andrade
Email: source.compug@mail.com
************************************************/

// Verificamos si la constante de seguridad esta definida
if(!defined('SEGURIDAD')) die('Acceso denegado');

// Incorporamos las clases Request y Response
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// Cargamos el framework slim
require __DIR__.'/../../../vendor/autoload.php';

// Ruta principal
$app->get('/', function (Request $req, Response $res, $args = []){
	//return $this->view->render($res, 'register.phtml',[]);
	return $res->write('Hello API');
	//$res->render('index.php', array('title_page'=>'Bienvenidos | '));
});