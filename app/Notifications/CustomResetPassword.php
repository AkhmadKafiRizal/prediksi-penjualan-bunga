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
            ->subject('Reset Password | FloraPredict')
            ->view([
                'html' => 'emails.florapredict-action',
                'text' => 'emails.florapredict-action-text',
            ], [
                'subjectText' => 'Reset Password | FloraPredict',
                'preheader' => 'Link reset password akun FloraPredict kamu sudah siap digunakan.',
                'badge' => 'Reset Password',
                'eyebrow' => 'Keamanan Akun',
                'title' => 'Reset Password Akun',
                'subtitle' => 'Gunakan link aman ini untuk membuat password baru dan kembali mengakses dashboard.',
                'userName' => $notifiable->name,
                'introLines' => [
                    'Kami menerima permintaan untuk mereset password akun FloraPredict yang terhubung dengan email ini.',
                    'Klik tombol di bawah untuk membuat password baru. Setelah berhasil, gunakan password baru saat login berikutnya.',
                ],
                'actionLabel' => 'Reset Password Sekarang',
                'actionUrl' => $url,
                'noticeTitle' => 'Link berlaku 60 menit',
                'noticeBody' => 'Jika kamu tidak meminta reset password, abaikan email ini. Password lama tetap aman selama link ini tidak digunakan.',
                'features' => [
                    ['icon' => '1', 'title' => 'Aman', 'body' => 'Link dibuat khusus untuk akun kamu.'],
                    ['icon' => '2', 'title' => 'Cepat', 'body' => 'Atur password baru dalam beberapa langkah.'],
                    ['icon' => '3', 'title' => 'Terbatas', 'body' => 'Link otomatis kedaluwarsa.'],
                ],
                'brandUrl' => config('app.url'),
            ]);
    }
}
