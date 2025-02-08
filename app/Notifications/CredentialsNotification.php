<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CredentialsNotification extends Notification
{
    use Queueable;

    public $title;
    public $username;
    public $tempPass;

    public function __construct($title, $tempPass, $username)
    {
        $this->title = $title;
        $this->username = $username;
        $this->tempPass = $tempPass;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)->view(
            'emails.new-credentials', ['title' => $this->title, 'username' => $this->username, 'tempPass' => $this->tempPass]
        )->subject($this->title);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
