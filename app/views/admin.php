<?php
/************************************************
Plantilla pagina de administracion

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
	<?php require_once 'include/admin_head.php'; ?>
</head>
<body>
	<?php require_once 'include/admin_header.php'; ?>
	<div id="wrapper">
		<div id="admin">
			<div id="admin_1">
				<h2>Menu</h2>
				<?php require_once 'include/admin_menu.php'; ?>
			</div>
			<div id="admin_2">
				<div id="content">
					<h2>Bienvenidos</h2>
					<p>En el sistema de administracion de la API codeando podra crear y/o editar la documentacion necesaria para trabajar con la API.</p>
					<p>Tambien podra tener acceso a las credenciales solicitadas por los usuarios.</p>
				</div>
			</div>
		</div>
	</div>
	<?php require_once 'include/admin_footer.php'; ?>
</body>
</html>