<?php
/************************************************
Contenedor para las dependencias de la App

Proyecto: API Rest Full - Codeando.org
Author: Paulo Andrade
Email: source.compug@mail.com
************************************************/

// Verificamos si la constante de seguridad esta definida
if(!defined('SEGURIDAD')) die('Acceso denegado');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Cargamos el framework slim
require __DIR__.'/../../../vendor/autoload.php';

// Obtenemos el contenedor de la app
$container = $app->getContainer();

// Dependencia para conexion a base de datos
$container['db'] = function ($c){
	$db = $c['settings']['db']; // Obtenemos la configuracion de db
	// Creamos la conexion a la base de datos
	$pdo = new PDO("mysql:host=".$db['host'].";dbname=".$db['dbname'], $db['user'], $db['pass']);
	// Controlamos los errores
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// Devolvemos que cada fila sea deuelta como un array asociativo
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	// Retornamos la conexion
	return $pdo;
};

// Dependencia para plantillas
$container['view'] = new \Slim\Views\PhpRenderer(__DIR__."/../../../templates/");

// Dependencia para PHPMailer
$container['mailer'] = function ($c) {
	$mailer = new PHPMailer(true); // Creamos una nueva instancia

	$mailer->isSMTP();
	$mailer->Host = 'smtp.gmail.com';  // host
	$mailer->SMTPAuth = true; // Requiere autentificacion (false para localhost)
	$mailer->SMTPSecure = 'tls'; // Seguridad
	$mailer->Port = 587; // 25 for local host
	$mailer->Username = 'source.compu@gmail.com';
	$mailer->Password = 'Samuel866';
	$mailer->isHTML(true); // Activamos soporte para html

	return new Mailer($c->view, $mailer);
};

// Dependencia para sesiones
$container['session'] = function ($c) {
  return new \SlimSession\Helper;
};