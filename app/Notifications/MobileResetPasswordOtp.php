<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MobileResetPasswordOtp extends Notification
{
    public function __construct(
        private readonly string $otp,
        private readonly int $expiresInMinutes = 5
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->from(config('mail.from.address'), 'FLORASHOP')
            ->subject('Kode Reset Kata Sandi | FLORASHOP')
            ->view([
                'html' => 'emails.florashop-mobile-otp',
                'text' => 'emails.florashop-mobile-otp-text',
            ], [
                'subjectText' => 'Kode Reset Kata Sandi | FLORASHOP',
                'preheader' => "Kode OTP FLORASHOP kamu berlaku {$this->expiresInMinutes} menit.",
                'userName' => $notifiable->name ?? 'Kasir FLORASHOP',
                'otp' => $this->otp,
                'expiresInMinutes' => $this->expiresInMinutes,
                'supportText' => 'Jika kamu tidak meminta reset kata sandi, abaikan email ini atau hubungi admin toko.',
                'brandUrl' => config('app.url'),
            ]);
    }
}
