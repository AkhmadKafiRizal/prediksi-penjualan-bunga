<x-app-layout>

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap');
*{box-sizing:border-box}

:root{
    --pk1:#E8185A;--pk2:#F04E8A;--pk3:#F87FB5;--pk4:#FDB8D4;--pk5:#FDE8F2;--pk6:#FFF2F8;
    --dark:#1A0A12;
}

.fp-pro-page {
    max-width: 760px;
    margin: 0 auto;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

/* ── Header ── */
.fp-pro-header {
    margin-bottom: 24px;
}
.fp-eyebrow {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: var(--pk1);
    margin-bottom: 3px;
}
.fp-pro-title {
    font-size: 22px;
    font-weight: 800;
    color: var(--dark);
    margin-bottom: 2px;
}
.fp-pro-subtitle {
    font-size: 13px;
    color: #CCA8BA;
}

/* ── Avatar banner ── */
.fp-pro-banner {
    background: linear-gradient(135deg, var(--pk1) 0%, var(--pk2) 50%, var(--pk3) 100%);
    border-radius: 20px;
    padding: 28px 28px 24px;
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 18px;
    position: relative;
    overflow: hidden;
}
.fp-pro-banner::before {
    content: '';
    position: absolute;
    right: -30px;
    top: -30px;
    width: 180px;
    height: 180px;
    background: rgba(255,255,255,0.08);
    border-radius: 50%;
}
.fp-pro-banner::after {
    content: '';
    position: absolute;
    right: 40px;
    bottom: -40px;
    width: 120px;
    height: 120px;
    background: rgba(255,255,255,0.06);
    border-radius: 50%;
}
.fp-pro-av-big {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    background: rgba(255,255,255,0.3);
    border: 3px solid rgba(255,255,255,0.5);
    color: #fff;
    font-size: 28px;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    position: relative;
    z-index: 1;
    backdrop-filter: blur(4px);
}
.fp-pro-banner-info {
    position: relative;
    z-index: 1;
}
.fp-pro-banner-name {
    font-size: 20px;
    font-weight: 800;
    color: #fff;
    margin-bottom: 4px;
}
.fp-pro-banner-email {
    font-size: 13px;
    color: rgba(255,255,255,0.75);
    margin-bottom: 10px;
}
.fp-pro-banner-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: rgba(255,255,255,0.2);
    border: 1px solid rgba(255,255,255,0.35);
    border-radius: 8px;
    padding: 4px 12px;
    font-size: 11px;
    font-weight: 700;
    color: #fff;
    backdrop-filter: blur(4px);
}

/* ── Section card ── */
.fp-pro-card {
    background: #fff;
    border: 1px solid #FCE4EF;
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 16px;
    transition: box-shadow 0.2s;
}
.fp-pro-card:hover {
    box-shadow: 0 4px 20px rgba(232,24,90,0.07);
}
.fp-pro-card-head {
    padding: 16px 22px;
    border-bottom: 1px solid #FCE4EF;
    display: flex;
    align-items: center;
    gap: 12px;
}
.fp-pro-card-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: var(--pk5);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
}
.fp-pro-card-title {
    font-size: 14px;
    font-weight: 700;
    color: var(--dark);
}
.fp-pro-card-sub {
    font-size: 11px;
    color: #CCA8BA;
    margin-top: 1px;
}
.fp-pro-card-body {
    padding: 20px 22px;
}

/* ── Form fields ── */
.fp-pro-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
    margin-bottom: 14px;
}
.fp-pro-row.single {
    grid-template-columns: 1fr;
}
.fp-pro-field {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.fp-pro-label {
    font-size: 11.5px;
    font-weight: 700;
    color: #7A4060;
    letter-spacing: 0.02em;
}
.fp-pro-input {
    width: 100%;
    padding: 10px 14px;
    border: 1.5px solid #FCE4EF;
    border-radius: 10px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13.5px;
    color: var(--dark);
    background: var(--pk6);
    outline: none;
    transition: all 0.15s;
}
.fp-pro-input:focus {
    border-color: var(--pk1);
    background: #fff;
    box-shadow: 0 0 0 3px rgba(232,24,90,0.08);
}
.fp-pro-hint {
    font-size: 11px;
    color: #CCA8BA;
}
.fp-pro-hint.is-ok {
    color: #047857;
    font-weight: 600;
}
.fp-pro-hint.is-error {
    color: #DC2626;
    font-weight: 600;
}
.fp-pro-error {
    font-size: 11px;
    color: var(--pk1);
    font-weight: 600;
}

/* ── Alert success ── */
.fp-pro-alert {
    display: flex;
    align-items: center;
    gap: 8px;
    background: #ECFDF5;
    border: 1px solid #6EE7B7;
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 12.5px;
    font-weight: 600;
    color: #065F46;
    margin-bottom: 16px;
}
.fp-pro-alert-error {
    background: #FEF2F2;
    border-color: #FCA5A5;
    color: #991B1B;
}

/* ── Footer actions ── */
.fp-pro-footer {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    padding-top: 16px;
    border-top: 1px solid #FCE4EF;
    margin-top: 4px;
}
.fp-pro-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 10px 20px;
    border-radius: 10px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
    text-decoration: none;
}
.fp-pro-btn-primary {
    background: linear-gradient(135deg, var(--pk1), var(--pk2));
    color: #fff;
    box-shadow: 0 4px 14px rgba(232,24,90,0.28);
}
.fp-pro-btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(232,24,90,0.38);
}
.fp-pro-btn:disabled,
.fp-pro-btn-danger:disabled,
.fp-pro-btn-delete:disabled {
    opacity: 0.55;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}
.fp-pro-btn-primary:disabled:hover {
    transform: none;
    box-shadow: 0 4px 14px rgba(232,24,90,0.18);
}

/* ── Danger zone ── */
.fp-pro-danger {
    background: #FFF5F5;
    border: 1.5px solid #FECACA;
    border-radius: 16px;
    padding: 20px 22px;
    margin-bottom: 16px;
}
.fp-pro-danger-head {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 8px;
}
.fp-pro-danger-icon {
    width: 34px;
    height: 34px;
    background: #FEE2E2;
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    flex-shrink: 0;
}
.fp-pro-danger-title {
    font-size: 13.5px;
    font-weight: 700;
    color: #DC2626;
}
.fp-pro-danger-desc {
    font-size: 12px;
    color: #9090AA;
    margin-bottom: 14px;
    line-height: 1.6;
}
.fp-pro-btn-danger {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 9px 18px;
    background: #FEE2E2;
    color: #DC2626;
    border: 1.5px solid #FECACA;
    border-radius: 10px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
}
.fp-pro-btn-danger:hover {
    background: #FECACA;
    border-color: #FCA5A5;
}
.fp-pro-btn-danger:disabled:hover {
    background: #FEE2E2;
    border-color: #FECACA;
}

/* ── Modal ── */
.fp-pro-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(26,10,18,0.5);
    backdrop-filter: blur(6px);
    z-index: 9999;
    align-items: center;
    justify-content: center;
}
.fp-pro-modal-overlay.open { display: flex; }
.fp-pro-modal {
    background: #fff;
    border-radius: 20px;
    padding: 28px;
    width: 100%;
    max-width: 420px;
    margin: 1rem;
    box-shadow: 0 24px 60px rgba(0,0,0,0.18);
    animation: modalIn 0.2s ease;
}
@keyframes modalIn {
    from { opacity:0; transform:translateY(14px) scale(0.97); }
    to   { opacity:1; transform:translateY(0) scale(1); }
}
.fp-pro-modal-icon {
    width: 52px;
    height: 52px;
    background: #FEE2E2;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    margin-bottom: 14px;
}
.fp-pro-modal-title {
    font-size: 17px;
    font-weight: 800;
    color: var(--dark);
    margin-bottom: 6px;
}
.fp-pro-modal-body {
    font-size: 13px;
    color: #7A4060;
    line-height: 1.6;
    margin-bottom: 18px;
}
.fp-pro-modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 8px;
    padding-top: 14px;
    border-top: 1px solid #FCE4EF;
}
.fp-pro-btn-outline {
    display: inline-flex;
    align-items: center;
    padding: 9px 18px;
    background: #fff;
    color: #7A4060;
    border: 1.5px solid #FCE4EF;
    border-radius: 10px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
}
.fp-pro-btn-outline:hover { border-color: var(--pk4); color: var(--pk1); }
.fp-pro-btn-delete {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 9px 18px;
    background: #DC2626;
    color: #fff;
    border: none;
    border-radius: 10px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: background 0.2s;
}
.fp-pro-btn-delete:hover { background: #B91C1C; }
</style>

<div class="fp-pro-page">

    {{-- Header --}}
    <div class="fp-content-header">
        <div>
            <div class="fp-content-eyebrow">FloraPredict</div>
            <div class="fp-content-title">Pengaturan Profil</div>
            <div class="fp-content-subtitle">Kelola informasi akun dan keamanan kamu</div>
        </div>
    </div>

    {{-- Banner Avatar --}}
    <div class="fp-pro-banner">
        <div class="fp-pro-av-big">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
        <div class="fp-pro-banner-info">
            <div class="fp-pro-banner-name">{{ $user->name }}</div>
            <div class="fp-pro-banner-email">{{ $user->email }}</div>
            <div class="fp-pro-banner-badge">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                Web Administrator
            </div>
        </div>
    </div>

    @php
        $profileNotice = match (session('status')) {
            'profile-updated' => 'Profil berhasil diperbarui.',
            'password-updated' => 'Password berhasil diperbarui.',
            default => null,
        };

        $profileError = session('error')
            ?: ($errors->has('name') || $errors->has('email') ? 'Profil belum bisa disimpan. Periksa kembali nama dan email.' : null)
            ?: ($errors->getBag('updatePassword')->any() ? 'Password belum bisa diperbarui. Periksa kembali password saat ini dan password baru.' : null)
            ?: ($errors->getBag('userDeletion')->any() ? 'Penghapusan akun belum berhasil. Password konfirmasi perlu diperiksa kembali.' : null);
    @endphp

    @if($profileNotice)
        <div class="fp-pro-alert" role="status">✔ {{ $profileNotice }}</div>
    @endif

    @if($profileError)
        <div class="fp-pro-alert fp-pro-alert-error" role="alert">⚠ {{ $profileError }}</div>
    @endif

    {{-- Form Informasi Profil --}}
    <div class="fp-pro-card">
        <div class="fp-pro-card-head">
            <div class="fp-pro-card-icon">👤</div>
            <div>
                <div class="fp-pro-card-title">Informasi Profil</div>
                <div class="fp-pro-card-sub">Perbarui nama dan alamat email akun kamu</div>
            </div>
        </div>
        <div class="fp-pro-card-body">
            <form method="POST" action="{{ route('profile.update') }}" id="profile-info-form"
                  data-original-name="{{ $user->name }}"
                  data-original-email="{{ $user->email }}">
                @csrf
                @method('patch')

                <div class="fp-pro-row">
                    <div class="fp-pro-field">
                        <label class="fp-pro-label">Nama Lengkap</label>
                        <input class="fp-pro-input" type="text" name="name" id="profile-name"
                               value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                        @error('name')
                            <div class="fp-pro-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="fp-pro-field">
                        <label class="fp-pro-label">Alamat Email</label>
                        <input class="fp-pro-input" type="email" name="email" id="profile-email"
                               value="{{ old('email', $user->email) }}" required autocomplete="email">
                        @error('email')
                            <div class="fp-pro-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="fp-pro-footer">
                    <button type="submit" class="fp-pro-btn fp-pro-btn-primary" id="profile-save-button" disabled>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Form Ganti Password --}}
    <div class="fp-pro-card">
        <div class="fp-pro-card-head">
            <div class="fp-pro-card-icon">🔒</div>
            <div>
                <div class="fp-pro-card-title">Ganti Password</div>
                <div class="fp-pro-card-sub">Pastikan akun kamu menggunakan password yang kuat</div>
            </div>
        </div>
        <div class="fp-pro-card-body">
            <form method="POST" action="{{ route('password.update') }}" id="profile-password-form" autocomplete="off">
                @csrf
                @method('put')

                <div class="fp-pro-row single">
                    <div class="fp-pro-field">
                        <label class="fp-pro-label">Password Saat Ini</label>
                        <input class="fp-pro-input" type="password" name="current_password" id="profile-current-password" required data-password-clear
                               autocomplete="current-password" placeholder="Masukkan password saat ini">
                        @error('current_password', 'updatePassword')
                            <div class="fp-pro-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="fp-pro-row">
                    <div class="fp-pro-field">
                        <label class="fp-pro-label">Password Baru</label>
                        <input class="fp-pro-input" type="password" name="password" id="profile-new-password" required data-password-clear
                               autocomplete="new-password" placeholder="Minimal 8 karakter">
                        @error('password', 'updatePassword')
                            <div class="fp-pro-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="fp-pro-field">
                        <label class="fp-pro-label">Konfirmasi Password Baru</label>
                        <input class="fp-pro-input" type="password" name="password_confirmation" id="profile-confirm-password" required data-password-clear
                               autocomplete="new-password" placeholder="Ulangi password baru">
                        <div class="fp-pro-hint" id="profile-password-hint">Minimal 8 karakter</div>
                    </div>
                </div>

                <div class="fp-pro-footer">
                    <button type="submit" class="fp-pro-btn fp-pro-btn-primary" id="profile-password-button" disabled>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        Perbarui Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Danger Zone --}}
    <div class="fp-pro-danger">
        <div class="fp-pro-danger-head">
            <div class="fp-pro-danger-icon">⚠️</div>
            <div class="fp-pro-danger-title">Hapus Akun</div>
        </div>
        <div class="fp-pro-danger-desc">
            Akun web admin ini akan dihapus permanen dan tidak bisa dipulihkan. Data produk,
            penjualan, prediksi, dan akun kasir yang sudah tercatat tidak ikut dihapus.
            @if(! $canDeleteAccount && $accountDeleteBlockReason)
                <br><strong style="color:#DC2626">{{ $accountDeleteBlockReason }}</strong>
            @endif
        </div>
        <button class="fp-pro-btn-danger"
            onclick="openDeleteProfileModal()"
            @disabled(! $canDeleteAccount)>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
            Hapus Akun Saya
        </button>
    </div>

</div>

{{-- Modal Hapus Akun --}}
<div class="fp-pro-modal-overlay" id="modal-hapus-akun">
    <div class="fp-pro-modal">
        <div class="fp-pro-modal-icon">⚠️</div>
        <div class="fp-pro-modal-title">Hapus Akun?</div>
        <div class="fp-pro-modal-body">
            Tindakan ini <strong style="color:#DC2626">tidak bisa dibatalkan</strong>.
            Akun web admin kamu akan dihapus permanen dari sistem, tetapi data operasional
            seperti produk, penjualan, prediksi, dan akun kasir tetap tersimpan. Masukkan password
            untuk konfirmasi.
        </div>

        <form method="POST" action="{{ route('profile.destroy') }}" id="profile-delete-form">
            @csrf
            @method('delete')

            <div class="fp-pro-field" style="margin-bottom:16px">
                <label class="fp-pro-label">Password Konfirmasi</label>
                <input class="fp-pro-input" type="password" name="password" id="profile-delete-password"
                       placeholder="Masukkan password kamu" autocomplete="current-password" required>
                @error('password', 'userDeletion')
                    <div class="fp-pro-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="fp-pro-modal-footer">
                <button type="button" class="fp-pro-btn-outline"
                    onclick="document.getElementById('modal-hapus-akun').classList.remove('open')">
                    Batal
                </button>
                <button type="submit" class="fp-pro-btn-delete" id="profile-delete-button" disabled>
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
                    Ya, Hapus Akun
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const deleteModal = document.getElementById('modal-hapus-akun');

function openDeleteProfileModal() {
    if (!deleteModal) return;
    deleteModal.classList.add('open');
    document.getElementById('profile-delete-password')?.focus();
}

function closeDeleteProfileModal() {
    if (!deleteModal) return;
    deleteModal.classList.remove('open');
}

deleteModal?.addEventListener('click', function(e) {
    if (e.target === this) closeDeleteProfileModal();
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeDeleteProfileModal();
});

document.querySelectorAll('[data-password-clear]').forEach(input => {
    const placeholders = {
        'profile-current-password': 'Masukkan password saat ini',
        'profile-new-password': 'Minimal 8 karakter',
        'profile-confirm-password': 'Ulangi password baru',
    };

    input.value = '';
    input.placeholder = placeholders[input.id] || input.placeholder;
});

const profileForm = document.getElementById('profile-info-form');
const profileName = document.getElementById('profile-name');
const profileEmail = document.getElementById('profile-email');
const profileSaveButton = document.getElementById('profile-save-button');

function updateProfileSaveState() {
    if (!profileForm || !profileName || !profileEmail || !profileSaveButton) return;

    const originalName = profileForm.dataset.originalName || '';
    const originalEmail = profileForm.dataset.originalEmail || '';
    const name = profileName.value.trim();
    const email = profileEmail.value.trim();
    const hasChanged = name !== originalName || email !== originalEmail;
    const isValid = name.length > 0 && profileEmail.checkValidity();

    profileSaveButton.disabled = !hasChanged || !isValid;
}

[profileName, profileEmail].forEach(input => {
    input?.addEventListener('input', updateProfileSaveState);
});
updateProfileSaveState();

const passwordForm = document.getElementById('profile-password-form');
const currentPassword = document.getElementById('profile-current-password');
const newPassword = document.getElementById('profile-new-password');
const confirmPassword = document.getElementById('profile-confirm-password');
const passwordButton = document.getElementById('profile-password-button');
const passwordHint = document.getElementById('profile-password-hint');

function updatePasswordButtonState() {
    if (!currentPassword || !newPassword || !confirmPassword || !passwordButton) return;

    const hasCurrent = currentPassword.value.length > 0;
    const longEnough = newPassword.value.length >= 8;
    const matches = newPassword.value.length > 0 && newPassword.value === confirmPassword.value;
    passwordButton.disabled = !(hasCurrent && longEnough && matches);

    if (!passwordHint) return;
    passwordHint.classList.remove('is-ok', 'is-error');
    if (newPassword.value.length === 0 && confirmPassword.value.length === 0) {
        passwordHint.textContent = 'Minimal 8 karakter';
    } else if (!longEnough) {
        passwordHint.textContent = 'Password baru minimal 8 karakter';
        passwordHint.classList.add('is-error');
    } else if (!matches) {
        passwordHint.textContent = 'Konfirmasi password belum sama';
        passwordHint.classList.add('is-error');
    } else {
        passwordHint.textContent = 'Password baru siap diperbarui';
        passwordHint.classList.add('is-ok');
    }
}

[currentPassword, newPassword, confirmPassword].forEach(input => {
    input?.addEventListener('input', updatePasswordButtonState);
});
updatePasswordButtonState();

const deletePassword = document.getElementById('profile-delete-password');
const deleteButton = document.getElementById('profile-delete-button');
deletePassword?.addEventListener('input', function() {
    if (deleteButton) {
        deleteButton.disabled = this.value.trim().length === 0;
    }
});

profileForm?.addEventListener('submit', function() {
    if (profileSaveButton) {
        profileSaveButton.disabled = true;
        profileSaveButton.textContent = 'Menyimpan...';
    }
});

passwordForm?.addEventListener('submit', function() {
    if (passwordButton) {
        passwordButton.disabled = true;
        passwordButton.textContent = 'Memperbarui...';
    }
});

document.getElementById('profile-delete-form')?.addEventListener('submit', function() {
    if (deleteButton) {
        deleteButton.disabled = true;
        deleteButton.textContent = 'Menghapus...';
    }
});

if (@json($errors->getBag('userDeletion')->any())) {
    openDeleteProfileModal();
}
</script>

</x-app-layout>
