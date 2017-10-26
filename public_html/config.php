<?php
/************************************************
Archivo de configuracion principal

Proyecto: API Rest Full - Codeando.org
Author: Paulo Andrade
Email: source.compug@mail.com
Web: http://www.pauloandrade1.com
************************************************/

########## Opciones generales ################
$email = 'source.compu@gmail.com'; // Email del Administrador (Contacto en caso de algun problema)
$site_domain = $_SERVER['SERVER_NAME']; // Dominio del sitio web
$site_name = 'api.codeando.org'; // Nombre del sitio web
$site_logo = '/app/views/img/logo.png'; // Logo del sitio
$localhost = 'api.dev'; // Host virtual para pruebas
$login_show = true;  // Muestra el formulario de login en el header 'true = si, false = no'
$login_type = true;  // Tipo de login, false = normal, true = dinamico (javascript)
$login_register = false; // Mostramos opcion para registrar
$analytics = 'UA-55347398-1'; // Codigo de google analytics

########## Configuracion envio de email ##########
$data_email = array(
	'host'=>'servidor2202.el.controladordns.com', // Servidor SMTP
	'user'=>'admin@codeando.org', // Usuario (correo electronico)
	'pass'=>'8U!{qf#KNW!$', // Password
	'email'=>$email, // Email de contacto
	'site_name'=>$site_name, // Nombre del sitio
	'site_address'=>$site_domain, // Direccion del sitio web
	'name'=>'Paulo Andrade', // Nombre del administrador
	);

########## Configuracion Facebook Connect #############
$appId = '630542777013295'; // Facebook App ID
$appSecret = '11575f96569c7426f0fcd4ae46782145'; // Facebook App Secret
$return_url = 'http://codeando.programandowebs.com';  // Url principal del sitio (Root)
$fbPermissions = 'email,public_profile'; // Permisos, mas permisos: https://developers.facebook.com/docs/authentication/permissions/