<?php
/************************************************
Header para la plantilla

Proyecto: API Rest Full - Codeando.org
Author: Paulo Andrade
Email: source.compug@mail.com
Web: http://www.pauloandrade1.com
************************************************/
?>

<header>
	<div id="header">
		<nav>
			<ul>
				<li id="nav1"><a href="/">Inicio</a></li>
				<li id="nav2"><a href="/docs/introduccion-a-la-api/">Documentación</a></li>
				<li id="nav3"><a href="/contacto/">Contactanos</a></li>
				<?php
				if($_SESSION['logged_in'] && $_SESSION['nivel'] == 10){
					?><li><a href="/admin/">Admin</a></li>
					<li><a href="/logout/">Salir</a></li><?php
				}
				?>
			</ul>
		</nav>
		<span id="display-menu" class="icon-menu-inicio"></span>
		<img src="app/views/img/logo.png">
		<h1>API Codeando.org</h1>
	</div>
</header>