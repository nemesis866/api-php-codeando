<?php
/************************************************
Conexion a la base datos mediante PDO

Proyecto: API Rest Full - Codeando.org
Author: Paulo Andrade
Email: source.compug@mail.com
Web: http://www.pauloandrade1.com
************************************************/

// Verificamos si la constante de seguridad esta definida
if(!defined('SEGURIDAD')) die('Acceso denegado');

// Creamos la funcion para conectar a la base de datos
function getConnection()
{
	try{
		// Variables para la conexion a base de datos
		if($_SERVER['SERVER_NAME'] == 'api.dev'){
			$host = 'localhost';
			$user = 'root';
			$pass = '';
			$db = 'codeando';
		} else {
			$host = 'localhost';
			$user = '';
			$pass = '';
			$db = '';
		}

		// Instanciamos un objeto PDO
		$gdb = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
		// Agregamos atributos para manejar errores
		$gdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $err){
		echo 'Error: '.$err->getMessage();
	}

	// Retornamos el objeto
	return $gdb;
}