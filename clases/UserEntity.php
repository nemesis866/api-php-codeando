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
		// Verificamos que existan y limpiamos las variables
		if(isset($data['lastname'])){
			$this->lastname = $this->sanitize($data['lastname']);
		}
		if(isset($data['avatar'])){
			$this->avatar = $this->sanitize($data['avatar']);
		}
		if(isset($data['email'])){
			$this->email = $this->sanitize($data['email']);
		}
		if(isset($data['fbid'])){
			$this->fbid = $this->sanitize($data['fbid']);
		}
		if(isset($data['date'])){
			$this->date = $this->sanitize($data['date']);
		}
		if(isset($data['id_user'])){
			$this->id_user = $this->sanitize($data['id_user']);
		}
		if(isset($data['level'])){
			$this->level = $this->sanitize($data['level']);
		}
		if(isset($data['name'])){
			$this->name = $this->sanitize($data['name']);
		}
		if(isset($data['pass'])){
			$this->pass = $this->sanitize($data['pass']);
		}
		if(isset($data['points'])){
			$this->points = $this->sanitize($data['points']);
		}
		if(isset($data['lastaccess'])){
			$this->lastaccess = $this->sanitize($data['lastaccess']);
		}
		if(isset($data['username'])){
			$this->username = $this->sanitize($data['username']);
		}
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
	public function getPassWithoutMd5()
	{
		return $this->pass;
	}
	public function getUserName()
	{
		return $this->username;
	}
}