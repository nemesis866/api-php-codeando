<?php
/************************************************
Mapeo para la tabla usuarios

Proyecto: API Rest Full - Codeando.org
Author: Paulo Andrade
Email: source.compug@mail.com
************************************************/

class UserMapper extends Mapper
{
	// Obtenemos todos los usuario
	public function getUsers()
	{

	}
	// Obtenemos un usuario
	public function getUserById(int $id)
	{

	}
	// Obtenemos un usuario desde el logueo
	public function getUserByLogin(UserEntity $user)
	{
		$sql = "SELECT id_user,avatar,email,fbid,level,name,lastname,lastaccess,username FROM users WHERE username=:username and pass=:pass";
		$stmt = $this->db->prepare($sql);
		$result = $stmt->execute([
			'username' => $user->getUserName(),
			'pass' => $user->getPass()
		]);

		// Convertimos en un array
		$data = $stmt->fetchAll();

		if(count($data) == 0){
			return new UserEntity(array('error'=>'nothing'));
		} else {
			return new UserEntity($data[0]);
		}
	}
	// Completamos el registro
	public function getUserByTokken(UserEntity $user)
	{
		// Obtenemos el tokken
		$tokken = $user->getTokken();

		// Obtenemos los datos del usuario
		$sql = "SELECT username,pass,email FROM temp_users WHERE tokken=:tokken";
		$stmt = $this->db->prepare($sql);
		$result = $stmt->execute([
			'tokken' => $tokken
		]);

		// Convertimos en un array
		$data = $stmt->fetchAll();

		// verificamos si esta disponible
		if(count($data) == 0){
			// Si no existe el tooken
			return array('error'=>'Lo sentimos, debe completar su registro de nuevo');
		} else {
			// Si existe
			$user = new UserEntity($data[0]);

			// Insertamos los datos a la tabla users
			$this->db->beginTransaction(); // Iniciamos transaccion

			$sql = "INSERT INTO users (username, pass, email) VALUES (:username,:pass,:email)";
			$stmt = $this->db->prepare($sql);
			$result = $stmt->execute([
				'username' => $user->getUserName(),
				'pass' => $user->getPassWithoutMd5(),
				'email' => $user->getEmail()
			]);

			$id = $this->db->lastInsertId(); // Obtenemos el id

			$this->db->commit(); // Procesamos transaccion

			// Eliminamos de la tabla temporal
			$this->db->beginTransaction(); // Iniciamos transaccion

			$sql = "DELETE FROM temp_users WHERE tokken=:tokken";
			$stmt = $this->db->prepare($sql);
			$result = $stmt->execute([
				'tokken' => $tokken
			]);

			$this->db->commit(); // Procesamos transaccion

			return ['id'=>$id, 'username'=>$user->getUserName(), 'email'=>$user->getEmail(),'error'=>''];
		}
	}
	// Recuperamos el password
	public function recoverPass(UserEntity $user)
	{
		/* Comprobamos que exista el email*/
		$sql = "SELECT * FROM users WHERE email=:email";
		$stmt = $this->db->prepare($sql);
		$result = $stmt->execute([
			'email' => $user->getEmail()
		]);

		$data = $stmt->fetchAll();

		// verificamos si ya existe
		if(count($data) == 0){
			return array('error'=>'El email no esta registrado, intente con otro');
		}

		// Obtenemos los datos
		$user = new UserEntity($data[0]);

		// Obtenemos un nuevo password
		$pass = $this->newTokken(10);
		$md5 = md5($pass);

		// Actualizamos el password
		$this->db->beginTransaction(); // Iniciamos transaccion

		$sql = "UPDATE users SET pass=:pass WHERE email=:email";
		$stmt = $this->db->prepare($sql);
		$result = $stmt->execute([
			'pass' => $md5,
			'email' => $user->getEmail()
		]);

		$id = $this->db->lastInsertId(); // Obtenemos el id

		$this->db->commit(); // Procesamos transaccion

		// armamos la respuesta
		return array('id'=>$id, 'username'=>$user->getUserName(),'email'=>$user->getEmail(), 'pass'=>$pass, 'error'=>'');
	}
	// Almacenamos un usuario
	public function save(UserEntity $user)
	{
		/* Comprobamos que no este repetido el email [users]*/
		$sql = "SELECT * FROM users WHERE email=:email";
		$stmt = $this->db->prepare($sql);
		$result = $stmt->execute([
			'email' => $user->getEmail()
		]);

		// verificamos si ya existe
		if(count($stmt->fetchAll()) > 0){
			return array('error'=>'El email ya esta en uso, intente con otro');
		}

		/* Comprobamos que no este repetido el username [users]*/
		$sql = "SELECT * FROM users WHERE username=:username";
		$stmt = $this->db->prepare($sql);
		$result = $stmt->execute([
			'username' => $user->getUserName()
		]);

		// verificamos si ya existe
		if(count($stmt->fetchAll()) > 0){
			return array('error'=>'El username ya esta en uso, intente con otro');
		}

		/* Comprobamos si ya esta en la tabla temporal */
		$sql = "SELECT * FROM temp_users WHERE email=:email";
		$stmt = $this->db->prepare($sql);
		$result = $stmt->execute([
			'email' => $user->getEmail()
		]);

		// Generamos un tokken
		$tokken = $this->newTokken(200);

		// verificamos si existe
		if(count($stmt->fetchAll()) > 0){
			// existe, entonces actualizamos
			$this->db->beginTransaction(); // Iniciamos transaccion

			$sql = "UPDATE temp_users SET username=:username,pass=:pass,tokken=:tokken WHERE email=:email";
			$stmt = $this->db->prepare($sql);
			$result = $stmt->execute([
				'username' => $user->getUserName(),
				'pass' => $user->getPass(),
				'tokken' => $tokken,
				'email' => $user->getEmail()
			]);

			$id = $this->db->lastInsertId(); // Obtenemos el id

			$this->db->commit(); // Procesamos transaccion

			if(!$result){
				throw new Exception("Error al guardar el registro");
			}

			// Armamos el array para resultados
			$data = ['id'=>$id,'tokken'=>$tokken, 'error'=>''];

			return $data;
		} else {
			/* no existe, Proceso normal */
			$this->db->beginTransaction(); // Iniciamos transaccion

			$sql = "INSERT INTO temp_users (username, pass, email, tokken) VALUES (:username,:pass,:email,:tokken)";
			$stmt = $this->db->prepare($sql);
			$result = $stmt->execute([
				'username' => $user->getUserName(),
				'pass' => $user->getPass(),
				'email' => $user->getEmail(),
				'tokken' => $tokken
			]);

			$id = $this->db->lastInsertId(); // Obtenemos el id

			$this->db->commit(); // Procesamos transaccion

			if(!$result){
				throw new Exception("Error al guardar el registro");
			}

			// Armamos el array para resultados
			$data = ['id'=>$id,'tokken'=>$tokken, 'error'=>''];

			return $data;
		}
	}
	// Actualizamos un usuario
	public function update(UserEntity $user)
	{

	}
	// Eliminamos un usuario
	public function delete(int $id)
	{

	}
}