<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          
        </h2>
    </x-slot>

    <style>
        .fp-profile {
            padding: 2.5rem 1rem 5rem;
            min-height: calc(100vh - 64px);
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .fp-profile * { box-sizing: border-box; }

        .fp-pro-inner {
            max-width: 680px;
            margin: 0 auto;
            width: 100%;
        }

        .fp-pro-eyebrow {
            font-size: 0.7rem; font-weight: 700;
            letter-spacing: 0.14em; text-transform: uppercase;
            color: #e85d75; margin-bottom: 0.25rem;
        }

        .fp-pro-title {
            font-size: 1.7rem; font-weight: 700;
            color: #1a1a2e; margin: 0 0 0.3rem;
        }

        .fp-pro-desc {
            font-size: 0.875rem; color: #9090aa;
            margin: 0 0 2rem;
        }

        .fp-pro-avatar-wrap {
            display: flex; align-items: center; gap: 1.25rem;
            margin-bottom: 2rem;
        }

        .fp-pro-avatar {
            width: 68px; height: 68px; border-radius: 50%;
            background: linear-gradient(135deg, #e85d75, #c94060);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.6rem; font-weight: 700; color: #fff;
            flex-shrink: 0;
            box-shadow: 0 4px 16px rgba(232,93,117,0.3);
        }

        .fp-pro-avatar-info h3 {
            font-size: 1.05rem; font-weight: 700;
            color: #1a1a2e; margin: 0 0 3px;
        }

        .fp-pro-avatar-info p {
            font-size: 0.82rem; color: #9090aa; margin: 0;
        }

        .fp-pro-card {
            background: #fff; border-radius: 16px;
            padding: 1.6rem; border: 1px solid #ece8f0;
            box-shadow: 0 4px 20px rgba(232,93,117,0.06);
            margin-bottom: 1.25rem;
        }

        .fp-pro-card-title {
            font-size: 0.95rem; font-weight: 700;
            color: #1a1a2e; margin-bottom: 0.2rem;
        }

        .fp-pro-card-sub {
            font-size: 0.79rem; color: #9090aa;
            margin-bottom: 1.4rem;
        }

        .fp-pro-group { margin-bottom: 1rem; }

        .fp-pro-group label {
            display: block; font-size: 0.76rem; font-weight: 600;
            color: #4a4a6a; margin-bottom: 0.4rem;
        }

        .fp-pro-group input {
            width: 100%; padding: 0.62rem 0.85rem;
            border: 1.5px solid #ece8f0; border-radius: 10px;
            font-family: inherit; font-size: 0.875rem;
            color: #1a1a2e; background: #faf7f5; outline: none;
            transition: border 0.15s, box-shadow 0.15s;
        }

        .fp-pro-group input:focus {
            border-color: #e85d75;
            box-shadow: 0 0 0 3px rgba(232,93,117,0.1);
            background: #fff;
        }

        .fp-pro-hint  { font-size: 0.71rem; color: #9090aa; margin-top: 0.3rem; }
        .fp-pro-error { font-size: 0.73rem; color: #dc2626; margin-top: 0.3rem; }

        .fp-pro-footer {
            display: flex; justify-content: flex-end;
            margin-top: 1.25rem; padding-top: 1.1rem;
            border-top: 1px solid #f3eff6;
        }

        .fp-pro-btn-primary {
            display: inline-flex; align-items: center; gap: 0.4rem;
            padding: 0.58rem 1.2rem; background: #e85d75; color: #fff;
            border: none; border-radius: 9px; font-family: inherit;
            font-size: 0.84rem; font-weight: 600; cursor: pointer;
            box-shadow: 0 4px 14px rgba(232,93,117,0.3);
            transition: all 0.2s;
        }

        .fp-pro-btn-primary:hover { background: #c94060; transform: translateY(-1px); }

        .fp-pro-btn-danger {
            display: inline-flex; align-items: center; gap: 0.4rem;
            padding: 0.58rem 1.2rem; background: #fee2e2; color: #dc2626;
            border: none; border-radius: 9px; font-family: inherit;
            font-size: 0.84rem; font-weight: 600; cursor: pointer;
            transition: all 0.2s;
        }

        .fp-pro-btn-danger:hover { background: #fecaca; }

        .fp-pro-btn-outline {
            display: inline-flex; align-items: center; gap: 0.4rem;
            padding: 0.58rem 1.2rem; background: #fff; color: #4a4a6a;
            border: 1.5px solid #ece8f0; border-radius: 9px;
            font-family: inherit; font-size: 0.84rem; font-weight: 600;
            cursor: pointer; transition: all 0.2s;
        }

        .fp-pro-btn-outline:hover { border-color: #e85d75; color: #e85d75; }

        .fp-pro-alert-success {
            display: flex; align-items: center; gap: 0.5rem;
            background: #ecfdf5; border: 1px solid #6ee7b7;
            color: #065f46; padding: 0.65rem 1rem;
            border-radius: 9px; font-size: 0.82rem;
            font-weight: 500; margin-bottom: 1.25rem;
        }

        .fp-pro-danger-zone {
            background: #fff5f5; border: 1.5px solid #fecaca;
            border-radius: 16px; padding: 1.4rem;
            margin-bottom: 1.25rem;
        }

        .fp-pro-danger-title {
            font-size: 0.92rem; font-weight: 700;
            color: #dc2626; margin-bottom: 0.25rem;
        }

        .fp-pro-danger-desc {
            font-size: 0.8rem; color: #9090aa; margin-bottom: 1rem;
        }

        /* Modal */
        .fp-pro-modal-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(26,10,16,0.45);
            backdrop-filter: blur(4px); z-index: 9999;
            align-items: center; justify-content: center;
        }

        .fp-pro-modal-overlay.open { display: flex; }

        .fp-pro-modal {
            background: #fff; border-radius: 20px; padding: 2rem;
            width: 100%; max-width: 400px; margin: 1rem;
            box-shadow: 0 24px 60px rgba(0,0,0,0.18);
            animation: proModalIn 0.2s ease;
        }

        @keyframes proModalIn {
            from { opacity:0; transform: translateY(12px) scale(0.97); }
            to   { opacity:1; transform: translateY(0) scale(1); }
        }

        .fp-pro-modal-icon {
            width: 50px; height: 50px; background: #fee2e2;
            border-radius: 12px; display: flex; align-items: center;
            justify-content: center; font-size: 22px; margin-bottom: 1rem;
        }

        .fp-pro-modal-title {
            font-size: 1rem; font-weight: 700;
            color: #1a1a2e; margin-bottom: 0.5rem;
        }

        .fp-pro-modal-body {
            font-size: 0.83rem; color: #4a4a6a;
            line-height: 1.6; margin-bottom: 1.1rem;
        }

        .fp-pro-modal-footer {
            display: flex; justify-content: flex-end; gap: 0.6rem;
            padding-top: 1.1rem; border-top: 1px solid #f3eff6;
        }

        .fp-pro-btn-delete {
            padding: 0.58rem 1.2rem; background: #dc2626; color: #fff;
            border: none; border-radius: 9px; font-family: inherit;
            font-size: 0.84rem; font-weight: 600; cursor: pointer;
            transition: background 0.2s;
        }

        .fp-pro-btn-delete:hover { background: #b91c1c; }
    </style>

    <div class="fp-profile">
    <div class="fp-pro-inner">

        {{-- Header --}}
        <div class="fp-pro-eyebrow">FloraPredict</div>
        <h1 class="fp-pro-title">Pengaturan Profil</h1>
        <p class="fp-pro-desc">Kelola informasi akun dan keamanan kamu</p>

        {{-- Avatar --}}
        <div class="fp-pro-avatar-wrap">
            <div class="fp-pro-avatar">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div class="fp-pro-avatar-info">
                <h3>{{ $user->name }}</h3>
                <p>{{ $user->email }}</p>
            </div>
        </div>

        {{-- Form 1: Update Info --}}
        <div class="fp-pro-card">
            <div class="fp-pro-card-title">Informasi Profil</div>
            <div class="fp-pro-card-sub">Perbarui nama dan alamat email akun kamu</div>

            @if(session('status') === 'profile-updated')
            <div class="fp-pro-alert-success">✅ Profil berhasil diperbarui!</div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')

                <div class="fp-pro-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name"
                           value="{{ old('name', $user->name) }}" required autofocus>
                    @error('name')
                    <div class="fp-pro-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="fp-pro-group">
                    <label>Alamat Email</label>
                    <input type="email" name="email"
                           value="{{ old('email', $user->email) }}" required>
                    @error('email')
                    <div class="fp-pro-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="fp-pro-footer">
                    <button type="submit" class="fp-pro-btn-primary">
                        💾 Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        {{-- Form 2: Ganti Password --}}
        <div class="fp-pro-card">
            <div class="fp-pro-card-title">Ganti Password</div>
            <div class="fp-pro-card-sub">Pastikan akun kamu menggunakan password yang kuat</div>

            @if(session('status') === 'password-updated')
            <div class="fp-pro-alert-success">✅ Password berhasil diperbarui!</div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('put')

                <div class="fp-pro-group">
                    <label>Password Saat Ini</label>
                    <input type="password" name="current_password"
                           autocomplete="current-password">
                    @error('current_password', 'updatePassword')
                    <div class="fp-pro-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="fp-pro-group">
                    <label>Password Baru</label>
                    <input type="password" name="password"
                           autocomplete="new-password">
                    @error('password', 'updatePassword')
                    <div class="fp-pro-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="fp-pro-group">
                    <label>Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation"
                           autocomplete="new-password">
                    <div class="fp-pro-hint">Minimal 8 karakter</div>
                </div>

                <div class="fp-pro-footer">
                    <button type="submit" class="fp-pro-btn-primary">
                        🔒 Perbarui Password
                    </button>
                </div>
            </form>
        </div>

        {{-- Danger Zone --}}
        <div class="fp-pro-danger-zone">
            <div class="fp-pro-danger-title">⚠️ Hapus Akun</div>
            <div class="fp-pro-danger-desc">
                Setelah akun dihapus, semua data akan hilang permanen dan tidak bisa dipulihkan.
            </div>
            <button class="fp-pro-btn-danger"
                onclick="document.getElementById('modal-hapus-akun').classList.add('open')">
                🗑️ Hapus Akun Saya
            </button>
        </div>

    </div>
    </div>

    {{-- Modal Hapus Akun --}}
    <div class="fp-pro-modal-overlay" id="modal-hapus-akun">
        <div class="fp-pro-modal">
            <div class="fp-pro-modal-icon">⚠️</div>
            <div class="fp-pro-modal-title">Hapus Akun?</div>
            <div class="fp-pro-modal-body">
                Tindakan ini <strong>tidak bisa dibatalkan</strong>.
                Semua data akun kamu akan dihapus permanen.
                Masukkan password untuk konfirmasi.
            </div>

            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <div class="fp-pro-group">
                    <label>Password</label>
                    <input type="password" name="password"
                           placeholder="Masukkan password kamu" required>
                    @error('password', 'userDeletion')
                    <div class="fp-pro-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="fp-pro-modal-footer">
                    <button type="button" class="fp-pro-btn-outline"
                        onclick="document.getElementById('modal-hapus-akun').classList.remove('open')">
                        Batal
                    </button>
                    <button type="submit" class="fp-pro-btn-delete">
                        Ya, Hapus Akun
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('modal-hapus-akun')
            .addEventListener('click', function(e) {
                if (e.target === this) this.classList.remove('open');
            });
    </script>

</x-app-layout>