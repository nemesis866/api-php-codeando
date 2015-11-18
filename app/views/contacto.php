<?php
/************************************************
Plantilla pagina de contacto

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
<body id="contacto">
	<?php require_once 'include/html_header.php'; ?>
	<div id="wrapper">
		<div id="contacto_content">
			<h2>Formulario de contacto</h2>
			<p>Tienes algun comentario o sugerencia? contactanos</p>
			<form id="form_contacto">
				<p><label>Nombre:</label></p>
				<p><input type="text" id="name" placeholder="Ingrese su nombre" required></p>
				<p><label>Email:</label></p>
				<p><input type="text" id="email" placeholder="Ingrese su email"></p>
				<p><label>Asunto:</label></p>
				<p><select id="asunto" required>
					<option></option>
					<option value="1">Sugerencia</option>
					<option value="2">Bug/Error</option>
					<option value="3">Comentario</option>
				</select></p>
				<p><label>Comentario:</label></p>
				<p><textarea id="contenido" placeholder="Ingrese su comentario" required></textarea></p>
				<p><input type="submit" id="submit_contacto" value="Enviar"></p>
			</form>
			<div class="cargando"></div>
		</div>
	</div>
	<?php require_once 'include/html_footer.php'; ?>
</body>
</html>