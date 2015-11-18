<?php
/************************************************
Plantilla pagina principal

Proyecto: API Rest Full - Codeando.org
Author: Paulo Andrade
Email: source.compug@mail.com
Web: http://www.pauloandrade1.com
************************************************/

// Verificamos si la constante de seguridad esta definida
if(!defined('SEGURIDAD')) die('Acceso denegado');

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<?php require_once 'include/html_head.php'; ?>
</head>
<body id="index">
	<?php require_once 'include/html_header.php'; ?>
	<div id="wrapper">
		<div id="index">
			<h2>Bienvenidos</h2>
			<p>La API proporciona acceso a recursos de la plataforma Codeando.org para aplicaciones web y moviles.</p>
			<p>Actualmente se encuentra en face beta, estamos trabajando para mejorarla.</p>
			<h2>Facil de usar</h2>
			<div id="lang">
				<span id="left" class="select">JS</span>
				<span id="right">PHP</span>
			</div>
			<div id="js">
				<p>La API es muy facil de utilizar, basta con incluir la libreria javascript.-</p>
				<pre>&lt;script src="http://cdn.codeando.org/codeando/api_v1.min.js"&gt;&lt;/script&gt;</pre>
				<p>Configurar sus opciones.-</p>
				<pre>codeando.config({
	api_key: '',
});</pre>
				<p>LLamar a un metodo solicitando un recurso.-</p>
				<pre>codeando.ajax('cursos', {}, function (data){
	// data contiene el recurso solicitado en formato JSON	
}, 'GET');</pre>
				<div class="nota">
					<img src="/app/views/img/alert.png" title="Nota" alt="Nota">
					<p><strong>NOTA</strong>.- La API solo da acceso a recursos de tipo GET (solo lectura), para acceder a todos los recursos de la API
					(metodos POST, PUT y DELETE) debe registrarse y solicitar sus credenciales de acceso.</p>
				</div>
				<p>Puede consultar la documentación de la API para ver el funcionamiento completo.</p>
			</div>
			<div id="php">
				<p>Codigo php</p>
			</div>
		</div>
	</div>
	<?php require_once 'include/html_footer.php'; ?>
</body>
</html>