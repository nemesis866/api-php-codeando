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

// Ruta principal
$app->get('/', function () use($app){
	$app->render('index.php');
});

// Mostramos todos los cursos
$app->get('/cursos/', function () use($app){
	try{
		$conn = getConnection();
		$dbh = $conn->prepare("SELECT * FROM cursos ORDER BY fecha ASC");
		$dbh->execute();
		$cursos = $dbh->fetchAll(PDO::FETCH_ASSOC);
		$conn = null;

		$app->response->headers->set("Content-type", "application/json");
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
		$dbh = $conn->prepare("SELECT * FROM cursos WHERE id_curso=:param1");
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