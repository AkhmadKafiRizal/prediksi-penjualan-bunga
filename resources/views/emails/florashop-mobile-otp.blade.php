@php
    $brandUrl = $brandUrl ?? config('app.url');
    $otpDigits = str_split((string) ($otp ?? '000000'));
    $otpText = implode(' ', $otpDigits);
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="x-apple-disable-message-reformatting">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <title>{{ $subjectText ?? 'Kode Reset Kata Sandi | FLORASHOP' }}</title>
    <style>
        @media only screen and (max-width: 640px) {
            .fs-shell { width: 100% !important; max-width: 100% !important; }
            .fs-card { border-radius: 0 !important; }
            .fs-pad { padding-left: 26px !important; padding-right: 26px !important; }
            .fs-brand { font-size: 21px !important; line-height: 25px !important; }
            .fs-title { font-size: 25px !important; line-height: 31px !important; }
            .fs-subtitle { font-size: 13px !important; line-height: 22px !important; }
            .fs-badge { font-size: 10px !important; padding: 7px 10px !important; }
            .fs-otp { font-size: 31px !important; letter-spacing: 8px !important; }
            .fs-feature { display: block !important; width: 100% !important; padding: 0 0 10px !important; }
        }
    </style>
</head>
<body style="margin:0;padding:0;background:#fff5fa;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;color:#1f1020;">
    <div style="display:none;max-height:0;overflow:hidden;opacity:0;color:transparent;">
        {{ $preheader ?? 'Kode OTP FLORASHOP kamu sudah siap.' }}
    </div>

    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;background:#fff5fa;margin:0;padding:0;">
        <tr>
            <td align="center" style="padding:28px 10px;">
                <table class="fs-shell" width="600" cellpadding="0" cellspacing="0" role="presentation" style="width:600px;max-width:600px;margin:0 auto;">
                    <tr>
                        <td class="fs-card" style="background:#ffffff;border:1px solid #f9cfe1;border-radius:22px;overflow:hidden;">
                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                    <td class="fs-pad" style="background:#E8185A;background:linear-gradient(135deg,#E8185A 0%,#F04E8A 58%,#F87FB5 100%);padding:28px 34px 30px;">
                                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                            <tr>
                                                <td align="left" style="vertical-align:middle;">
                                                    <table cellpadding="0" cellspacing="0" role="presentation">
                                                        <tr>
                                                            <td width="48" height="48" align="center" style="width:48px;height:48px;background:#ffffff;border-radius:14px;">
                                                                <span style="display:inline-block;color:#E8185A;font-size:27px;line-height:48px;font-weight:900;">&#10045;</span>
                                                            </td>
                                                            <td style="padding-left:13px;">
                                                                <div class="fs-brand" style="font-size:23px;line-height:27px;font-weight:900;color:#ffffff;letter-spacing:0;">FLORASHOP</div>
                                                                <div style="font-size:10.5px;line-height:14px;font-weight:800;letter-spacing:2px;text-transform:uppercase;color:#ffe4f0;">Akun Kasir Mobile</div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td align="right" style="vertical-align:middle;">
                                                    <span class="fs-badge" style="display:inline-block;padding:8px 12px;border:1px solid rgba(255,255,255,0.58);border-radius:999px;background:rgba(255,255,255,0.15);color:#ffffff;font-size:11px;line-height:14px;font-weight:800;">
                                                        Reset Kata Sandi
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>

                                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                            <tr>
                                                <td style="padding-top:26px;">
                                                    <div style="font-size:12px;line-height:17px;font-weight:900;letter-spacing:2px;text-transform:uppercase;color:#ffe4f0;">Kode Verifikasi</div>
                                                    <div class="fs-title" style="margin-top:8px;font-size:29px;line-height:35px;font-weight:900;color:#ffffff;">Kode OTP akun kasir</div>
                                                    <div class="fs-subtitle" style="margin-top:10px;font-size:14px;line-height:23px;color:#fff1f7;max-width:470px;">
                                                        Gunakan kode ini di aplikasi FLORASHOP untuk membuat kata sandi baru.
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="fs-pad" style="padding:28px 34px 10px;">
                                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background:#fff8fc;border:1px solid #fde2ee;border-radius:18px;">
                                            <tr>
                                                <td style="padding:24px 22px 24px;text-align:left;">
                                                    <div style="font-size:18px;line-height:25px;font-weight:900;color:#1f1020;">Halo, {{ $userName ?? 'Kasir FLORASHOP' }}</div>
                                                    <div style="margin-top:10px;font-size:14px;line-height:23px;color:#72455c;">
                                                        Kami menerima permintaan untuk mengatur ulang kata sandi akun kasir FLORASHOP kamu.
                                                    </div>

                                                    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin:22px 0 20px;">
                                                        <tr>
                                                            <td align="center" style="background:#ffffff;border:1px solid #f8bdd5;border-radius:16px;padding:20px 12px;">
                                                                <div style="font-size:11px;line-height:16px;font-weight:900;letter-spacing:1.5px;text-transform:uppercase;color:#A84C75;">Kode OTP</div>
                                                                <div class="fs-otp" style="margin-top:8px;font-size:34px;line-height:42px;font-weight:900;letter-spacing:10px;color:#E8185A;font-family:'Segoe UI',Roboto,Arial,sans-serif;">
                                                                    {{ $otpText }}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>

                                                    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background:#ffffff;border:1px solid #f7d7e5;border-radius:14px;margin-top:12px;">
                                                        <tr>
                                                            <td style="padding:14px 16px;">
                                                                <div style="font-size:13px;line-height:18px;font-weight:900;color:#7A4060;">Kode berlaku {{ $expiresInMinutes ?? 5 }} menit</div>
                                                                <div style="margin-top:4px;font-size:12.5px;line-height:20px;color:#946579;">
                                                                    Masukkan kode ini di halaman OTP aplikasi. Jangan bagikan kode kepada siapa pun.
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="fs-pad" style="padding:14px 34px 8px;">
                                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                            <tr>
                                                <td class="fs-feature" width="33.333%" style="width:33.333%;padding:0 5px 10px;vertical-align:top;">
                                                    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="border:1px solid #f8d7e6;border-radius:14px;background:#ffffff;">
                                                        <tr>
                                                            <td style="padding:14px;text-align:center;">
                                                                <div style="margin:0 auto 8px;width:34px;height:34px;border-radius:10px;background:#fde8f2;color:#E8185A;font-size:17px;line-height:34px;font-weight:900;">1</div>
                                                                <div style="font-size:12.5px;line-height:18px;font-weight:900;color:#1f1020;">Aman</div>
                                                                <div style="margin-top:3px;font-size:11.5px;line-height:17px;color:#9a6070;">Kode hanya untuk akun kasir kamu.</div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td class="fs-feature" width="33.333%" style="width:33.333%;padding:0 5px 10px;vertical-align:top;">
                                                    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="border:1px solid #f8d7e6;border-radius:14px;background:#ffffff;">
                                                        <tr>
                                                            <td style="padding:14px;text-align:center;">
                                                                <div style="margin:0 auto 8px;width:34px;height:34px;border-radius:10px;background:#fde8f2;color:#E8185A;font-size:17px;line-height:34px;font-weight:900;">2</div>
                                                                <div style="font-size:12.5px;line-height:18px;font-weight:900;color:#1f1020;">Cepat</div>
                                                                <div style="margin-top:3px;font-size:11.5px;line-height:17px;color:#9a6070;">Buat kata sandi baru dalam beberapa langkah.</div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td class="fs-feature" width="33.333%" style="width:33.333%;padding:0 5px 10px;vertical-align:top;">
                                                    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="border:1px solid #f8d7e6;border-radius:14px;background:#ffffff;">
                                                        <tr>
                                                            <td style="padding:14px;text-align:center;">
                                                                <div style="margin:0 auto 8px;width:34px;height:34px;border-radius:10px;background:#fde8f2;color:#E8185A;font-size:17px;line-height:34px;font-weight:900;">3</div>
                                                                <div style="font-size:12.5px;line-height:18px;font-weight:900;color:#1f1020;">Terbatas</div>
                                                                <div style="margin-top:3px;font-size:11.5px;line-height:17px;color:#9a6070;">Kode otomatis kedaluwarsa.</div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="fs-pad" style="padding:14px 34px 30px;">
                                        <div style="font-size:12px;line-height:20px;color:#946579;text-align:left;">
                                            {{ $supportText ?? 'Jika kamu tidak meminta reset kata sandi, abaikan email ini atau hubungi admin toko.' }}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding:18px 24px 0;color:#9a6070;font-size:12px;line-height:20px;">
                            <strong style="color:#1f1020;">FLORASHOP</strong> - Aplikasi kasir toko bunga<br>
                            Email otomatis untuk keamanan akun kasir mobile<br>
                            <a href="{{ $brandUrl }}" style="color:#E8185A;text-decoration:none;">{{ $brandUrl }}</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
