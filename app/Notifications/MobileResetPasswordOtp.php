<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MobileResetPasswordOtp extends Notification
{
    public function __construct(
        private readonly string $otp,
        private readonly int $expiresInMinutes = 10
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Kode Reset Kata Sandi | FLORASHOP')
            ->greeting('Halo, ' . ($notifiable->name ?? 'Kasir FLORASHOP'))
            ->line('Kami menerima permintaan untuk mengatur ulang kata sandi akun kasir FLORASHOP.')
            ->line('Kode OTP kamu: ' . $this->otp)
            ->line("Kode ini berlaku {$this->expiresInMinutes} menit.")
            ->line('Jika kamu tidak meminta reset kata sandi, abaikan email ini.');
    }
}
