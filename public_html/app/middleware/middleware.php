<?php
/************************************************
Creamos los middleware para las rutas

Proyecto: API Rest Full - Codeando.org
Author: Paulo Andrade
Email: source.compug@mail.com
Web: http://www.pauloandrade1.com
************************************************/

/* En la ruta /login/ verificamos si se inicio sesion,
si es asi redireccionamos al admin */
function login ()
{
	$login = $_SESSION['logged_in'];

    if($login){
        $app = \Slim\Slim::getInstance();
        $app->flash('error', 'Login required');
        $app->redirect('/admin/');
    }
}

/* En la ruta /admin/ verificamos si se inicio sesion,
si no es asi redireccionamos al directorio principal */
function admin ()
{
	$login = $_SESSION['logged_in'];

    if(!$login){
        $app = \Slim\Slim::getInstance();
        $app->flash('error', 'Login required');
        $app->redirect('/');
    }
}