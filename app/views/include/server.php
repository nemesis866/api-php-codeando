<?php
/************************************************
Servidor para crear temas de la documentación

Proyecto: API Rest Full - Codeando.org
Author: Paulo Andrade
Email: source.compug@mail.com
Web: http://www.pauloandrade1.com
************************************************/

session_start();

set_time_limit(0);

// Ajustamos la zona horaria
date_default_timezone_set('America/Mexico_City');

// Añadimos el archivo de configuracion
include $_SERVER['DOCUMENT_ROOT'].'/config.php';

require_once 'Fnc.php';
require_once 'Db.php';
require_once 'Template.php';
require_once 'phpmailer/PHPMailerAutoload.php';

$db = new Db();
$fnc = new Fnc();
$template = new Template();
$mail = new PHPMailer;

$type = $fnc->secure_sql($_POST['form']);

switch($type){
	case 'delete_tema':
		delete_tema($db, $fnc);
		break;
	case 'form_contacto':
		form_contacto($db, $fnc);
		break;
	case 'form_login':
		form_login($db, $fnc, $mail, $data_email);
		break;
	case 'form_recover':
		form_recover($db, $fnc, $mail, $data_email, $template);
		break;
	case 'form_register':
		form_register($db, $fnc, $mail, $data_email,$template);
		break;
	case 'form_tema_edit':
		form_tema_edit($db, $fnc);
		break;
	case 'form_tema_nuevo':
		form_tema_nuevo($db, $fnc);
		break;
	case 'tema_down':
		tema_down($db, $fnc);
		break;
	case 'tema_up':
		tema_up($db, $fnc);
		break;
}

// Eliminamos un tema de la base de datos
function delete_tema($db, $fnc)
{
	$id = $fnc->secure_sql($_POST['id']);

	// Eliminamos
	$delete = $db->mysqli_action("DELETE FROM docs WHERE id_tema='$id'");

	echo json_encode(array('status'=>'El tema se elimino con exito', 'id'=>$id));
	exit();
}

// Procesamos formulario de contacto
function form_contacto($db, $fnc)
{
	$name = $fnc->secure_sql($_POST['name']);
	$email = $fnc->secure_sql($_POST['email']);
	$asunto = $_POST['asunto'];
	$contenido = $fnc->secure_sql($_POST['contenido']);

	if($asunto == 1){
		$asunto = 'Sugerencia';
	} else if($asunto == 2){
		$asunto = 'Bug / Error';
	} else if($asunto == 3){
		$asunto = 'Comentario';
	}

	$insert = $db->mysqli_select("INSERT INTO contacto (nombre,email,asunto,mensaje,leido,fecha) VALUES ('$name','$email','$asunto','$contenido','NO',NOW())");

	echo json_encode(array('status'=>'El formulario se envio con exito'));
	exit();
}

// Procesamos el formulario de login
function form_login($db, $fnc, $mail, $data_email)
{
	$pass = md5($_POST['pass']);
	$user = strtolower($_POST['user']);

	// Consultamos que el usuario exista
	$result = $db->mysqli_select("SELECT id,fbid,email,nombre,username,nivel_user,avatar FROM usuarios WHERE username='$user' AND password='$pass'");
	$count = $result->num_rows;

	// Verificamos que el usuario exista
	if($count > 0){
		// Si existe iniciamos la sesion
		while($row = $result->fetch_assoc()){
			$email = (empty($row['email'])) ? '' : $row['email'];
			$_SESSION['logged_in'] = true;
			$_SESSION['logged_fb'] = false;
			$_SESSION['email'] = (empty($row['email'])) ? '' : $row['email'];
			$_SESSION['nombre'] = (empty($row['nombre'])) ? '' : $row['nombre'];
			$_SESSION['user_name'] = (empty($row['username'])) ? '' : $row['username'];
			$_SESSION['nivel'] = (empty($row['nivel_user'])) ? '' : $row['nivel_user'];
			$_SESSION['id'] = (empty($row['id'])) ? '' : $row['id'];
			$_SESSION['user_id'] = (empty($row['fbid'])) ? '' : $row['fbid'];
			$_SESSION['avatar'] = (empty($row['avatar'])) ? '' : $row['avatar'];
			$_SESSION['gender'] = 'male';
		}
		$result->close();

		// Actualizamos la fecha de ultimo acceso
		$update = $db->mysqli_action("UPDATE usuarios SET ultimo_acceso=NOW() WHERE email='$email'");

		echo json_encode(array('status'=>'Inicio de sesion exitoso'));
	} else {
		// No existe
		echo json_encode(array('error'=>'Usuario y/o contraseña invalidos, intente nuevamente'));
	}

	exit();
}

// Procesamos el formulario de recover
function form_recover($db, $fnc, $mail, $data_email, $template)
{
	$email = $fnc->secure_sql($_POST['email']);

	// Consultamos que exista en la base de datos
	$result = $db->mysqli_select("SELECT nombre,username FROM usuarios WHERE email='$email' AND registro='YES' LIMIT 1");
	$count = $result->num_rows;

	// Verificamos que exista en la base de datos
	if($count > 0){
		// Si existe
		while($row = $result->fetch_assoc()){
			$nombre = (empty($row['nombre'])) ? '' : $row['nombre'];
			$username = (empty($row['username'])) ? '' : $row['username'];
		}
		$result->close();

		// Generamos una password aleatorio
		$str = 'abcdefghkmpqrstwxyz1234567890';
		$pass = '';
		for($i = 0; $i < 10; $i++){
			$pass .= substr($str,rand(0,36),1);
		}
		$md5 = md5($pass);
		// md5 de admin 21232f297a57a5a743894a0e4a801fc3

		// Actualizamos el password en la base de datos
		$insert = $db->mysqli_action("UPDATE usuarios SET password='$md5' WHERE email='$email'");

		// Generamos respuesta
		$respuesta = "<p>$nombre: Recibe este mensaje por que solicito la recuperacion de su password del sitio ".$data_email['site_name']."</p>
					<p>Datos de ingreso:</p>
					<p>Username: $username<br>
					Password: $pass</p>
					<p><strong>No olvides</strong> ingresar al sistema de administracion y cambiar el password temporal.</p>";

		$respuesta = $template->email_header($respuesta).''.$template->email_footer($data_email['site_name']);

		// Configuracion del servidor SMTP para el envio de email
		$mail->CharSet = "UTF-8";
		$mail->IsSMTP();
		$mail->Host = $data_email['host'];  // Indico el servidor para SMTP
		$mail->SMTPAuth = true;  // Debo de hacer autenticación SMTP
		$mail->Username = $data_email['user'];  // Indico un usuario
		$mail->Password = $data_email['pass'];  // clave de un usuario
		$mail->SMTPSecure = 'ssl';
		$mail->Port = 465;  // Puerto por defecto del servidor SMTP

		// Datos del remitente
		$mail->From = $data_email['email']; // Email remitente
		$mail->FromName = $data_email['site_name']; // Nombre remitente

		// Indicamos el destinatario
		$mail->AddAddress($email, $nombre); // Email y nombre del destinatario
		// $mail->AddReplyTo('', ''); // Email y nombre para enviar copia
		$mail->Subject = 'Recuperacion de password - '.$data_email['site_name'];
		$mail->MsgHTML($respuesta);

		// Procesamos el envio de email
		if(!$mail->Send()) {
			// Error
			echo json_encode(array('error'=>'Error al enviar sus datos, intente nuevamente'));
		} else {
			// Exito

			echo json_encode(array('status'=>'Su contraseña se envio a su email'));
		}
	} else {
		// No existe
		echo json_encode(array('error'=>'El email no existe en la base de datos'));
	}

	exit();
}

// Procesamos el formulario de registro
function form_register($db, $fnc, $mail, $data_email,$template)
{
	$username = strtolower($_POST['user']);
	$pass = $_POST['pass'];
	$email = $_POST['email'];
	$md5 = md5($pass);

	// Verificamos que no exista en la base de datos
	$result = $db->mysqli_select("SELECT id FROM usuarios WHERE email='$email' AND registro='YES' LIMIT 1");
	$count = $result->num_rows;
	$result->close();

	if($count == 0){
		// No existe

		// Verificamos que el username no este ocupado
		$result1 = $db->mysqli_select("SELECT id FROM usuarios WHERE username='$username' LIMIT 1");
		$count1 = $result1->num_rows;
		$result1->close();

		if($count1 == 0){
			// Verificamos que el registro no exista en la base de datos temporal
			$result2 = $db->mysqli_select("SELECT id FROM usuarios_temp WHERE email='$email' LIMIT 1");
			$count2 = $result2->num_rows;
			$result2->close();

			if($count2 == 0){
				// Insertamos el registro en la base de datos temporal
				$insert = $db->mysqli_action("INSERT INTO usuarios_temp (email,username,password) VALUES ('$email','$username','$md5')");
			} else {
				// Actualizamos el registro en la base de datos
				$update = $db->mysqli_action("UPDATE usuarios_temp SET username='$username',password='$md5' WHERE email='$email'");
			}

			// Generamos respuesta
			$respuesta = "<p>$username: Recibe este mensaje por que solicito registrarse en el sitio ".$data_email['site_name']."</p>
						<p>Sus datos de ingreso son los siguientes:</p>
						<p>Username: $username<br>
						Password: $pass</p>
						<div style='background-color: #FFFFCC;border: 1px solid #CCC;border-radius: 3px;margin-bottom: 10px;min-height: 50px;padding: 10px;'>
							<img src='https://lh3.googleusercontent.com/-CvxSSHW4l9w/Ve45wpdGEFI/AAAAAAAACK8/qatJNgjqTFY/s128-Ic42/alert.png' style='float:left;width:50px;'>
							<p><strong>Atencion</strong> para finalizar su registro de clic en el siguiente enlace:</p>
						</div>
						<p><a href='http://api.codeando.org/register.php?email=$email&temp=$md5'>Finalizar su registro</a></p>";

			$respuesta = $template->email_header($respuesta).''.$template->email_footer($data_email['site_name']);

			// Configuracion del servidor SMTP para el envio de email
			$mail->CharSet = "UTF-8";
			$mail->IsSMTP();
			$mail->Host = $data_email['host'];  // Indico el servidor para SMTP
			$mail->SMTPAuth = true;  // Debo de hacer autenticación SMTP
			$mail->Username = $data_email['user'];  // Indico un usuario
			$mail->Password = $data_email['pass'];  // clave de un usuario
			$mail->SMTPSecure = 'ssl';
			$mail->Port = 465;  // Puerto por defecto del servidor SMTP

			// Datos del remitente
			$mail->From = $data_email['user']; // Email remitente
			$mail->FromName = $data_email['site_name']; // Nombre remitente

			// Indicamos el destinatario
			$mail->AddAddress($email, $username); // Email y nombre del destinatario
			// $mail->AddReplyTo('', ''); // Email y nombre para enviar copia
			$mail->Subject = 'Autorizacion de registro - '.$data_email['site_name'];
			$mail->MsgHTML($respuesta);

			// Procesamos el envio de email
			if(!$mail->Send()) {
				// Error
				echo json_encode(array('error'=>'Error al enviar sus datos, intente nuevamente'));
			} else {
				// Exito

				echo json_encode(array('status'=>'Registro exitoso'));
			}
		} else {
			// Si existe
			echo json_encode(array('error'=>'El username ya esta registrado en la base de datos'));
		}
	} else {
		// Si existe
		echo json_encode(array('error'=>'El email ya esta registrado en la base de datos'));
	}

	exit();
}

// Editamos un tema de la documentacion
function form_tema_edit($db, $fnc)
{
	// Recibimos las variables
	$titulo = $fnc->secure_sql($_POST['titulo']);
	$menu = $fnc->secure_sql($_POST['menu']);
	$id = $_POST['id'];
	$js = $_POST['js'];
	$php = $_POST['php'];

	// Obtenemos la url
	$url = strtolower($fnc->Url($titulo));

	// Actualizamos la base de datos
	$update = $db->mysqli_action("UPDATE docs SET titulo='$titulo',menu='$menu',url='$url',js='$js',php='$php',time_stamp=NOW() WHERE id_tema='$id'");

	// Retornamos
	header("Location: /admin/docs/");

	exit();	
}

// Procesamos un tema nuevo de la documentacion
function form_tema_nuevo($db, $fnc)
{
	// Recibimos las variables
	$titulo = $fnc->secure_sql($_POST['titulo']);
	$menu = $fnc->secure_sql($_POST['menu']);
	$js = $_POST['js'];
	$php = $_POST['php'];

	// Obtenemos la url
	$url = strtolower($fnc->Url($titulo));

	// consultamos que no exista la url
	$result = $db->mysqli_select("SELECT count(id_tema) FROM docs WHERE url='$url'");
	$count = $result->fetch_row();

	// Verificamos que no exista la url
	if($count[0] != 0){
		$url .= '-1'; 
	}
	// Obtenemos el total de temas
	$result2 = $db->mysqli_select("SELECT Count(id_tema) FROM docs");
	$count2 = $result2->fetch_row();
	$orden = $count2[0] + 1;
	// Almacenamos en la base de datos
	$insert = $db->mysqli_action("INSERT INTO docs (titulo,menu,url,js,php,orden,time_stamp) VALUES ('$titulo','$menu','$url','$js','$php','$orden',NOW())");

	// Retornamos
	header("Location: /admin/docs/");

	exit();
}

// Subimos el orden de un tema
function tema_up($db, $fnc)
{
	$id = $fnc->secure_sql($_POST['id']);
	$orden = 0;
	$titulo = '';
	$temas = '';

	// Obtenemos el total de temas del curso
	$result = $db->mysqli_select("SELECT id_tema,orden FROM docs");
	$count = $result->num_rows;
	while($row = $result->fetch_assoc()){
		// Obtenemos el orden del tema
		if($row['id_tema'] == $id){
			$orden = $row['orden'];
		}
	}
	$result->close();

	// Verificamos que el orden del tema no sea 1
	if($orden != 1){
		$orden_temp = $orden - 1;

		// Obtenemos el tema del orden temporal
		$result2 = $db->mysqli_select("SELECT id_tema FROM docs WHERE orden='$orden_temp'");
		while($row2 = $result2->fetch_assoc()){
			$id_temp = $row2['id_tema'];

			// Actualizamos el orden del tema temporal
			$update = $db->mysqli_action("UPDATE docs SET orden='$orden' WHERE id_tema='$id_temp'");
		}
		$result2->close();

		// Actualizamos el orden del tema
		$update2 = $db->mysqli_action("UPDATE docs SET orden='$orden_temp' WHERE id_tema='$id'");

		// Obtenemos el nuevo acomodo de temas
		$result4 = $db->mysqli_select("SELECT id_tema,titulo FROM docs ORDER BY orden");
		while($row4 = $result4->fetch_assoc()){
			$id_tema = $row4['id_tema'];
			$titulo = $row4['titulo'];

			$temas .= "<div id='tema$id_tema' class='table'>
						<div class='table_text'>
							<p>$titulo</p>
						</div>
						<div class='table_action'>
							<p>
								<a class='icon-edit' href='/admin/docs/edit/$id_tema/'></a>
								<a class='icon-trash' onclick='javascript:info($id_tema);'></a>
								<a onclick='javascript:tema_down($id_tema);'>Bajar</a>
								<a onclick='javascript:tema_up($id_tema);'>Subir</a>
							</p>
						</div>
					</div>
					<div id='info$id_tema' class='table_info none'>
						<p>Esta seguro de eliminar el tema?
							<a class='icon-no' onclick='javascript:info_no($id_tema);'></a>
							<a class='icon-yes' onclick='javascript:info_yes($id_tema);'></a>
						</p>
					</div>";
		}
		$result4->close();

		echo json_encode(array('status'=>'El orden de los temas se actualizo','temas'=>$temas));
	} else {
		echo json_encode(array('error'=>'no se puede acomodar el orden de los temas'));
	}

	exit();
}

// Bajamos el orden de un tema
function tema_down($db, $fnc)
{
	$id = $fnc->secure_sql($_POST['id']);
	$orden = 0;
	$titulo = '';
	$temas = '';

	// Obtenemos el total de temas del curso
	$result = $db->mysqli_select("SELECT id_tema,orden FROM docs");
	$count = $result->num_rows;
	while($row = $result->fetch_assoc()){
		// Obtenemos el orden del tema
		if($row['id_tema'] == $id){
			$orden = $row['orden'];
		}
	}
	$result->close();

	if($orden != $count){
		$orden_temp = $orden + 1;

		// Obtenemos el tema del orden temporal
		$result2 = $db->mysqli_select("SELECT id_tema FROM docs WHERE orden='$orden_temp'");
		while($row2 = $result2->fetch_assoc()){
			$id_temp = $row2['id_tema'];

			// Actualizamos el ordenl tema temporal
			$update = $db->mysqli_action("UPDATE docs SET orden='$orden' WHERE id_tema='$id_temp'");
		}
		$result2->close();

		// Actualizamos el orden del tema
		$update2 = $db->mysqli_action("UPDATE docs SET orden='$orden_temp' WHERE id_tema='$id'");

		// Obtenemos el nuevo acomodo de temas
		$result4 = $db->mysqli_select("SELECT id_tema,titulo FROM docs ORDER BY orden");
		while($row4 = $result4->fetch_assoc()){
			$id_tema = $row4['id_tema'];
			$titulo = $row4['titulo'];

			$temas .= "<div id='tema$id_tema' class='table'>
						<div class='table_text'>
							<p>$titulo</p>
						</div>
						<div class='table_action'>
							<p>
								<a class='icon-edit' href='/admin/docs/edit/$id_tema/'></a>
								<a class='icon-trash' onclick='javascript:info($id_tema);'></a>
								<a onclick='javascript:tema_down($id_tema);'>Bajar</a>
								<a onclick='javascript:tema_up($id_tema);'>Subir</a>
							</p>
						</div>
					</div>
					<div id='info$id_tema' class='table_info none'>
						<p>Esta seguro de eliminar el tema?
							<a class='icon-no' onclick='javascript:info_no($id_tema);'></a>
							<a class='icon-yes' onclick='javascript:info_yes($id_tema);'></a>
						</p>
					</div>";
		}
		$result4->close();

		echo json_encode(array('status'=>'El orden de los temas se actualizo','temas'=>$temas));
	} else {
		echo json_encode(array('error'=>'no se puede acomodar el orden de los temas'));
	}

	exit();
}