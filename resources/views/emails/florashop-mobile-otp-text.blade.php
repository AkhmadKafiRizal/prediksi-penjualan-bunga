{{ $subjectText ?? 'Kode Reset Kata Sandi | FLORASHOP' }}

Halo, {{ $userName ?? 'Kasir FLORASHOP' }}

Kami menerima permintaan untuk mengatur ulang kata sandi akun kasir FLORASHOP kamu.

Kode OTP:
{{ $otp }}

Kode ini berlaku {{ $expiresInMinutes ?? 5 }} menit.

Masukkan kode ini di halaman OTP aplikasi. Jangan bagikan kode kepada siapa pun.

{{ $supportText ?? 'Jika kamu tidak meminta reset kata sandi, abaikan email ini atau hubungi admin toko.' }}

FLORASHOP - Aplikasi kasir toko bunga
{{ $brandUrl ?? config('app.url') }}
