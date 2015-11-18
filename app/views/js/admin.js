/************************************************
Archivo javascript para el admin

Proyecto: API Rest Full - Codeando.org
Author: Paulo Andrade
Email: source.compug@mail.com
Web: http://www.pauloandrade1.com
************************************************/

// variables globales
var control_tema = 0; // Control para subir y bajar temas
var lang_select = 'left'; // Lenguaje seleccionado
var path_img = "<div class='cargando_min'><img src='/app/views/img/cargando.gif'></div>";
var url = '/app/views/include/server.php'; // URL del servidor

docReady(function (){
	if(document.getElementById('js')){
		CKEDITOR.replace("js");
	}
	if(document.getElementById('php')){
		CKEDITOR.replace("php");
	}
});

document.onresize = function ()
{
}

var info = function (id)
{
	document.getElementById('tema'+id).style.display = 'none';
	document.getElementById('info'+id).style.display = 'block';
}
var info_no = function (id)
{
	document.getElementById('info'+id).style.display = 'none';
	document.getElementById('tema'+id).style.display = 'block';
}
var info_yes = function (id)
{
	// Mostramos imagen cargando
	document.getElementById('info'+id).innerHTML = path_img;

	ajax(url, {
		id:id,
		form: 'delete_tema'
	}, function (data){
		// Quitamos la imagen y mostramos mensaje
		document.getElementById('info'+data.id).innerHTML = data.status;
	}, 'Json');
}

// Bajamos el orden de un tema
var tema_down = function (id)
{
	if(control_tema == 0){
		control_tema = 1;

		ajax(url, {
			id: id,
			form: 'tema_down'
		}, function (data){
			if(!isEmpty(data.status)){
				success(data.status);

				document.getElementById('temas').innerHTML = data.temas;
			}

			control_tema = 0;
		}, 'Json');
	}
}

// Subimos el orden de un tema
var tema_up = function (id)
{
	if(control_tema == 0){
		control_tema = 1;

		ajax(url, {
			id: id,
			form: "tema_up"
		}, function (data){
			if(!isEmpty(data.status)){
				success(data.status);
				
				document.getElementById('temas').innerHTML = data.temas;
			}

			control_tema = 0;
		}, 'Json');
	}
}