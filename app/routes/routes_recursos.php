<?php
/************************************************
Creamos las rutas con los verbos http

Proyecto: API Rest Full - Codeando.org
Author: Paulo Andrade
Email: source.compug@mail.com
Web: http://www.pauloandrade1.com
************************************************/

// Verificamos si la constante de seguridad esta definida
if(!defined('SEGURIDAD')) die('Acceso denegado');

// Mostramos todos los cursos
$app->get('/cursos/', function () use($app){
	try{
		$conn = getConnection();
		$dbh = $conn->prepare("SELECT * FROM cursos WHERE public='YES' ORDER BY fecha ASC");
		$dbh->execute();
		$cursos = $dbh->fetchAll(PDO::FETCH_ASSOC);
		$conn = null;

		$app->response->headers->set("Content-type", "application/json");
		$app->response->headers->set("Access-Control-Allow-Origin", "*");
		$app->response->status(200);
		$app->response->body(json_encode($cursos));
	} catch (PDOException $err){
		echo 'Error: '.$err->getMessage();
	}
});

// Mostramos informacion de un curso en especifico
$app->get('/cursos/:id/', function ($id) use($app){
	try{
		$conn = getConnection();
		$dbh = $conn->prepare("SELECT * FROM cursos WHERE id_curso=:param1 AND public='YES'");
		$dbh->execute(array('param1'=>$id));
		$cursos = $dbh->fetchAll(PDO::FETCH_ASSOC);
		$conn = null;

		$app->response->headers->set("Content-type", "application/json");
		$app->response->status(200);
		$app->response->body(json_encode($cursos));
	} catch (PDOException $err){
		echo 'Error: '.$err->getMessage();
	}
});

// Mostramos las discusiones de un curso
$app->get('/cursos/:id/discusiones/', function ($id) use($app){
	try{
		$conn = getConnection();
		$dbh = $conn->prepare("SELECT * FROM discucion WHERE id_curso=:param1");
		$dbh->execute(array('param1'=>$id));
		$cursos = $dbh->fetchAll(PDO::FETCH_ASSOC);
		$conn = null;

		$app->response->headers->set("Content-type", "application/json");
		$app->response->status(200);
		$app->response->body(json_encode($cursos));
	} catch (PDOException $err){
		echo 'Error: '.$err->getMessage();
	}
});

// Mostramos una discusion en especifico
$app->get('/cursos/discusiones/:id/', function ($id) use($app){
	try{
		$conn = getConnection();
		$dbh = $conn->prepare("SELECT * FROM discucion WHERE id_discucion=:param1");
		$dbh->execute(array('param1'=>$id));
		$cursos = $dbh->fetchAll(PDO::FETCH_ASSOC);
		$conn = null;

		$app->response->headers->set("Content-type", "application/json");
		$app->response->status(200);
		$app->response->body(json_encode($cursos));
	} catch (PDOException $err){
		echo 'Error: '.$err->getMessage();
	}
});

// Mostramos las respuestas de una discusion
$app->get('/cursos/discusion/:id/respuestas/', function ($id) use($app){
	try{
		$conn = getConnection();
		$dbh = $conn->prepare("SELECT * FROM respuestas WHERE id_discucion=:param1");
		$dbh->execute(array('param1'=>$id));
		$cursos = $dbh->fetchAll(PDO::FETCH_ASSOC);
		$conn = null;

		$app->response->headers->set("Content-type", "application/json");
		$app->response->status(200);
		$app->response->body(json_encode($cursos));
	} catch (PDOException $err){
		echo 'Error: '.$err->getMessage();
	}
});

// Obtenemos registro de usuarios
$app->get('/users/:user/:password', function ($user, $password) use($app){
	try{
		$conn = getConnection();
		$dbh = $conn->prepare("SELECT * FROM usuarios WHERE username=? AND password=?");
		$dbh->execute(array(strtolower($user), md5($password)));
		$users = $dbh->fetchAll(PDO::FETCH_ASSOC);
		$conn = null;

		if(count($users) > 0){
			$conn = getConnection();
			$dbh = $conn->prepare("UPDATE usuarios SET ultimo_acceso=NOW() WHERE username=?");
			$dbh->execute(array(strtolower($user)));
			$conn = null;
		}

		$app->response->headers->set("Content-type", "application/json");
		$app->response->headers->set("Access-Control-Allow-Origin", "*");
		$app->response->status(200);
		$app->response->body(json_encode($users));
	} catch (PDOException $err){
		echo 'Error: '.$err->getMessage();
	}
});