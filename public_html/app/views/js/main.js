/************************************************
Archivo javascript principal

Proyecto: API Rest Full - Codeando.org
Author: Paulo Andrade
Email: source.compug@mail.com
Web: http://www.pauloandrade1.com
************************************************/

// variables globales
var lang_select = 'left'; // Lenguaje seleccionado
var path_img = "<img src='/app/views/img/cargando.gif'>"; // Imagen cargando
var url = '/app/views/include/server.php'; // Url del servidor
var version = ie(); // Obtenemos la version de IE

docReady(function (){
	// Resaltaor de codigo
	resaltador();
	// Selector de lenguaje
	lang();
	// Procesa formulario de contacto
	form_contacto();
	// Procesamos el formulario de login
	form_login();
	// Procesamos el formulario de recover
	form_recover();
	// Procesamos el formulario de registro
	form_register();
	// Opciones para el menu movil
	mostrar_menu();
});

// Formulario de contacto
var form_contacto = function ()
{
	var formulario = document.getElementById('form_contacto') || 'form';
	formulario.onsubmit = function (e){
		if(version <= 8){
			// Soporte a navegadores antiguos
			window.event.returnValue = false;
		} else {
			e.preventDefault();
		}

		var name = document.getElementById('name').value;
		var email = document.getElementById('email').value;
		var asunto = document.getElementById('asunto').value;
		var contenido = document.getElementById('contenido').value;

		if(check(name)){ return }

		if(!correo(email)){
			var text = 'Ingrese un email valido';
	
			if(version <= 8){
				// Soporte a navegadores antiguos
				var temp = getElementsByClassName('error');
				for(var i = 0; i < temp.length; i++){
					temp[i].innerHTML = text;
					temp[i].style.marginTop = '0px';
				}
			} else {
				document.querySelector('.error').innerHTML = text;
				document.getElementById('.error').style.transform = 'translateY(0)';
			}
			
			setTimeout(function(){
				if(version <= 8){
					// Soporte a navegadores antiguos
					var temp = getElementsByClassName('error');

					for(var i = 0; i < temp.length; i++){
						temp[i].style.marginTop = '-60px';
					}
				} else {
					document.querySelector('.error').style.transform = 'translateY(-60px)';
				}
			}, 3000);

			return
		}

		if(check(asunto)){ return }

		if(contenido.length < 30){
			var text = 'Ingrese un comentario con mas de 30 caracteres';
			
			if(version <= 8){
				// Soporte a navegadores antiguos
				var temp = getElementsByClassName('error');

				for(var i = 0; i < temp.length; i++){
					temp[i].innerHTML = text;
					temp[i].style.marginTop = '0px';
				}
			} else {
				document.querySelector('.error').innerHTML = text;
				document.querySelector('.error').style.transform = 'translateY(0)';
			}
			
			setTimeout(function(){
				if(version <= 8){
					// Soporte a navegadores antiguos
					var temp = getElementsByClassName('error');

					for(var i = 0; i < temp.length; i++){
						temp[i].style.marginTop = '-60px';
					}
				} else {
					document.querySelector('.error').style.transform = 'translateY(-60px)';
				}
			}, 3000);

			return
		}

		if(version <= 8){
			// Soporte a navegadores antiguos
			var temp = getElementsByClassName('cargando');

			for(var i = 0; i < temp.length; i++){
				temp[i].innerHTML = path_img;
			}
		} else {
			document.querySelector('.cargando').innerHTML = path_img;
		}

		document.getElementById('submit_contacto').style.display = 'none';

		ajax(url, {
			name: name,
			email: email,
			asunto: asunto,
			contenido: contenido,
			form: 'form_contacto'
		}, function (data){
			// Ocultamos el formulario
			document.getElementById('form_contacto').style.display = 'none';

			if(version <= 8){
				// Soporte a navegadores antiguos
				var temp = getElementsByClassName('cargando');

				for(var i = 0; i < temp.length; i++){
					temp[i].innerHTML = data.status;
				}
			} else {
				document.querySelector('.cargando').innerHTML = data.status;
			}

			success(data.status);
		}, 'Json');
	}
	// Evitamos enviar el formulario al presionar enter
	formulario.onkeyup = function (e)
	{
		var ev = (e) ? e : event;
   		var key = (ev.which) ? ev.which : window.event.keyCode;
		
		if(key == 13){
			return false;
		}
	}
}

// Procesamos el formulario de login
var form_login = function()
{
	var formulario = document.getElementById('form_login') || 'form';
	formulario.onsubmit = function (e){
		// Evitamos el comportamiento por defecto del formulario
		if(version <= 8){
			// Soporte a navegadores antiguos
			window.event.returnValue = false;
		} else {
			e.preventDefault();
		}

		// Obtenemos los valores del formulario
		var user = document.getElementById('user').value;
		var pass = document.getElementById('pass').value;

		// Verificamos los datos obtenidos
		if(check(user)){ return }
		if(check(pass)){ return }

		// Mostramos la imagen de cargando mientras procesamos el formulario
		if(version <= 8){
			// Soporte a navegadores antiguos
			var temp = getElementsByClassName('cargando_login');

			for(var i = 0; i < temp.length; i++){
				temp[i].innerHTML = path_img;
			}
		} else {
			document.querySelector('.cargando_login').innerHTML = path_img;
		}

		document.getElementById('submit_login').style.display = 'none';

		ajax(url, {
			user: user,
			pass: pass,
			form: 'form_login'
		}, function (data){
			// Verificamos si no hubo un error al enviar el formulario
			if(isEmpty(data.error)){
				// Si no hubo error
				document.getElementById('user').disabled = true;
				document.getElementById('pass').disabled = true;

				var text = "Inicio de sesion con exito . . .";
				success(text);

				// Redireccionamos al admin
				setTimeout(function (){
					location.href = '/admin/';
				}, 3000);
			} else {
				// Si hubo error
				// Mostramos el boton de envio y ocultamos la imagen de cargando
				document.getElementById('submit_login').style.display = 'inline-block';
				document.getElementById('pass').value = '';
				document.getElementById('pass').focus();

				if(version <= 8){
					// Soporte a navegadores antiguos
					var temp = getElementsByClassName('cargando_login');

					for(var i = 0; i < temp.length; i++){
						temp[i].innerHTML = '';
					}
				} else {
					document.querySelector('.cargando_login').innerHTML = '';
				}

				error(data.error);
			}

			return
		}, 'Json');
	}
}

// Procesamos el formulario de registro
var form_register = function()
{
	var formulario = document.getElementById('form_register') || 'form';
	formulario.onsubmit = function (e){
		// Evitamos el comportamiento por defecto del formulario
		if(version <= 8){
			// Soporte a navegadores antiguos
			window.event.returnValue = false;
		} else {
			e.preventDefault();
		}

		// Obtenemos los valores del formulario
		var username = document.getElementById('register_username').value;
		var pass1 = document.getElementById('register_pass1').value;
		var pass2 = document.getElementById('register_pass2').value;
		var email = document.getElementById('register_email').value;

		// Verificamos los datos obtenidos
		if(check(username)){ return }
		if(username.length < 8){
			error('El username debe tener al menos 8 caracteres');
			return
		}
		if(check(pass1)){ return }
		if(check(pass2)){ return }
		if(pass1.length < 8){
			error('La contraseña debe tener al menos 8 caracteres');
			return
		}
		if(pass1 != pass2){
			error('Las contraseñas no coinciden, intente nuevamente');
			return
		}
		if(!correo(email)){
			error('Ingrese un email valido, intente nuevamente');
			return
		}

		// Mostramos la imagen de cargando mientras procesamos el formulario
		if(version <= 8){
			// Soporte a navegadores antiguos
			var temp = getElementsByClassName('cargando_register');

			for(var i = 0; i < temp.length; i++){
				temp[i].innerHTML = path_img;
			}
		} else {
			document.querySelector('.cargando_register').innerHTML = path_img;
		}

		// Ocultamos el boton submit
		document.getElementById('submit_register').style.display = 'none';
		// Ocultamos el boton cancelar
		document.getElementById('register_cancel').style.display = 'none';

		ajax(url, {
			user: username,
			pass: pass1,
			email: email,
			form: 'form_register'
		}, function (data){
			// Verificamos si no hubo un error al enviar el formulario
			if(isEmpty(data.error)){
				// Si no hubo error
				document.getElementById('register_username').disabled = true;
				document.getElementById('register_pass1').disabled = true;
				document.getElementById('register_pass2').disabled = true;
				document.getElementById('register_email').disabled = true;

				var text = "Revice su bandeja de email";
				success(text);

				var msg = "<p>Se le envio un email con el enlace para autorizar su registro,<br><strong>no olvide revisar su bandeja de correo no deseado</strong></p>";
				document.getElementById('register_msg').innerHTML = msg;

				setTimeout(function (){
					// Ocultamos el formulario de register y mostramos login
					document.getElementById('register').style.display = 'none';
					document.getElementById('form').style.display = 'block';
				}, 2000);
			} else {
				// Si hubo error
				// Mostramos el boton de envio y ocultamos la imagen de cargando
				document.getElementById('submit_register').style.display = 'inline-block';
				document.getElementById('register_pass1').value = '';
				document.getElementById('register_pass2').value = '';

				error(data.error);
			}
			// Mostramos el boton cancel
			document.getElementById('register_cancel').style.display = 'inline-block';

			// Quitamos la imagen cargando
			if(version <= 8){
				// Soporte a navegadores antiguos
				var temp = getElementsByClassName('cargando_register');

				for(var i = 0; i < temp.length; i++){
					temp[i].innerHTML = '';
				}
			} else {
				document.querySelector('.cargando_register').innerHTML = '';
			}

			return
		}, 'Json');
	}
}

// Procesamos el formulario de recover
var form_recover = function()
{
	var formulario = document.getElementById('form_recover') || 'form';
	formulario.onsubmit = function (e){
		// Evitamos el comportamiento por defecto del formulario
		if(version <= 8){
			// Soporte a navegadores antiguos
			window.event.returnValue = false;
		} else {
			e.preventDefault();
		}

		// Obtenemos los valores del formulario
		var email = document.getElementById('recover_email').value;

		// Verificamos los datos obtenidos
		if(!correo(email)){
			error('Ingrese un email valido');
			return
		}

		// Mostramos la imagen de cargando mientras procesamos el formulario
		if(version <= 8){
			// Soporte a navegadores antiguos
			var temp = getElementsByClassName('cargando_recover');

			for(var i = 0; i < temp.length; i++){
				temp[i].innerHTML = path_img;
			}
		} else {
			document.querySelector('.cargando_recover').innerHTML = path_img;
		}

		// Ocultamos el boton submit
		document.getElementById('submit_recover').style.display = 'none';
		// Ocultamos el boton cancelar
		document.getElementById('recover_cancel').style.display = 'none';

		ajax(url, {
			email: email,
			form: 'form_recover'
		}, function (data){
			// Verificamos si no hubo un error al enviar el formulario
			if(isEmpty(data.error)){
				// Si no hubo error
				document.getElementById('recover_email').disabled = true;

				success(data.status);

				var msg = "<p>Sus datos de acceso fueron enviados a su email,<br><strong>no olvide revisar su bandeja de correo no deseado</strong></p>";
				document.getElementById('recover_msg').innerHTML = msg;

				setTimeout(function (){
					// Ocultamos el formulario de recover y mostramos login
					document.getElementById('recover').style.display = 'none';
					document.getElementById('form').style.display = 'block';

					// Hacemos focus al input de username
					document.getElementById('user').value = '';
					document.getElementById('user').focus();
				}, 3000);
			} else {
				// Si hubo error
				// Mostramos el boton de envio y ocultamos la imagen de cargando
				document.getElementById('submit_recover').style.display = 'inline-block';
				document.getElementById('recover_email').value = '';
				document.getElementById('recover_email').focus();

				error(data.error);
			}
			// Mostramos el boton cancelar
			document.getElementById('recover_cancel').style.display = 'none';

			// Quitamos la imagen cargando
			if(version <= 8){
			// Soporte a navegadores antiguos
				var temp = getElementsByClassName('cargando_recover');

				for(var i = 0; i < temp.length; i++){
					temp[i].innerHTML = '';
				}
			} else {
				document.querySelector('.cargando_recover').innerHTML = '';
			}
		}, 'Json');
	}
}

// Mostramos formulario para registrarse
var login_recover = function ()
{
	// Limpiamos el formulario de login
	document.getElementById('user').value = '';
	document.getElementById('pass').value = '';

	// Ocultamos el formulario
	document.getElementById('form').style.display = 'none';
	document.getElementById('recover').style.display = 'block';
}

// Ocultamos formulario para registrarse
var login_recover_cancel = function ()
{
	// Ocultamos el formulario
	document.getElementById('recover').style.display = 'none';
	document.getElementById('form').style.display = 'block';
}

// Mostramos formulario para registrarse
var login_register = function ()
{
	// Limpiamos el formulario de login
	document.getElementById('user').value = '';
	document.getElementById('pass').value = '';

	// Ocultamos el formulario
	document.getElementById('form').style.display = 'none';
	document.getElementById('register').style.display = 'block';
}

// Ocultamos formulario para registrarse
var login_register_cancel = function ()
{
	// Limpiamos el formulario de registro
	document.getElementById('register_username').value = '';
	document.getElementById('register_pass1').value = '';
	document.getElementById('register_pass2').value = '';
	document.getElementById('register_email').value = '';

	// Ocultamos el formulario
	document.getElementById('register').style.display = 'none';
	document.getElementById('form').style.display = 'block';
}

// Selector de lenguaje
var lang = function ()
{
	if(document.getElementById('left')){
		document.getElementById('left').onclick = function (){
			if(lang_select != 'left'){
				document.getElementById('php').style.opacity = 0;
				document.getElementById('php').style.display = 'none';
				document.getElementById('js').style.display = 'block';
				document.getElementById('js').style.opacity = 1;

				addClass(document.getElementById('left'), 'select');
				removeClass(document.getElementById('right'), 'select');

				lang_select = 'left';
			}
		}
	}
	if(document.getElementById('right')){
		document.getElementById('right').onclick = function (){
			if(lang_select != 'right'){
				document.getElementById('js').style.opacity = 0;	
				document.getElementById('js').style.display = 'none';
				document.getElementById('php').style.display = 'block';
				document.getElementById('php').style.opacity = 1;

				addClass(document.getElementById('right'), 'select');
				removeClass(document.getElementById('left'), 'select');

				lang_select = 'right';
			}
		}
	}
}

var mostrar_menu = function ()
{
	// Mostramos el menu
	if(document.getElementById('display-menu')){
		// document.getElementById('display-menu').style.display = 'none';
		// Ocultamos el icono
		document.getElementById('display-menu').onclick = function (){
			// document.getElementById('display-menu').style.display = 'none';

			// Mostramos el menu
			var height = document.getElementById('menu-contenido').style.pixelHeight || document.getElementById('menu-contenido').offsetHeight
			
			document.getElementById('menu-contenido').style.opacity = '1';
			document.getElementById('menu-contenido').style.transform = 'translateY(0px)';
			document.getElementById('menu-contenido').style.webkitTransform = 'translateY(0px)';
		}
	}

	// Cerramos el menu
	if(document.getElementById('menu_cerrar')){
		document.getElementById('menu_cerrar').onclick = function (){
			// Ocultamos el menu
			var height = document.getElementById('menu-contenido').style.pixelHeight || document.getElementById('menu-contenido').offsetHeight
			
			document.getElementById('menu-contenido').style.transform = 'translateY(-'+height+'px)';
			document.getElementById('menu-contenido').style.webkitTransform = 'translateY(-'+height+'px)';
			document.getElementById('menu-contenido').style.opacity = '0';

			// Mostramos el icono
			// document.getElementById('display-menu').style.display = 'block';
		}
	}

	// Ocultamos el menu
	var height = document.getElementById('menu-contenido').style.pixelHeight || document.getElementById('menu-contenido').offsetHeight
	
	document.getElementById('menu-contenido').style.transform = 'translateY(-'+height+'px)';
	document.getElementById('menu-contenido').style.webkitTransform = 'translateY(-'+height+'px)';
}

// Resaltador de sintaxis
var resaltador = function ()
{
	// ########### ZONA EDITABLE ########################################################################################
    var lenguajeEspecifico = ''; //Dejarlo así para que funcione por defecto con la mayoría de lenguajes más usados 
    var skin = 'desert'; //Selección de skin o tema. Ver lista posible más abajo. Por defecto se usa el skin 'default'
    // ########### FIN ZONA EDITABLE ########################################################################################

    getScript("/app/views/js/resaltador.js?skin=" + (skin ? skin : "default") + (lenguajeEspecifico ? "?lang=" + lenguajeEspecifico : ""));
    var pre = document.getElementsByTagName('pre');
    for(var i = 0; i < pre.length; i++){
    	addClass(pre[i], 'code');
    	var clase = "prettyprint" + (lenguajeEspecifico ? " lang-" + lenguajeEspecifico : "");
    	addClass(pre[i], clase);
    }

    // Modificamos todas las etiquetas .tag y .str
    setTimeout(function (){
	    $tag = document.querySelectorAll('.tag');
	    for(var i = 0; i < $tag.length; i++){
	    	var contenido = $tag[i].innerHTML;
	    	// reemplazamos los simbolos < y >
    		contenido = contenido.replace(/&lt;\//g,'<span style="color:#fff;font-weight:normal;">&lt;/</span>');
			contenido = contenido.replace(/&lt;/g,'<span style="color:#fff;font-weight:normal;">&lt;</span>');
			contenido = contenido.replace(/&gt;/g,'<span style="color:#fff;font-weight:normal;">&gt;</span>');

	    	$tag[i].innerHTML = contenido;
	    };

	    $str = document.querySelectorAll('.str');
	    for(var i = 0; i < $str.length; i++){
	    	var contenido = $str[i].innerHTML;
	    	// reemplazamos los simbolos \n
	    	contenido = contenido.replace(/\n/g,'\\n');

	    	$str[i].innerHTML = contenido;
	    };

	    $com = document.querySelectorAll('.com');
	    for(var i = 0; i < $com.length; i++){
	    	var contenido = $com[i].innerHTML;
	    	// reemplazamos los simbolos \n
	    	//contenido = contenido.replace(/\n/g,'\\n');

	    	$com[i].innerHTML = contenido;
	    };
	}, 1000);
}