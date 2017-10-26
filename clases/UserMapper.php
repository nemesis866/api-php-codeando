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
		$sql = "SELECT * FROM users WHERE username=:username and pass=:pass";
		$stmt = $this->db->prepare($sql);
		$result = $stmt->execute([
			'username' => $user->getUserName(),
			'pass' => $user->getPass()
		]);

		if($result){
			return $stmt->fetchAll();
		}
	}
	// Almacenamos un usuario
	public function save(UserEntity $user)
	{
		// Generamos un tokken
		$tokken = $this->newTokken(200);

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

		return $id;
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