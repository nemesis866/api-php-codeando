<?php
/************************************************
Hook - Ganchos de la API

Proyecto: API Rest Full - Codeando.org
Author: Paulo Andrade
Email: source.compug@mail.com
Web: http://www.pauloandrade1.com
************************************************/

$app->hook('slim.before.dispatch', function() use ($app){

    // Obtenemos el parametro key en cualquier ruta
    $ruta = $app->router()->getCurrentRoute();
    //$keyToCheck = $ruta->getParam('key');
    $keyToCheck = '';

    //proceed with authentication methods
    //like call a class with methods to check valid keys in a database
    //and validate or not the access to data:

    //so, just a very, very simple example
    if($keyToCheck == '12345') $authorized = true;
    if($keyToCheck != '12345') $authorized = false;

    if(!$authorized){ //key is false
        $app->halt('403', 'You shall not pass.'); // or redirect, or other something
    }
});