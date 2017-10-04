<?php
/************************************************
Configuracion pagina 404

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
<body>
	<?php require_once 'include/html_header.php'; ?>
	<div id="wrapper">
		<div class="container">
            <h1>Pagina no encontrada <span>:(</span></h1>
            <p>Lo sentimos, la pagina que usted intenta ver no existe.</p>
            <p>Esto paso por cualquiera de las siguientes opciones:</p>
            <ul>
                <li>Una direccion mal escrita</li>
                <li>Un enlace eliminado</li>
            </ul>
            <script>
                var GOOG_FIXURL_LANG = (navigator.language || '').slice(0,2),GOOG_FIXURL_SITE = location.host;
            </script>
            <script src="//linkhelp.clients.google.com/tbproxy/lh/wm/fixurl.js"></script>
        </div>
	</div>
	<?php require_once 'include/html_footer.php'; ?>
</body>
</html>