<?php
class Mailer
{
	protected $mailer;
	protected $view;

	// Constructor
	public function __construct($view, $mailer)
	{
		$this->mailer = $mailer;
		$this->view = $view;
	}

	// Enviamos un mensaje
	public function send($template, $data, $callback)
	{
		// Creamos un nuevo mensaje
		$message = new Message($this->mailer);

		// Cargamos la vista
		$message->body($this->view->fetch($template, $data));

		// Lanzamos el callback
		call_user_func($callback, $message);

		// Enviamos el mensaje
		$this->mailer->send();
	}
}