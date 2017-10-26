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