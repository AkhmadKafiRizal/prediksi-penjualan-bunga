<x-guest-layout>
    @php
        $statusMessage = match (session('status')) {
            'profile-updated-verification-sent' => 'Email profil berhasil diganti. Kami sudah mengirim link verifikasi ke alamat email baru kamu.',
            'verification-link-sent' => 'Link verifikasi baru sudah dikirim ke email kamu.',
            default => null,
        };
    @endphp

    <div class="fp-card">
        <div class="fp-card-logo">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="5" width="18" height="14" rx="2"/>
                <path d="m3 7 9 6 9-6"/>
                <path d="M16 17h3"/>
            </svg>
        </div>

        <div class="fp-card-title">Verifikasi Email</div>
        <div class="fp-card-sub">Cek inbox email kamu sebelum lanjut ke dashboard</div>

        @if ($statusMessage)
            <div class="fp-status">{{ $statusMessage }}</div>
        @endif

        <div style="font-size:13px;color:#7A4060;line-height:1.65;margin-bottom:18px;text-align:center">
            Untuk keamanan akun, alamat email kamu perlu diverifikasi lewat link yang kami kirim.
            Jika email belum masuk, kamu bisa meminta link baru.
        </div>

        <form method="POST" action="{{ route('verification.send') }}" style="margin-bottom:12px">
            @csrf
            <button type="submit" class="fp-submit">Kirim Ulang Link Verifikasi</button>
        </form>

        <form method="POST" action="{{ route('logout') }}" style="text-align:center">
            @csrf
            <button type="submit" class="fp-forgot" style="border:0;background:transparent;cursor:pointer">
                Keluar dari akun
            </button>
        </form>
    </div>
</x-guest-layout>
