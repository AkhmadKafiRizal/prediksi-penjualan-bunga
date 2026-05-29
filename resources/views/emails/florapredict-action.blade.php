@php
    $features = $features ?? [];
    $brandUrl = $brandUrl ?? config('app.url');
    $safeUrl = $actionUrl ?? '#';
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <title>{{ $subjectText ?? 'FloraPredict' }}</title>
    <style>
        @media only screen and (max-width: 640px) {
            .fp-shell { width: 100% !important; }
            .fp-card { border-radius: 0 !important; }
            .fp-pad { padding-left: 22px !important; padding-right: 22px !important; }
            .fp-title { font-size: 26px !important; line-height: 32px !important; }
            .fp-feature { display: block !important; width: 100% !important; margin-bottom: 10px !important; }
            .fp-button { width: 100% !important; text-align: center !important; }
        }
    </style>
</head>
<body style="margin:0;padding:0;background:#fff5fa;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;color:#1f1020;">
    <div style="display:none;max-height:0;overflow:hidden;opacity:0;color:transparent;">
        {{ $preheader ?? 'Notifikasi akun FloraPredict.' }}
    </div>

    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background:#fff5fa;margin:0;padding:0;">
        <tr>
            <td align="center" style="padding:34px 12px;">
                <table class="fp-shell" width="640" cellpadding="0" cellspacing="0" role="presentation" style="width:640px;max-width:640px;margin:0 auto;">
                    <tr>
                        <td class="fp-card" style="background:#ffffff;border:1px solid #f9cfe1;border-radius:24px;overflow:hidden;box-shadow:0 24px 70px rgba(184,24,84,0.16);">
                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                    <td class="fp-pad" style="background:linear-gradient(135deg,#E8185A 0%,#F04E8A 58%,#F87FB5 100%);padding:30px 36px 34px;">
                                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                            <tr>
                                                <td align="left" style="vertical-align:middle;">
                                                    <table cellpadding="0" cellspacing="0" role="presentation">
                                                        <tr>
                                                            <td width="50" height="50" align="center" style="width:50px;height:50px;background:#ffffff;border-radius:15px;box-shadow:0 10px 26px rgba(122,20,58,0.22);">
                                                                <span style="display:inline-block;color:#E8185A;font-size:28px;line-height:50px;font-weight:800;">&#10045;</span>
                                                            </td>
                                                            <td style="padding-left:14px;">
                                                                <div style="font-size:24px;line-height:28px;font-weight:800;color:#ffffff;letter-spacing:0;">FloraPredict</div>
                                                                <div style="font-size:11px;line-height:14px;font-weight:800;letter-spacing:2px;text-transform:uppercase;color:#ffe4f0;">Web Admin</div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td align="right" style="vertical-align:middle;">
                                                    <span style="display:inline-block;padding:8px 12px;border:1px solid rgba(255,255,255,0.5);border-radius:999px;background:rgba(255,255,255,0.16);color:#ffffff;font-size:12px;font-weight:700;">
                                                        {{ $badge ?? 'Keamanan Akun' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>

                                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                            <tr>
                                                <td style="padding-top:28px;">
                                                    <div style="font-size:13px;line-height:18px;font-weight:800;letter-spacing:2px;text-transform:uppercase;color:#ffe4f0;">{{ $eyebrow ?? 'FloraPredict' }}</div>
                                                    <div class="fp-title" style="margin-top:8px;font-size:32px;line-height:38px;font-weight:800;color:#ffffff;">{{ $title ?? 'Notifikasi Akun' }}</div>
                                                    <div style="margin-top:10px;font-size:15px;line-height:23px;color:#fff1f7;max-width:500px;">{{ $subtitle ?? 'Kami membantu menjaga akses akun kamu tetap aman.' }}</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="fp-pad" style="padding:30px 36px 10px;">
                                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background:#fff8fc;border:1px solid #fde2ee;border-radius:18px;">
                                            <tr>
                                                <td style="padding:24px 24px 22px;">
                                                    <div style="font-size:18px;line-height:25px;font-weight:800;color:#1f1020;">Halo, {{ $userName ?? 'Admin FloraPredict' }}</div>
                                                    <div style="margin-top:10px;font-size:14px;line-height:23px;color:#72455c;">
                                                        @foreach (($introLines ?? []) as $line)
                                                            <p style="margin:0 0 10px;text-align:left;">{{ $line }}</p>
                                                        @endforeach
                                                    </div>

                                                    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin:22px 0 20px;">
                                                        <tr>
                                                            <td align="center">
                                                                <a class="fp-button" href="{{ $safeUrl }}" style="display:inline-block;background:#E8185A;background:linear-gradient(135deg,#E8185A,#F04E8A);border-radius:12px;color:#ffffff;text-decoration:none;font-size:14px;font-weight:800;padding:14px 24px;box-shadow:0 12px 24px rgba(232,24,90,0.24);">
                                                                    {{ $actionLabel ?? 'Buka FloraPredict' }}
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </table>

                                                    @if (! empty($noticeTitle) || ! empty($noticeBody))
                                                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background:#ffffff;border:1px solid #f7d7e5;border-radius:14px;margin-top:12px;">
                                                            <tr>
                                                                <td style="padding:14px 16px;">
                                                                    <div style="font-size:13px;line-height:18px;font-weight:800;color:#7A4060;">{{ $noticeTitle ?? 'Catatan keamanan' }}</div>
                                                                    <div style="margin-top:4px;font-size:12.5px;line-height:20px;color:#946579;">{{ $noticeBody ?? '' }}</div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                @if (! empty($features))
                                    <tr>
                                        <td class="fp-pad" style="padding:14px 36px 8px;">
                                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                                <tr>
                                                    @foreach ($features as $feature)
                                                        <td class="fp-feature" width="33.333%" style="width:33.333%;padding:0 5px 10px;vertical-align:top;">
                                                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="border:1px solid #f8d7e6;border-radius:14px;background:#ffffff;">
                                                                <tr>
                                                                    <td style="padding:14px;text-align:center;">
                                                                        <div style="margin:0 auto 8px;width:34px;height:34px;border-radius:10px;background:#fde8f2;color:#E8185A;font-size:17px;line-height:34px;font-weight:800;">{{ $feature['icon'] ?? '*' }}</div>
                                                                        <div style="font-size:12.5px;line-height:18px;font-weight:800;color:#1f1020;">{{ $feature['title'] ?? '' }}</div>
                                                                        <div style="margin-top:3px;font-size:11.5px;line-height:17px;color:#9a6070;">{{ $feature['body'] ?? '' }}</div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                @endif

                                <tr>
                                    <td class="fp-pad" style="padding:12px 36px 32px;">
                                        <div style="font-size:12px;line-height:20px;color:#946579;text-align:left;">
                                            Jika tombol tidak bisa dibuka, salin link berikut ke browser:
                                            <br>
                                            <a href="{{ $safeUrl }}" style="color:#E8185A;text-decoration:none;word-break:break-all;">{{ $safeUrl }}</a>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding:22px 24px 0;color:#9a6070;font-size:12px;line-height:20px;">
                            <strong style="color:#1f1020;">FloraPredict</strong> - Sistem Prediksi Penjualan Bunga<br>
                            Dikembangkan oleh MasKafi - Program Studi Manajemen Informatika<br>
                            <a href="{{ $brandUrl }}" style="color:#E8185A;text-decoration:none;">{{ $brandUrl }}</a><br>
                            &copy; {{ date('Y') }} TA4 Prediksi Penjualan Bunga. Seluruh hak cipta dilindungi.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
