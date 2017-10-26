<?php
/************************************************
Entidad para la tabla usuarios temporales

Proyecto: API Rest Full - Codeando.org
Author: Paulo Andrade
Email: source.compug@mail.com
************************************************/

class UserEntity
{
	protected $email;
	protected $id_user;
	protected $pass;
	protected $tokken;
	protected $username;

	// Constructor
	public function __construct(array $data)
	{
		// Verificamos que existan
		if(!isset($data['email'])){
			$this->email = $data['email'];
		}
		if(!isset($data['id_user'])){
			$this->id_user = $data['id_user'];
		}
		if(!isset($data['pass'])){
			$this->pass = $data['pass'];
		}
		if(!isset($data['tokken'])){
			$this->tokken = $data['tokken'];
		}
		if(!isset($data['username'])){
			$this->username = $data['username'];
		}
	}

	// Metodos getter
	public function getEmail()
	{
		return $this->email;
	}
	public function getIdUser()
	{
		return $this->id_user;
	}
	// Devolvemos el password con encriptacion MD5
	public function getPass()
	{
		return $this->md5(pass);
	}
	public function getTokken()
	{
		return $this->tokken;
	}
	public function getUserName()
	{
		return $this->username;
	}
}