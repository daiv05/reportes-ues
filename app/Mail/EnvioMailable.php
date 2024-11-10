<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnvioMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $viewName;  // Variable para la vista
    /**
     * Create a new message instance.
     */
    public function __construct($viewName)
    {
        $this->viewName = $viewName;  // Asigna la vista recibida
    }

       /**
     * Obtener el sobre del mensaje.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('reportefiaues@gmail.com', 'Reportes'),
            subject: 'Reportes fia'
        );
    }

    /**
     * Obtener la definición del contenido del mensaje.
     */
    public function content(): Content
    {
        // Usa la vista dinámica que se pasó al constructor
        return new Content(
            view: $this->viewName  // Usa la propiedad viewName que contiene el nombre de la vista
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
