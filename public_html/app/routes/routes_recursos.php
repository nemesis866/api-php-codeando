<?php
/************************************************
Creamos las rutas con los verbos http

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

// Grupo para rutas de la API
$app->group('/api', function (){
	// Ruta para completar el registro
	$this->get('/login/{tokken}', function (Request $req, Response $res, $args){
		// Obtenemos el tokken
		$data = [
			'tokken' => $args['tokken']
		];

		// Realizamos la operacion
		$mapper = new UserMapper($this->db);
		$user = $mapper->getUserByTokken(new UserEntity($data));

		// verificamos que no existe error
		if($user['error'] == ''){
			$res->getBody()->write('Exito al registrarse!!!');

			// Activamos la variable tokken
			$session = $this->session;
			$session->tokken = true;

			// Redireccionamos
			return $res->withStatus(302)->withHeader('Location', 'http://accounts.codeando.dev');
		} else {
			// Enviamos respuesta (error)
			$res = $res->withJson($user, 200);
			// Redireccionamos
			return $res->withStatus(302)->withHeader('Location', 'http://codeando.org');
		}
	});
	// Ruta para iniciar sesion
	$this->get('/login/{username}/{pass}', function(Request $req, Response $res, $args){
		// Obtenemos los usuarios
		$data = [];
		$data['username'] = $args['username'];
		$data['pass'] = $args['pass'];
		// Realizamos la consulta
		$mapper = new UserMapper($this->db);
		$user = $mapper->getUserByLogin(new UserEntity($data));
		// Generamos la informacion de session
		if($user->getUserName() != ''){
			$session = $this->session;
			$session->log_in = true;
			$session->id_user = $user->getIdUser();
			$session->avatar = $user->getAvatar();
			$session->email = $user->getEmail();
			$session->fbid = $user->getFbid();
			$session->level = $user->getLevel();
			$session->name = $user->getName();
			$session->lastname = $user->getLastName();
			$session->lastaccess = $user->getLastAccess();
			$session->username = $user->getUserName();

			$array = ['res'=>'successfull'];
		} else {
			$array = [];
		}
		// Mandamos la respuesta en formato Json
		$res = $res->withJson($array, 200);
		return $res;
	});
	// Ruta para registrarse
	$this->post('/login', function (Request $req, Response $res){
		// Obtenemos las variables
		$data = $req->getParsedBody();
		$user_data = [
			'username' => $data['username'],
			'pass' => $data['pass'],
			'email' => $data['email']
		];
		// Realizamos la transaccion
		$mapper = new UserMapper($this->db);
		$user = $mapper->save(new UserEntity($user_data));

		// verificamos si no hubo error
		if($user['error'] == ''){
			// Agregamos el tooken
			$user_data['tokken'] = $user['tokken'];
			// Enviamos email
			$this->mailer->send('register.phtml', $user_data , function($message) use ($user_data)
			{
				$message->to($user_data['email']);
				$message->subject('Codeando - Solicitud de registro');
				$message->from('admin@codeando.org');
				$message->fromName('Codeando');
			});
		}

		// Mandamos la respuesta en formato Json
		$res = $res->withJson($user, 200);
		return $res;
	});
});