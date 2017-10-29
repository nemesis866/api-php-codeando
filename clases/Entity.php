<?php
abstract class Entity
{
	// Limpiamos los datos recibidos
	public function sanitize($data)
	{
		$data = filter_var($data,  FILTER_SANITIZE_STRING);

		return $data;
	}
}