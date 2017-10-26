<?php
/************************************************
Contenedor para las dependencias de la App

Proyecto: API Rest Full - Codeando.org
Author: Paulo Andrade
Email: source.compug@mail.com
************************************************/

// Verificamos si la constante de seguridad esta definida
if(!defined('SEGURIDAD')) die('Acceso denegado');

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