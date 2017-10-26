<?php
/************************************************
Entidad para la tabla usuarios

Proyecto: API Rest Full - Codeando.org
Author: Paulo Andrade
Email: source.compug@mail.com
************************************************/

class UserEntity
{
	protected $avatar;
	protected $date;
	protected $email;
	protected $fbid;
	protected $id_user;
	protected $lastaccess;
	protected $lastname;
	protected $name;
	protected $level;
	protected $pass;
	protected $points;
	protected $username;

	// Constructor
	public function __construct(array $data)
	{
		// Verificamos que existan
		$this->lastname = (isset($data['lastname'])) ? $data['lastname'] : '';
		$this->avatar = (isset($data['avatar'])) ? $data['avatar'] : '';
		$this->email = (isset($data['email'])) ? $data['email'] : '';
		$this->fbid = (isset($data['fbid'])) ? $data['fbid'] : '';
		$this->date = (isset($data['date'])) ? $data['date'] : '';
		$this->id_user = (isset($data['id_user'])) ? $data['id_user'] : '';
		$this->level = (isset($data['level'])) ? $data['level'] : '';
		$this->name = (isset($data['name'])) ? $data['name'] : '';
		$this->pass = (isset($data['pass'])) ? $data['pass'] : '';
		$this->points = (isset($data['points'])) ? $data['points'] : '';
		$this->lastaccess = (isset($data['lastaccess'])) ? $data['lastaccess'] : '';
		$this->username = (isset($data['username'])) ? $data['username'] : '';
	}

	/**************************************************
	* Metodos getter
	**************************************************/

	public function getLastName()
	{
		return $this->lastname;
	}
	public function getEmail()
	{
		return $this->email;
	}
	public function getIdUser()
	{
		return $this->id_user;
	}
	public function getName()
	{
		return $this->name;
	}
	// Devolvemos el password con encriptacion MD5
	public function getPass()
	{
		return md5($this->pass);
	}
	public function getUserName()
	{
		return $this->username;
	}
}