<?php
/************************************************
Filtros globales para parametros

Proyecto: API Rest Full - Codeando.org
Author: Paulo Andrade
Email: source.compug@mail.com
Web: http://www.pauloandrade1.com
************************************************/

// Creamos las condiciones para los parametros
\Slim\Route::setDefaultConditions(array(
    'id' => '[0-9]'
));