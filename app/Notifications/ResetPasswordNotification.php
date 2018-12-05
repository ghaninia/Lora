<?php
namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class ResetPasswordNotification extends Notification
{
    use Queueable;
    public $token ;

    public function __construct($token , $email )
    {
        $this->token = $token ;
        $this->email = $email ;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $notifiable->email = $this->email ;
        return (new MailMessage)
            ->view("mail.reset_password" ,[
                'token' => route('password.reset' , $this->token)
            ])
            ->subject('فراموشی گذرواژه') ;
    }

    public function toArray($notifiable)
    {
        return [

        ];
    }

}
