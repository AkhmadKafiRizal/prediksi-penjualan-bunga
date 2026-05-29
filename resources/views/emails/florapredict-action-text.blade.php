{{ $title ?? 'Notifikasi Akun FloraPredict' }}

Halo, {{ $userName ?? 'Admin FloraPredict' }}

@foreach (($introLines ?? []) as $line)
{{ $line }}

@endforeach
{{ $actionLabel ?? 'Buka FloraPredict' }}:
{{ $actionUrl ?? config('app.url') }}

@if (! empty($noticeTitle) || ! empty($noticeBody))
{{ $noticeTitle ?? 'Catatan keamanan' }}
{{ $noticeBody ?? '' }}

@endif
FloraPredict - Sistem Prediksi Penjualan Bunga
Dikembangkan oleh MasKafi - Program Studi Manajemen Informatika
{{ $brandUrl ?? config('app.url') }}
