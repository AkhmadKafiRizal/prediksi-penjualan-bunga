<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPassword extends Notification
{
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a new notification instance.
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation.
     */
    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->email,
        ], false));

        return (new MailMessage)
            ->subject('Reset Password | Prediksi Penjualan Bunga')
            ->greeting('Halo, ' . $notifiable->name)
            ->line('Kami menerima permintaan untuk mereset password akun Anda pada Sistem Prediksi Penjualan Bunga.')
            ->line('Klik tombol di bawah ini untuk mengatur ulang password.')
            ->action('Reset Password Sekarang', $url)
            ->line('Link reset password memiliki batas waktu tertentu.')
            ->line('Jika Anda tidak merasa melakukan permintaan ini, silakan abaikan email ini.')
            ->salutation('Hormat kami, Tim Prediksi Penjualan Bunga');
    }
}