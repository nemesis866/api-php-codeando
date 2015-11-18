<?php
/************************************************
Plantilla pagina de documentacion

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

// Menu movil
function menu_movil ($orden_prev, $orden_next, $total, $db)
{
	?>
	<div class="doc_menu">
		<div class="doc_menu_1">
			<?php
			// Mostramos navegacion rapida
			if($orden_prev != 0){
				$result3 = $db->mysqli_select("SELECT url,menu FROM docs WHERE orden='$orden_prev'");
				while($row3 = $result3->fetch_assoc()){
					?><a href="/docs/<?php echo $row3['url']; ?>"><?php echo $row3['menu']; ?></a><?php
				}
				$result3->close();
			}
			?>
		</div>
		<div class="doc_menu_2">
			<?php
			if($orden_next <= $total){
				$result4 = $db->mysqli_select("SELECT url,menu FROM docs WHERE orden='$orden_next'");
				while($row4 = $result4->fetch_assoc()){
					?><a href="/docs/<?php echo $row4['url']; ?>"><?php echo $row4['menu']; ?></a><?php
				}
				$result4->close();
			}
			?>
		</div>
	</div>
	<?php
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<?php require_once 'include/html_head.php'; ?>
</head>
<body id="documentacion">
	<?php require_once 'include/html_header.php'; ?>
	<div id="wrapper">
		<div id="doc">
			<div id="doc_1">
				<h2>Contenido</h2>
				<ul>
					<?php
					// Obtenemos los temas de la documentacion
					$result = $db->mysqli_select("SELECT menu,url FROM docs ORDER BY orden");
					// Obtenemos el total de temas
					$total = $result->num_rows;
					while($row = $result->fetch_assoc()){
						// Verificamos si es la url activa
						if($url == $row['url']){
							?>
							<li class="selectable"><a href="/docs/<?php echo $row['url']; ?>/"><?php echo $row['menu']; ?></a></li>
							<?php
						} else {
							?>
							<li><a href="/docs/<?php echo $row['url']; ?>/"><?php echo $row['menu']; ?></a></li>
							<?php
						}
					}
					$result->close();
					?>
				</ul>
			</div>
			<div id="doc_2">
				<div id="content">
					<?php
					// Obtenemos los datos del tema
					$result2 = $db->mysqli_select("SELECT * FROM docs WHERE url='$url' LIMIT 1");
					$count2 = $result2->num_rows;

					if($count2 == 0){
						?><p>Lo sentimos no se encontro información sobre el tema.</p><?php
					} else {
						while($row2 = $result2->fetch_assoc()){
							$orden = $row2['orden'];
							$orden_prev = $orden - 1;
							$orden_next = $orden + 1;

							// Llamamos al menu movil
							menu_movil ($orden_prev, $orden_next, $total, $db);
							?>
							<h2><?php echo $row2['titulo']; ?></h2>
							<div id="lang">
								<span id="left" class="select">JS</span>
								<span id="right">PHP</span>
							</div>
							<div id="js">
								<?php
								echo $row2['js'];
								?>
							</div>
							<div id="php">
								<?php
								echo $row2['php'];
								?>
							</div>
							<?php
							// Llamamos al menu movil
							menu_movil ($orden_prev, $orden_next, $total, $db);
						}
						$result2->close();
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<?php require_once 'include/html_footer.php'; ?>
</body>
</html>