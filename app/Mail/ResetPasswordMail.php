<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;

    // Constructor que recibe el token
    public function __construct($token)
    {
        $this->token = $token;
    }

    // Método para construir el correo
    public function build()
    {
        return $this->subject('Restablecer tu contraseña')
                    ->view('emails.reset-password'); // Vista donde se enviará el enlace
    }
}
