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
}