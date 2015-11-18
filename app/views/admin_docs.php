<?php
/************************************************
Plantilla pagina de administracion - Documentacion

Proyecto: API Rest Full - Codeando.org
Author: Paulo Andrade
Email: source.compug@mail.com
Web: http://www.pauloandrade1.com
************************************************/

// Verificamos si la constante de seguridad esta definida
if(!defined('SEGURIDAD')) die('Acceso denegado');

require_once 'include/Fnc.php';
require_once 'include/Db.php';

$fnc = new Fnc();
$db = new Db();

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
					<h2>Documentación disponible</h2>
					<div id="menu">
						<a href="/admin/docs/">Temas</a>
						<a href="/admin/docs/new/">Nuevo</a>
					</div>
					<?php
					// Consultamos si hay temas en la documentacion
					$result = $db->mysqli_select("SELECT * FROM docs ORDER BY orden");
					$count = $result->num_rows;

					// Verificamos si hay temas en la documentacion
					if($count == 0){
						// Si no hay temas mostramos mensaje
						?><p>No hay temas en la documentación</p><?php
					} else {
						?>
						<div id="table">
							<div id="table_text">Titulo</div>
							<div id="table_action">Acciones</div>
						</div>
						<div id="temas">
							<?php
							// Mostramos los temas
							while($row = $result->fetch_assoc()){
								?>
								<div id="tema<?php echo $row['id_tema']; ?>" class="table">
									<div class="table_text">
										<p><?php echo $row['titulo']; ?></p>
									</div>
									<div class="table_action">
										<p>
											<a class="icon-edit" href="/admin/docs/edit/<?php echo $row['id_tema']; ?>/"></a>
											<a class="icon-trash" onclick="javascript:info(<?php echo $row['id_tema']; ?>);"></a>
											<a onclick="javascript:tema_down(<?php echo $row['id_tema']; ?>);">Bajar</a>
											<a onclick="javascript:tema_up(<?php echo $row['id_tema']; ?>);">Subir</a>
										</p>
									</div>
								</div>
								<div id="info<?php echo $row['id_tema']; ?>" class="table_info none">
									<p>Esta seguro de eliminar el tema?
										<a class="icon-no" onclick="javascript:info_no(<?php echo $row['id_tema']; ?>);"></a>
										<a class="icon-yes" onclick="javascript:info_yes(<?php echo $row['id_tema']; ?>);"></a>
									</p>
								</div>
								<?php
							}
							$result->close();
						?>
						</div>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<?php require_once 'include/admin_footer.php'; ?>
</body>
</html>