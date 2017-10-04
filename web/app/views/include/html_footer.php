<?php
/************************************************
Footer para la plantilla

Proyecto: API Rest Full - Codeando.org
Author: Paulo Andrade
Email: source.compug@mail.com
Web: http://www.pauloandrade1.com
************************************************/
?>

<footer>
	<p>API Codeando <?php echo date('Y'); ?></p>
	<p>Un proyecto de <a href="http://programacionazteca.mx">Programación Azteca</a></p>
</footer>
<div id="menu-contenido">
	<ul>
		<li><a href="/">Inicio</a></li>
		<li><a href="/docs/introduccion-a-la-api/">Documentación</a></li>
		<li><a href="/contacto/">Contactanos</a></li>
		<?php
		// Mostramos url al admin
		if($_SESSION['logged_in']){
			?>
			<li><a href="/admin/">Admin</a></li>
			<li><a href="/?logout=1">Salir</a></li>
			<?php
		}
		?>
		<div class="center">
			<li><a id="menu_cerrar">Cerrar</a></li>
		</div>
	</ul>
</div>
<div class="error"></div>
<div class="success"></div>

<script type="text/javascript" src="/app/views/js/fnc.js"></script>
<script type="text/javascript" src="/app/views/js/resaltador.js"></script>
<script type="text/javascript" src="/app/views/js/main.js"></script>