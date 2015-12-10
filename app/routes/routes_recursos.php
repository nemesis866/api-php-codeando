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
	$conn = getConnection();

	try{
		$dbh = $conn->prepare("SELECT * FROM cursos WHERE public='YES' ORDER BY fecha ASC");
		$dbh->execute();
		$cursos = $dbh->fetchAll(PDO::FETCH_ASSOC);

		$app->response->headers->set("Content-type", "application/json");
		$app->response->status(200);
		$app->response->body(json_encode($cursos));
	} catch (PDOException $err){
		echo 'Error: '.$err->getMessage();
	}

	$conn = null;
});

// Mostramos informacion de un curso en especifico
$app->get('/cursos/:id/', function ($id) use($app){
	$conn = getConnection();

	try{
		$dbh = $conn->prepare("SELECT * FROM cursos WHERE id_curso=:param1 AND public='YES'");
		$dbh->execute(array('param1'=>$id));
		$cursos = $dbh->fetchAll(PDO::FETCH_ASSOC);

		$app->response->headers->set("Content-type", "application/json");
		$app->response->status(200);
		$app->response->body(json_encode($cursos));
	} catch (PDOException $err){
		echo 'Error: '.$err->getMessage();
	}

	$conn = null;
});

// Mostramos las discusiones de un curso
$app->get('/cursos/:id/discusiones/', function ($id) use($app){
	$conn = getConnection();

	try{
		$dbh = $conn->prepare("SELECT * FROM discucion WHERE id_curso=:param1");
		$dbh->execute(array('param1'=>$id));
		$cursos = $dbh->fetchAll(PDO::FETCH_ASSOC);

		$app->response->headers->set("Content-type", "application/json");
		$app->response->status(200);
		$app->response->body(json_encode($cursos));
	} catch (PDOException $err){
		echo 'Error: '.$err->getMessage();
	}

	$conn = null;
});

// Mostramos una discusion en especifico
$app->get('/cursos/discusiones/:id/', function ($id) use($app){
	$conn = getConnection();

	try{
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

	$conn = null;
});

// Mostramos las respuestas de una discusion
$app->get('/cursos/discusion/:id/respuestas/', function ($id) use($app){
	$conn = getConnection();

	try{
		$dbh = $conn->prepare("SELECT * FROM respuestas WHERE id_discucion=:param1");
		$dbh->execute(array('param1'=>$id));
		$cursos = $dbh->fetchAll(PDO::FETCH_ASSOC);

		$app->response->headers->set("Content-type", "application/json");
		$app->response->status(200);
		$app->response->body(json_encode($cursos));
	} catch (PDOException $err){
		echo 'Error: '.$err->getMessage();
	}

	$conn = null;
});

// Obtenemos registro de usuarios por email
$app->get('/users/:user/:password', function ($user, $password) use($app){
	$conn = getConnection();

	try{
		$dbh = $conn->prepare("SELECT * FROM usuarios WHERE username=? AND password=?");
		$dbh->execute(array(strtolower($user), md5($password)));
		$users = $dbh->fetchAll(PDO::FETCH_ASSOC);

		if(count($users) > 0){
			$conn = getConnection();
			$dbh = $conn->prepare("UPDATE usuarios SET ultimo_acceso=NOW() WHERE username=?");
			$dbh->execute(array(strtolower($user)));
		}

		$app->response->headers->set("Content-type", "application/json");
		$app->response->status(200);
		$app->response->body(json_encode($users));
	} catch (PDOException $err){
		echo 'Error: '.$err->getMessage();
	}

	$conn = null;
});

// Obtenemos registro de usuarios por email
$app->post('/users-fb/', function () use($app){
	$conn = getConnection();

	$json = $app->request->getBody();
    $data = json_decode($json, true);
    $data = $data['data'];

	try{
		$dbh = $conn->prepare("SELECT * FROM usuarios WHERE fbid=? LIMIT 1");
		$dbh->execute(array($data['id']));
		$users = $dbh->fetchAll(PDO::FETCH_ASSOC);

		if(count($users) > 0){
			$conn1 = getConnection();
			$dbh = $conn1->prepare("UPDATE usuarios SET ultimo_acceso=NOW() WHERE fbid=?");
			$dbh->execute(array($data['id']));
			$conn1 = null;
		} else {
			$conn2 = getConnection();
			$conn2->beginTransaction();

			$dbh = $conn2->prepare("INSERT INTO usuarios (email,nombre,nivel_user,fecha,ultimo_acceso,fbid) VALUES (?,?,?,NOW(),NOW(),?)");
			$dbh->execute(array($data['email'], $data['name'], '1', $data['id']));
			$id = $conn2->lastInsertId();

			$conn2->commit();
			$conn2 = null;

			$conn3 = getConnection();
			$dbh = $conn3->prepare("SELECT * FROM usuarios WHERE fbid=? LIMIT 1");
			$dbh->execute(array($data['id']));
			$users = $dbh->fetchAll(PDO::FETCH_ASSOC);
			$conn3 = null;
		}

		$app->response->headers->set("Content-type", "application/json");
		$app->response->status(200);
		$app->response->body(json_encode($users));
	} catch (PDOException $err){
		echo 'Error: '.$err->getMessage();
	}

	$conn = null;
});

// Obtenemos datos de contactos
$app->get('/contact/', function () use($app){
	$conn = getConnection();

	try{
		$dbh = $conn->prepare("SELECT * FROM contacto ORDER BY fecha ASC");
		$dbh->execute();
		$contact = $dbh->fetchAll(PDO::FETCH_ASSOC);

		$app->response->headers->set("Content-type", "application/json");
		$app->response->status(200);
		$app->response->body(json_encode($contact));
	} catch (PDOException $err){
		echo 'Error: '.$err->getMessage();
	}

	$conn = null;
});

// Guardamos el envio de contacto
$app->post('/contact/', function () use($app){
	$conn = getConnection();
	$conn->beginTransaction();

	/* Informacion sobre como recibir parametros post desde array
	http://stackoverflow.com/questions/28073480/how-to-access-a-json-request-body-of-a-post-request-in-slim */
	$json = $app->request->getBody();
    $data = json_decode($json, true);

	$name = $data['name'];
	$email = $data['email'];
	$asunto = $data['asunto'];
	$comment = $data['comment'];

	try{
		$dbh = $conn->prepare("INSERT INTO contacto (name,email,asunto,contenido,leido,fecha) VALUES(?,?,?,?,'NO',NOW())");
		$dbh->execute(array($name, $email, $asunto, $comment));
		$contact = $conn->lastInsertId();

		$app->response->headers->set("Content-type", "application/json");
		$app->response->status(200);
		$app->response->body(json_encode($contact));
	} catch (PDOException $err){
		echo 'Error: '.$err->getMessage();
	}

	$conn->commit();
	$conn = null;
});

// Mostramos informacion de un curso en especifico
$app->get('/autor/:id/', function ($id) use($app){
	$conn = getConnection();

	try{
		$dbh = $conn->prepare("SELECT * FROM usuarios WHERE id=? LIMIT 1");
		$dbh->execute(array($id));
		$cursos = $dbh->fetchAll(PDO::FETCH_ASSOC);

		$app->response->headers->set("Content-type", "application/json");
		$app->response->status(200);
		$app->response->body(json_encode($cursos));
	} catch (PDOException $err){
		echo 'Error: '.$err->getMessage();
	}

	$conn = null;
});