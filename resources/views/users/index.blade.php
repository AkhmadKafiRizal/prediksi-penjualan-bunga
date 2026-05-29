<x-app-layout>
<style>
:root{--pk1:#E8185A;--pk2:#F04E8A;--pk3:#F87FB5;--pk4:#FDB8D4;--pk5:#FDE8F2;--pk6:#FFF2F8;--dark:#1A0A12}
*{box-sizing:border-box}

.fp-eyebrow{font-size:10px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--pk1);margin-bottom:3px}
.fp-title{font-size:22px;font-weight:800;color:var(--dark);margin-bottom:20px}

.fp-btn{display:inline-flex;align-items:center;gap:.4rem;padding:.5rem 1.1rem;border:none;border-radius:10px;font-family:inherit;font-size:.84rem;font-weight:600;cursor:pointer;text-decoration:none;transition:all .2s}
.fp-btn-primary{background:linear-gradient(135deg,var(--pk1),var(--pk2));color:#fff;box-shadow:0 4px 14px rgba(232,24,90,.3)}
.fp-btn-primary:hover{box-shadow:0 6px 20px rgba(232,24,90,.4);transform:translateY(-1px)}
.fp-btn-outline{background:#fff;color:#7A2A4A;border:1px solid #FCE4EF}
.fp-btn-outline:hover{border-color:var(--pk3);background:var(--pk6)}
.fp-btn-secondary{background:var(--pk5);color:var(--pk1);border:1px solid #FBCEDE}
.fp-btn-secondary:hover{background:var(--pk4);color:#7A1A3A}
.fp-btn-deactivate{background:#fff;color:#B91C1C;border:1px solid #FECACA;box-shadow:none}
.fp-btn-deactivate:hover{background:#FEF2F2;border-color:#FCA5A5;transform:translateY(-1px)}
.fp-btn-activate{background:#ECFDF5;color:#047857;border:1px solid #A7F3D0;box-shadow:none}
.fp-btn-activate:hover{background:#10B981;border-color:#10B981;color:#fff;transform:translateY(-1px)}
.fp-btn.is-loading{opacity:.75;pointer-events:none}
.fp-btn-sm{padding:.3rem .7rem;font-size:.78rem}

.fp-alert{display:flex;align-items:center;gap:.6rem;padding:.75rem 1.1rem;border-radius:12px;font-size:.84rem;font-weight:500;margin-bottom:1.1rem}
.fp-alert-success{background:#ecfdf5;border:1px solid #6ee7b7;color:#065f46}
.fp-alert-error{background:#fef2f2;border:1px solid #fca5a5;color:#991b1b}
.fp-submit-toast{position:fixed;right:24px;top:24px;z-index:1100;display:none;align-items:center;gap:.55rem;padding:.78rem 1rem;border-radius:12px;background:#fff;color:#7A2A4A;border:1px solid #FCE4EF;box-shadow:0 18px 45px rgba(232,24,90,.16);font-size:.82rem;font-weight:700}
.fp-submit-toast.show{display:flex}
.fp-submit-toast-dot{width:9px;height:9px;border-radius:999px;background:var(--pk1);box-shadow:0 0 0 5px rgba(232,24,90,.12)}

/* Stat cards */
.fp-stats-row{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px;margin-bottom:18px}
.fp-stat-card{background:#fff;border-radius:14px;padding:16px 18px;border:1px solid #FCE4EF;position:relative;overflow:hidden}
.fp-stat-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;border-radius:3px 3px 0 0}
.fp-stat-card.c-rose::before{background:linear-gradient(90deg,var(--pk1),var(--pk2))}
.fp-stat-card.c-green::before{background:linear-gradient(90deg,#22c55e,#86efac)}
.fp-stat-card.c-muted::before{background:linear-gradient(90deg,var(--pk3),var(--pk4))}
.fp-stat-label{font-size:.68rem;color:#CCA8BA;font-weight:600;text-transform:uppercase;letter-spacing:.09em}
.fp-stat-val{font-size:1.75rem;font-weight:800;color:var(--dark);font-family:'DM Mono',monospace;margin-top:6px}
.fp-stat-val.rose{color:var(--pk1)}
.fp-stat-val.green{color:#15803d}
.fp-stat-val.muted{color:#CCA8BA}

.fp-card{background:#fff;border-radius:16px;border:1px solid #FCE4EF;overflow:hidden}
.fp-toolbar{display:flex;align-items:center;justify-content:space-between;padding:.9rem 1.25rem;border-bottom:1px solid #FCE4EF;flex-wrap:wrap;gap:.7rem}
.fp-toolbar-left{display:flex;align-items:center;gap:.65rem;flex-wrap:wrap}
.fp-toolbar-title-group{display:flex;flex-direction:column;gap:.15rem;min-width:230px}
.fp-toolbar-title{font-size:.9rem;font-weight:700;color:var(--dark)}
.fp-toolbar-meta{font-size:.75rem;color:#9B6A80;font-weight:500;line-height:1.35}
.fp-badge-count{background:var(--pk5);color:var(--pk1);border-radius:20px;padding:.15rem .65rem;font-size:.72rem;font-weight:700;border:1px solid #FBCEDE}

.fp-filter-bar{display:flex;align-items:center;gap:.55rem;padding:.85rem 1.25rem;border-bottom:1px solid #FCE4EF;flex-wrap:wrap;background:var(--pk6)}
.fp-filter-label{font-size:.72rem;font-weight:700;color:#7A2A4A;text-transform:uppercase;letter-spacing:.08em;white-space:nowrap}
.fp-filter-select{padding:.42rem .75rem;border:1px solid #FCE4EF;border-radius:9px;font-family:inherit;font-size:.82rem;color:var(--dark);background:#fff;outline:none;cursor:pointer;transition:border .15s}
.fp-filter-select:focus{border-color:var(--pk2);box-shadow:0 0 0 3px rgba(232,24,90,.08)}
.fp-search-box{display:flex;align-items:center;gap:.5rem;background:#fff;border:1px solid #FCE4EF;border-radius:10px;padding:.42rem .85rem}
.fp-search-box input{border:none;background:transparent;font-family:inherit;font-size:.84rem;color:var(--dark);outline:none;width:250px}
.fp-search-box input::placeholder{color:#CCA8BA}

.fp-table-wrap{overflow-x:auto}
.fp-table{width:100%;border-collapse:collapse}
.fp-table thead tr{background:var(--pk6)}
.fp-table th{padding:.78rem 1.1rem;text-align:left;font-size:.67rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#CCA8BA;border-bottom:1px solid #FCE4EF;white-space:nowrap}
.fp-table tbody tr{border-bottom:1px solid #FFF0F6;transition:background .12s}
.fp-table tbody tr:last-child{border-bottom:none}
.fp-table tbody tr:hover{background:var(--pk6)}
.fp-table td{padding:.82rem 1.1rem;font-size:.875rem;color:#4A2A3A;vertical-align:middle}
.fp-table td.row-num{font-size:.75rem;color:#CCA8BA;font-family:'DM Mono',monospace;width:48px}
.fp-actions{display:flex;align-items:center;gap:.35rem}
.fp-empty{text-align:center;padding:3rem 2rem;color:#CCA8BA}
.fp-empty p{font-size:.875rem;margin-top:.6rem}

/* Avatar & user cell */
.fp-avatar{width:36px;height:36px;border-radius:50%;background:var(--pk5);color:var(--pk1);font-size:13px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;border:1.5px solid #FBCEDE}
.fp-user-cell{display:flex;align-items:center;gap:10px}
.fp-user-name{font-weight:600;color:var(--dark);font-size:.875rem}
.fp-user-email{font-size:.75rem;color:#CCA8BA}

.badge-active{display:inline-block;background:#ecfdf5;color:#065f46;border-radius:6px;padding:.2rem .65rem;font-size:.74rem;font-weight:600}
.badge-inactive{display:inline-block;background:#f3f4f6;color:#6b7280;border-radius:6px;padding:.2rem .65rem;font-size:.74rem;font-weight:600}
.date-cell{font-size:.8rem;color:#CCA8BA;font-family:'DM Mono',monospace}

/* Modal */
.fp-modal-overlay{display:none;position:fixed;inset:0;background:rgba(26,10,18,.5);backdrop-filter:blur(6px);z-index:999;align-items:center;justify-content:center}
.fp-modal-overlay.open{display:flex}
.fp-modal{background:#fff;border-radius:20px;padding:1.75rem;width:100%;max-width:460px;margin:1rem;box-shadow:0 24px 60px rgba(232,24,90,.12);animation:modalIn .2s ease;border:1px solid #FCE4EF}
@keyframes modalIn{from{opacity:0;transform:translateY(14px) scale(.97)}to{opacity:1;transform:translateY(0) scale(1)}}
.fp-modal-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.4rem}
.fp-modal-title{font-size:1.05rem;font-weight:700;color:var(--dark)}
.fp-modal-close{width:30px;height:30px;border-radius:8px;border:1px solid #FCE4EF;background:var(--pk6);color:#CCA8BA;cursor:pointer;font-size:1rem;display:flex;align-items:center;justify-content:center;transition:all .15s}
.fp-modal-close:hover{background:var(--pk5);color:var(--pk1);border-color:#FBCEDE}
.fp-form-group{margin-bottom:1rem}
.fp-form-group label{display:block;font-size:.78rem;font-weight:600;color:#7A2A4A;margin-bottom:.4rem}
.fp-form-group input{width:100%;padding:.6rem .85rem;border:1px solid #FCE4EF;border-radius:10px;font-family:inherit;font-size:.875rem;color:var(--dark);background:var(--pk6);outline:none;box-sizing:border-box;transition:border .15s,box-shadow .15s}
.fp-form-group input:focus{border-color:var(--pk2);box-shadow:0 0 0 3px rgba(232,24,90,.1);background:#fff}
.fp-form-hint{font-size:.72rem;color:#CCA8BA;margin-top:.3rem}
.fp-modal-footer{display:flex;justify-content:flex-end;gap:.55rem;margin-top:1.4rem;padding-top:1.1rem;border-top:1px solid #FCE4EF}
.fp-modal-icon{width:50px;height:50px;background:var(--pk5);border-radius:13px;display:flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:.9rem}
.fp-modal-body-text{font-size:.875rem;color:#4A2A3A;line-height:1.6}
.fp-modal-body-name{font-weight:700;color:var(--dark)}
.fp-modal-warning{margin-top:.8rem;padding:.75rem .85rem;border-radius:12px;background:#FFF7ED;border:1px solid #FED7AA;color:#9A3412;font-size:.8rem;line-height:1.55}
.fp-modal-warning strong{font-weight:800}

</style>

<div>
    <div class="fp-content-header">
        <div>
            <div class="fp-content-eyebrow">FloraPredict</div>
            <div class="fp-content-title">Manajemen Kasir</div>
            <div class="fp-content-subtitle">Kelola akun kasir aplikasi mobile</div>
        </div>
    </div>

    @if(session('success'))
    <div class="fp-alert fp-alert-success">✔ {{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="fp-alert fp-alert-error">⚠ {{ session('error') }}</div>
    @endif

    @if($errors->any())
    <div class="fp-alert fp-alert-error">Periksa kembali input kasir. Email harus unik dan password minimal 8 karakter.</div>
    @endif

    {{-- Stat cards --}}
    <div class="fp-stats-row">
        <div class="fp-stat-card c-rose">
            <div class="fp-stat-label">Total Kasir</div>
            <div class="fp-stat-val rose">{{ $totalUsers ?? $users->count() }}</div>
        </div>
        <div class="fp-stat-card c-green">
            <div class="fp-stat-label">Kasir Aktif</div>
            <div class="fp-stat-val green">{{ $totalActive ?? $users->where('status', 'aktif')->count() }}</div>
        </div>
        <div class="fp-stat-card c-muted">
            <div class="fp-stat-label">Kasir Nonaktif</div>
            <div class="fp-stat-val muted">{{ $totalInactive ?? $users->where('status', 'nonaktif')->count() }}</div>
        </div>
    </div>

    {{-- Table card --}}
    <div class="fp-card">
        <div class="fp-toolbar">
            <div class="fp-toolbar-left">
                <div class="fp-toolbar-title-group">
                    <span class="fp-toolbar-title">Daftar Akun Kasir</span>
                    <span class="fp-toolbar-meta">Kasir aktif dapat login ke aplikasi mobile dan mencatat transaksi.</span>
                </div>
                <span class="fp-badge-count">{{ $users->count() }} kasir</span>
            </div>
            <button type="button" class="fp-btn fp-btn-primary" onclick="openModal('modal-tambah')">
                + Tambah Kasir
            </button>
        </div>

        <form method="GET" action="{{ route('users.index') }}" id="cashier-filter-form">
            <div class="fp-filter-bar">
                <span class="fp-filter-label">Filter:</span>
                <div class="fp-search-box">
                    🔍 <input type="text" name="search" placeholder="Cari nama atau email kasir..."
                        value="{{ $search ?? '' }}">
                </div>

                <button type="submit" class="fp-btn fp-btn-secondary fp-btn-sm">Cari</button>

                <select name="status" class="fp-filter-select" onchange="document.getElementById('cashier-filter-form').submit()">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ ($filterStatus ?? '') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ ($filterStatus ?? '') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>

                @if(($search ?? false) || ($filterStatus ?? false))
                    <a href="{{ route('users.index') }}" class="fp-btn fp-btn-outline fp-btn-sm">✕ Reset Filter</a>
                @endif
            </div>
        </form>

        <div class="fp-table-wrap">
            <table class="fp-table">
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th>Kasir</th>
                        <th>Terdaftar</th>
                        <th>Status</th>
                        <th style="text-align:center;width:180px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $hasCashierFilters = ($search ?? false) || ($filterStatus ?? false);
                        $emptyCashierMessage = $hasCashierFilters
                            ? 'Tidak ada kasir yang cocok dengan filter saat ini.'
                            : 'Belum ada akun kasir. Tambahkan kasir terlebih dahulu.';

                        if (($filterStatus ?? '') === 'nonaktif' && !($search ?? false)) {
                            $emptyCashierMessage = 'Tidak ada kasir nonaktif saat ini.';
                        } elseif (($filterStatus ?? '') === 'aktif' && !($search ?? false)) {
                            $emptyCashierMessage = 'Tidak ada kasir aktif saat ini.';
                        }
                    @endphp
                    @forelse($users as $i => $user)
                    <tr>
                        <td class="row-num">{{ $i + 1 }}</td>
                        <td>
                            <div class="fp-user-cell">
                                <div class="fp-avatar">{{ substr($user->name, 0, 1) }}</div>
                                <div>
                                    <div class="fp-user-name">{{ $user->name }}</div>
                                    <div class="fp-user-email">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="date-cell">{{ optional($user->created_at)->format('d M Y') ?? '-' }}</td>
                        <td>
                            @if($user->status === 'aktif')
                                <span class="badge-active">Aktif</span>
                            @else
                                <span class="badge-inactive">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="fp-actions" style="justify-content:center">
                                <button type="button"
                                    class="fp-btn fp-btn-outline fp-btn-sm"
                                    title="Edit"
                                    data-cashier-edit
                                    data-user-id="{{ (string) $user->getKey() }}"
                                    data-user-name="{{ $user->name }}"
                                    data-user-email="{{ $user->email }}">
                                    ✏️
                                </button>
                                <button type="button"
                                    class="fp-btn fp-btn-sm {{ $user->status === 'aktif' ? 'fp-btn-deactivate' : 'fp-btn-activate' }}"
                                    title="{{ $user->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}"
                                    data-cashier-status
                                    data-user-id="{{ (string) $user->getKey() }}"
                                    data-user-name="{{ $user->name }}"
                                    data-user-status="{{ $user->status }}">
                                    {{ $user->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="fp-empty">
                                <p>{{ $emptyCashierMessage }}</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH --}}
<div class="fp-modal-overlay" id="modal-tambah">
    <div class="fp-modal">
        <div class="fp-modal-header">
            <span class="fp-modal-title">👤 Tambah Akun Kasir</span>
            <button class="fp-modal-close" onclick="closeModal('modal-tambah')">✕</button>
        </div>
        <form action="{{ route('users.store') }}" method="POST" class="fp-action-form" data-loading-message="Menyimpan akun kasir...">
            @csrf
            <div class="fp-form-group"><label>Nama Lengkap</label><input type="text" name="name" placeholder="contoh: Budi Santoso" required></div>
            <div class="fp-form-group"><label>Email</label><input type="email" name="email" placeholder="contoh: budi@email.com" required></div>
            <div class="fp-form-group"><label>Password</label><input type="password" name="password" placeholder="Minimal 8 karakter" required></div>
            <div class="fp-form-group"><label>Konfirmasi Password</label><input type="password" name="password_confirmation" placeholder="Ulangi password" required></div>
            <div class="fp-modal-footer">
                <button type="button" class="fp-btn fp-btn-outline" onclick="closeModal('modal-tambah')">Batal</button>
                <button type="submit" class="fp-btn fp-btn-primary">Simpan Akun</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT --}}
<div class="fp-modal-overlay" id="modal-edit">
    <div class="fp-modal">
        <div class="fp-modal-header">
            <span class="fp-modal-title">✏️ Edit Akun Kasir</span>
            <button class="fp-modal-close" onclick="closeModal('modal-edit')">✕</button>
        </div>
        <form id="form-edit" action="" method="POST" class="fp-action-form" data-loading-message="Menyimpan perubahan kasir...">
            @csrf @method('PUT')
            <div class="fp-form-group"><label>Nama Lengkap</label><input type="text" id="edit-name" name="name" required></div>
            <div class="fp-form-group"><label>Email</label><input type="email" id="edit-email" name="email" required></div>
            <div class="fp-form-group">
                <label>Password Baru</label>
                <input type="password" id="edit-password" name="password" placeholder="Minimal 8 karakter jika diganti">
                <div class="fp-form-hint">Isi hanya jika ingin mengganti password. Minimal 8 karakter.</div>
            </div>
            <div class="fp-form-group"><label>Konfirmasi Password Baru</label><input type="password" id="edit-password-confirmation" name="password_confirmation" placeholder="Ulangi password baru"></div>
            <div class="fp-modal-footer">
                <button type="button" class="fp-btn fp-btn-outline" onclick="closeModal('modal-edit')">Batal</button>
                <button type="submit" class="fp-btn fp-btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL STATUS --}}
<div class="fp-modal-overlay" id="modal-status">
    <div class="fp-modal" style="max-width:430px">
        <div class="fp-modal-icon" id="status-modal-icon">i</div>
        <div class="fp-modal-title" id="status-modal-title" style="margin-bottom:.5rem">Ubah Status Kasir?</div>
        <div class="fp-modal-body-text">
            Kamu akan <span id="status-modal-action">mengubah status</span> akun kasir
            <span class="fp-modal-body-name" id="status-name-label"></span>.
            <div class="fp-modal-warning" id="status-modal-warning"></div>
        </div>
        <form id="form-status" action="" method="POST" class="fp-action-form" data-loading-message="Memproses status kasir...">
            @csrf
            @method('PATCH')
            <div class="fp-modal-footer">
                <button type="button" class="fp-btn fp-btn-outline" onclick="closeModal('modal-status')">Batal</button>
                <button type="submit" class="fp-btn" id="status-submit-button">Ya, Lanjutkan</button>
            </div>
        </form>
    </div>
</div>

<div class="fp-submit-toast" id="cashier-submit-toast">
    <span class="fp-submit-toast-dot"></span>
    <span id="cashier-submit-toast-text">Memproses...</span>
</div>

<script>
const usersBaseUrl = "{{ url('users') }}";

function openModal(id) {
    document.getElementById(id).classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeModal(id) {
    document.getElementById(id).classList.remove('open');
    document.body.style.overflow = document.querySelector('.fp-modal-overlay.open') ? 'hidden' : '';
}

document.querySelectorAll('.fp-modal-overlay').forEach(el => {
    el.addEventListener('click', function(e) {
        if (e.target === this) closeModal(this.id);
    });
});

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') ['modal-tambah', 'modal-edit', 'modal-status'].forEach(closeModal);
});

document.querySelectorAll('.fp-action-form').forEach(form => {
    form.addEventListener('submit', function() {
        const toast = document.getElementById('cashier-submit-toast');
        const toastText = document.getElementById('cashier-submit-toast-text');
        const submitButton = this.querySelector('button[type="submit"]');

        if (toast && toastText) {
            toastText.textContent = this.dataset.loadingMessage || 'Memproses...';
            toast.classList.add('show');
        }

        if (submitButton) {
            submitButton.classList.add('is-loading');
            submitButton.disabled = true;
            submitButton.dataset.originalText = submitButton.textContent;
            submitButton.textContent = 'Memproses...';
        }
    });
});

document.querySelectorAll('[data-cashier-edit]').forEach(button => {
    button.addEventListener('click', () => {
        openEdit(
            button.dataset.userId,
            button.dataset.userName || '',
            button.dataset.userEmail || ''
        );
    });
});

document.querySelectorAll('[data-cashier-status]').forEach(button => {
    button.addEventListener('click', () => {
        openStatusModal(
            button.dataset.userId,
            button.dataset.userName || '',
            button.dataset.userStatus || 'aktif'
        );
    });
});

function openEdit(id, name, email) {
    document.getElementById('edit-name').value = name;
    document.getElementById('edit-email').value = email;
    document.getElementById('edit-password').value = '';
    document.getElementById('edit-password-confirmation').value = '';
    document.getElementById('form-edit').action = `${usersBaseUrl}/${id}`;
    openModal('modal-edit');
}

function openStatusModal(id, name, status) {
    const isActive = status === 'aktif';
    const submitButton = document.getElementById('status-submit-button');
    const warning = document.getElementById('status-modal-warning');

    document.getElementById('form-status').action = `${usersBaseUrl}/${id}/status`;
    document.getElementById('status-name-label').textContent = name;
    document.getElementById('status-modal-icon').textContent = isActive ? '!' : 'i';
    document.getElementById('status-modal-title').textContent = isActive ? 'Nonaktifkan Akun Kasir?' : 'Aktifkan Akun Kasir?';
    document.getElementById('status-modal-action').textContent = isActive ? 'menonaktifkan' : 'mengaktifkan';

    warning.innerHTML = isActive
        ? '<strong>Dampaknya:</strong> kasir ini tidak bisa login ke aplikasi mobile, tidak bisa mencatat transaksi baru, dan token login mobile akan dihapus dari database. Data penjualan lama tetap tersimpan untuk pertanggungjawaban.'
        : '<strong>Dampaknya:</strong> kasir ini bisa login kembali ke aplikasi mobile dan mencatat transaksi baru. Akun tetap menggunakan email dan password yang sudah tersimpan.';

    submitButton.className = `fp-btn ${isActive ? 'fp-btn-deactivate' : 'fp-btn-activate'}`;
    submitButton.textContent = isActive ? 'Ya, Nonaktifkan' : 'Ya, Aktifkan';
    submitButton.disabled = false;
    submitButton.classList.remove('is-loading');

    openModal('modal-status');
}

</script>
</x-app-layout>
