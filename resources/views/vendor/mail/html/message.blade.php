<x-mail::layout>

{{-- Preview Text (hidden in body, visible in inbox preview) --}}
<span style="display:none; opacity:0; color:transparent; height:0; width:0;">
Reset password akun Anda di Sistem Prediksi Penjualan Bunga.
</span>

{{-- Header --}}
<x-slot:header>
<x-mail::header :url="config('app.url')">
Prediksi Penjualan Bunga
</x-mail::header>
</x-slot:header>

{{-- Body Card --}}
<tr>
<td class="body" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f9fafb; padding: 40px 0;">
<table align="center" width="570" cellpadding="0" cellspacing="0" role="presentation"
       style="background: #ffffff; border-radius: 10px; padding: 40px; box-shadow: 0 4px 14px rgba(0,0,0,0.06);">
<tr>
<td style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 15px; color: #374151; line-height: 1.7;">
{!! $slot !!}
</td>
</tr>
</table>
</td>
</tr>

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
© {{ date('Y') }} Sistem TA4 Prediksi Penjualan Bunga<br>
Dikembangkan oleh Mas Kafi dan Team<br>
Program Studi Manajemen Informatika<br>
<a href="{{ config('app.url') }}" style="color:#ec4899; text-decoration:none; font-weight:600;">
{{ config('app.url') }}
</a><br>
Seluruh hak cipta dilindungi.
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>