<?php
/************************************************
Clase abstracta para el mapeo de base de datos

Proyecto: API Rest Full - Codeando.org
Author: Paulo Andrade
Email: source.compug@mail.com
************************************************/

abstract class Mapper
{
	protected $db;

	// Constructor
	public function __construct($db)
	{
		$this->db = $db;
	}

	// Para generar tokkens
	public function newTokken(int $length){
		$str = 'abcdefghijklmnopqrstuvwxyz1234567890';
		$tokken = '';

		for($i = 0; $i < $length; $i++){
			$tokken .= substr($str,rand(0,36),1);
		}
		
		return $tokken;
	}

	// Limpiamos los datos recibidos
	public function sanitize($data)
	{
		$data = filter_var($data,  FILTER_SANITIZE_STRING);

		return $data;
	}
}