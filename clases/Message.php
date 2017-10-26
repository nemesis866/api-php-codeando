<?php
class Message
{
	protected $mailer;

	// Constructor
	public function __construct($mailer)
	{
		$this->mailer = $mailer;
	}

	// Agregamos un destinatario
	public function to($address)
    {
        $this->mailer->addAddress($address);   
    }
    // Agregamos un asunto
    public function subject($subject)
    {
        $this->mailer->Subject = $subject;
    }
    // Creamos el cuerpo del mensaje
    public function body($body)
    {
        $this->mailer->Body = $body;
    }
    // Agregar remitente
    public function from($from)
    {
        $this->mailer->From = $from;
    }
    // Agregar nombre del remitente
    public function fromName($fromName)
    {
        $this->mailer->FromName = $fromName;
    }
}