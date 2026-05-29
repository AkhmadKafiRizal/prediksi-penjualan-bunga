<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class CustomVerifyEmail extends VerifyEmail
{
    /**
     * Build the mail representation.
     */
    public function toMail($notifiable)
    {
        $url = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Verifikasi Email | FloraPredict')
            ->view([
                'html' => 'emails.florapredict-action',
                'text' => 'emails.florapredict-action-text',
            ], [
                'subjectText' => 'Verifikasi Email | FloraPredict',
                'preheader' => 'Verifikasi alamat email FloraPredict kamu untuk melanjutkan akses dashboard.',
                'badge' => 'Verifikasi Email',
                'eyebrow' => 'Konfirmasi Identitas',
                'title' => 'Verifikasi Email Akun',
                'subtitle' => 'Satu langkah lagi untuk memastikan akun FloraPredict kamu tetap terlindungi.',
                'userName' => $notifiable->name ?? 'Admin FloraPredict',
                'introLines' => [
                    'Kami perlu memastikan alamat email ini benar digunakan untuk akun FloraPredict kamu.',
                    'Klik tombol di bawah untuk menyelesaikan verifikasi dan melanjutkan akses ke dashboard.',
                ],
                'actionLabel' => 'Verifikasi Email Sekarang',
                'actionUrl' => $url,
                'noticeTitle' => 'Bukan kamu?',
                'noticeBody' => 'Jika kamu tidak melakukan perubahan atau pendaftaran akun, abaikan email ini. Tidak ada tindakan lanjutan yang diperlukan.',
                'features' => [
                    ['icon' => '1', 'title' => 'Validasi', 'body' => 'Memastikan email benar milik kamu.'],
                    ['icon' => '2', 'title' => 'Akses', 'body' => 'Membuka kembali akses dashboard.'],
                    ['icon' => '3', 'title' => 'Proteksi', 'body' => 'Mengurangi risiko salah alamat.'],
                ],
                'brandUrl' => config('app.url'),
            ]);
    }
}
