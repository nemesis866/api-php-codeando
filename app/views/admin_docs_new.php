<?php
/************************************************
Plantilla pagina de administracion - Documentacion - new

Proyecto: API Rest Full - Codeando.org
Author: Paulo Andrade
Email: source.compug@mail.com
Web: http://www.pauloandrade1.com
************************************************/

// Verificamos si la constante de seguridad esta definida
if(!defined('SEGURIDAD')) die('Acceso denegado');

// Obtenemos variables
$titulo = (empty($_GET['1'])) ? '' : $_GET['1'];
$js = (empty($_GET['2'])) ? '' : $_GET['2'];
$php = (empty($_GET['3'])) ? '' : $_GET['3'];

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
					<h2>Crear tema de la documentación</h2>
					<div id="menu">
						<a href="/admin/docs/">Temas</a>
						<a href="/admin/docs/new/">Nuevo</a>
					</div>
					<div class="nota">
						<img src="/app/views/img/alert.png" title="Nota" alt="Nota">
						<p>Al crear un nuevo tema en la documentación de la API codeando recuerde realizar apuntes para la API Javascript y la API PHP.</p>
					</div>
					<form action="/app/views/include/server.php" method="post">
						<input type="hidden" name="form" value="form_tema_nuevo">
						<p><label>Titulo:</label></p>
						<p><input type="text" name="titulo" placeholder="Titulo de la documentación" required></p>
						<p><label>Titulo para menu:</label></p>
						<p><input type="text" name="menu" placeholder="Titulo para el menu" required></p>
						<p><label>Documentación API Javascript:</label></p>
						<p><textarea id="js" name="js" required></textarea></p>
						<p><label>Documentación API PHP:</label></p>
						<p><textarea id="php" name="php" required></textarea></p>
						<p><input type="submit" value="Crear tema"></p>
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php require_once 'include/admin_footer.php'; ?>
</body>
</html>