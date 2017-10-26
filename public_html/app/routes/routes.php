<?php
/************************************************
Creamos las rutas de la aplicación

Proyecto: API Rest Full - Codeando.org
Author: Paulo Andrade
Email: source.compug@mail.com
************************************************/

// Verificamos si la constante de seguridad esta definida
if(!defined('SEGURIDAD')) die('Acceso denegado');

// Ruta principal
$app->get('/', function ($req, $res, $args = []){
	$this->mailer->send('mail.phtml', [] , function($message)
	{
		$message->to('paulo.gonzalez.sc@itszapopan.edu.mx');
		$message->subject('Prueba');
		$message->from('admin@codeando.org');
		$message->fromName('Codeando');
	});

	return $res->write('Hello API');
	//$res->render('index.php', array('title_page'=>'Bienvenidos | '));
});

/*
// Ruta contacto
$app->get('/contacto/', function ($req, $res, $args = []) use($app){
	//$app->render('contacto.php', array('title_page'=>'Contactanos | '));
});

// Ruta documentación
$app->get('/docs/:url/', function ($req, $res, $args = []) use($app){
	//$app->render('documentacion.php', array('url'=>$url,
											'title_page'=>'Documentación | '));
});

// Ruta login
$app->get('/login/', 'login', function () use($app){
	$app->render('login.php', array('title_page'=>'Login | '));
});

// Ruta logout
$app->get('/logout/', function () use($app){
	session_destroy();
	$app->redirect('/');
});

// Ruta admin
$app->group('/admin/', 'admin', function () use($app){
	$app->get('/', function () use($app){
		$title_page = 'Administración | ';
		$app->render('admin.php', array('title_page'=>$title_page));
	});
	$app->get('docs/', function () use($app){
		$title_page = 'Administración | ';
		$app->render('admin_docs.php', array('title_page'=>$title_page));
	});
	$app->get('docs/new/', function () use($app){
		$title_page = 'Administración | ';
		$app->render('admin_docs_new.php', array('title_page'=>$title_page));
	});
	$app->get('docs/edit/:id/', function ($id) use($app){
		$title_page = 'Administración | ';
		$app->render('admin_docs_edit.php', array('id'=>$id,
												'title_page'=>$title_page));
	});
});
*/