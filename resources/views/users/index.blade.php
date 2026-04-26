<x-app-layout>

<style>
.fp-eyebrow {
    font-size: 0.7rem; font-weight: 700;
    letter-spacing: 0.14em; text-transform: uppercase;
    color: #e85d75; margin-bottom: 0.25rem;
}
.fp-title { font-size: 1.7rem; font-weight: 700; color: #1a1a2e; }
.fp-header { margin-bottom: 1.75rem; }
.fp-inner {  margin: 0 auto; }

/* Buttons */
.fp-btn {
    display: inline-flex; align-items: center; gap: 0.45rem;
    padding: 0.6rem 1.2rem; border: none; border-radius: 9px;
    font-family: inherit; font-size: 0.84rem; font-weight: 600;
    cursor: pointer; text-decoration: none;
    transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
}
.fp-btn-primary { background: #e85d75; color: #fff; box-shadow: 0 4px 14px rgba(232,93,117,0.3); }
.fp-btn-primary:hover { background: #c94060; transform: translateY(-1px); }
.fp-btn-outline { background: #fff; color: #4a4a6a; border: 1px solid #ece8f0; }
.fp-btn-outline:hover { border-color: #e85d75; color: #e85d75; }
.fp-btn-danger { background: #fee2e2; color: #dc2626; border: none; }
.fp-btn-danger:hover { background: #fecaca; }
.fp-btn-success { background: #ecfdf5; color: #065f46; border: none; }
.fp-btn-success:hover { background: #d1fae5; }
.fp-btn-sm { padding: 0.35rem 0.75rem; font-size: 0.78rem; }

/* Alerts */
.fp-alert {
    display: flex; align-items: center; gap: 0.6rem;
    padding: 0.75rem 1.1rem; border-radius: 10px;
    font-size: 0.84rem; font-weight: 500; margin-bottom: 1.25rem;
}
.fp-alert-success { background: #ecfdf5; border: 1px solid #6ee7b7; color: #065f46; }
.fp-alert-error   { background: #fef2f2; border: 1px solid #fca5a5; color: #991b1b; }

/* Stats row */
.fp-stats-row {
    display: grid; grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 12px; margin-bottom: 20px;
}
.fp-stat-card {
    background: #fff; border-radius: 14px; padding: 16px 20px;
    border: 1px solid #ece8f0;
    box-shadow: 0 2px 12px rgba(232,93,117,0.06);
    position: relative; overflow: hidden;
}
.fp-stat-card::before {
    content: ''; position: absolute;
    top: 0; left: 0; right: 0; height: 3px;
    background: linear-gradient(90deg, #e85d75, #f4a0b0);
    border-radius: 14px 14px 0 0;
}
.fp-stat-label { font-size: 0.7rem; color: #a1a1b5; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; }
.fp-stat-val { font-size: 1.8rem; font-weight: 500; color: #1a1a2e; font-family: 'DM Mono', monospace; margin-top: 6px; }
.fp-stat-val.rose { color: #e85d75; }
.fp-stat-val.green { color: #16a34a; }

/* Card */
.fp-card {
    background: #fff; border-radius: 16px;
    border: 1px solid #ece8f0;
    box-shadow: 0 4px 24px rgba(232,93,117,0.07);
    overflow: hidden;
}
.fp-toolbar {
    display: flex; align-items: center;
    justify-content: space-between;
    padding: 1rem 1.5rem; border-bottom: 1px solid #ece8f0;
    flex-wrap: wrap; gap: 0.75rem;
}
.fp-toolbar-left { display: flex; align-items: center; gap: 0.75rem; }
.fp-toolbar-title { font-size: 0.9rem; font-weight: 600; color: #4a4a6a; }
.fp-badge-count {
    background: #fde8ec; color: #c94060;
    border-radius: 20px; padding: 0.15rem 0.65rem;
    font-size: 0.72rem; font-weight: 700;
}

/* Table */
.fp-table-wrap { overflow-x: auto; }
.fp-table { width: 100%; border-collapse: collapse; }
.fp-table thead tr { background: #fdf5f7; }
.fp-table th {
    padding: 0.8rem 1.25rem; text-align: left;
    font-size: 0.68rem; font-weight: 700;
    letter-spacing: 0.1em; text-transform: uppercase;
    color: #9090aa; border-bottom: 1px solid #ece8f0;
}
.fp-table tbody tr { border-bottom: 1px solid #f3eff6; transition: background 0.12s; }
.fp-table tbody tr:last-child { border-bottom: none; }
.fp-table tbody tr:hover { background: #fff5f7; }
.fp-table td { padding: 0.85rem 1.25rem; font-size: 0.875rem; color: #4a4a6a; vertical-align: middle; }
.fp-table td.row-num { font-size: 0.75rem; color: #c0bbd0; font-family: 'DM Mono', monospace; width: 48px; }
.fp-actions { display: flex; align-items: center; gap: 0.4rem; }
.fp-empty { text-align: center; padding: 3.5rem 2rem; color: #c0bbd0; }
.fp-empty p { font-size: 0.875rem; margin-top: 0.75rem; }

/* Avatar */
.fp-avatar-sm {
    width: 34px; height: 34px; border-radius: 50%;
    background: linear-gradient(135deg, #e85d75, #f4a0b0);
    color: white; font-size: 13px; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.fp-user-cell { display: flex; align-items: center; gap: 10px; }
.fp-user-name { font-weight: 600; color: #1a1a2e; font-size: 0.875rem; }
.fp-user-email { font-size: 0.75rem; color: #9090aa; }

/* Badge */
.badge-active   { display: inline-block; background: #ecfdf5; color: #065f46; border-radius: 6px; padding: 0.22rem 0.65rem; font-size: 0.75rem; font-weight: 600; }
.badge-inactive { display: inline-block; background: #f3f4f6; color: #6b7280; border-radius: 6px; padding: 0.22rem 0.65rem; font-size: 0.75rem; font-weight: 600; }

/* Modal */
.fp-modal-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(26,10,16,0.45); backdrop-filter: blur(4px);
    z-index: 999; align-items: center; justify-content: center;
}
.fp-modal-overlay.open { display: flex; }
.fp-modal {
    background: #fff; border-radius: 20px; padding: 2rem;
    width: 100%; max-width: 460px; margin: 1rem;
    box-shadow: 0 24px 60px rgba(0,0,0,0.18);
    animation: modalIn 0.2s ease;
}
@keyframes modalIn {
    from { opacity:0; transform: translateY(14px) scale(0.97); }
    to   { opacity:1; transform: translateY(0) scale(1); }
}
.fp-modal-header {
    display: flex; align-items: center;
    justify-content: space-between; margin-bottom: 1.5rem;
}
.fp-modal-title { font-size: 1.05rem; font-weight: 700; color: #1a1a2e; }
.fp-modal-close {
    width: 32px; height: 32px; border-radius: 8px;
    border: 1px solid #ece8f0; background: #faf7f5; color: #9090aa;
    cursor: pointer; font-size: 1rem;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.15s;
}
.fp-modal-close:hover { background: #fde8ec; color: #e85d75; border-color: #e85d75; }
.fp-form-group { margin-bottom: 1.1rem; }
.fp-form-group label { display: block; font-size: 0.78rem; font-weight: 600; color: #4a4a6a; margin-bottom: 0.4rem; }
.fp-form-group input {
    width: 100%; padding: 0.65rem 0.9rem;
    border: 1px solid #ece8f0; border-radius: 9px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 0.875rem; color: #1a1a2e;
    background: #faf7f5; outline: none; box-sizing: border-box;
    transition: border 0.15s, box-shadow 0.15s;
}
.fp-form-group input:focus {
    border-color: #e85d75;
    box-shadow: 0 0 0 3px rgba(232,93,117,0.12);
    background: #fff;
}
.fp-form-hint { font-size: 0.72rem; color: #9090aa; margin-top: 0.3rem; }
.fp-modal-footer {
    display: flex; justify-content: flex-end; gap: 0.6rem;
    margin-top: 1.5rem; padding-top: 1.25rem;
    border-top: 1px solid #f3eff6;
}
.fp-modal-icon {
    width: 52px; height: 52px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 24px; margin-bottom: 1rem;
}
.fp-modal-body-text { font-size: 0.875rem; color: #4a4a6a; line-height: 1.6; }
.fp-modal-body-name { font-weight: 700; color: #1a1a2e; }

/* Toggle switch */
.fp-toggle-row {
    display: flex; align-items: center;
    justify-content: space-between;
    padding: 0.65rem 0.9rem;
    border: 1px solid #ece8f0; border-radius: 9px;
    background: #faf7f5;
}
.fp-toggle-label { font-size: 0.84rem; color: #4a4a6a; font-weight: 500; }
.fp-toggle {
    position: relative; width: 40px; height: 22px;
    flex-shrink: 0;
}
.fp-toggle input { opacity: 0; width: 0; height: 0; }
.fp-toggle-slider {
    position: absolute; inset: 0; cursor: pointer;
    background: #ddd; border-radius: 22px; transition: 0.3s;
}
.fp-toggle-slider::before {
    content: ''; position: absolute;
    width: 16px; height: 16px; left: 3px; top: 3px;
    background: white; border-radius: 50%; transition: 0.3s;
}
.fp-toggle input:checked + .fp-toggle-slider { background: #22c55e; }
.fp-toggle input:checked + .fp-toggle-slider::before { transform: translateX(18px); }
</style>

<div class="fp-inner">

    {{-- Header --}}
    <div class="fp-header">
        <div class="fp-eyebrow">FloraPredict</div>
        <h1 class="fp-title">Manajemen Kasir</h1>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
    <div class="fp-alert fp-alert-success">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="fp-alert fp-alert-error">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- Stats --}}
    <div class="fp-stats-row">
        <div class="fp-stat-card">
            <div class="fp-stat-label">Total Kasir</div>
            <div class="fp-stat-val">{{ $users->count() }}</div>
        </div>
        <div class="fp-stat-card">
            <div class="fp-stat-label">Kasir Aktif</div>
            <div class="fp-stat-val green">{{ $users->where('is_active', true)->count() }}</div>
        </div>
        <div class="fp-stat-card">
            <div class="fp-stat-label">Kasir Nonaktif</div>
            <div class="fp-stat-val rose">{{ $users->where('is_active', false)->count() }}</div>
        </div>
    </div>

    {{-- Table --}}
    <div class="fp-card">
        <div class="fp-toolbar">
            <div class="fp-toolbar-left">
                <span class="fp-toolbar-title">Daftar Akun Kasir</span>
                <span class="fp-badge-count">{{ $users->count() }} kasir</span>
            </div>
            <button class="fp-btn fp-btn-primary" onclick="openModal('modal-tambah')">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Tambah Kasir
            </button>
        </div>

        <div class="fp-table-wrap">
            <table class="fp-table">
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th>Kasir</th>
                        <th>Terdaftar</th>
                        <th>Status</th>
                        <th style="text-align:center;width:140px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $i => $user)
                    <tr>
                        <td class="row-num">{{ $i + 1 }}</td>
                        <td>
                            <div class="fp-user-cell">
                                <div class="fp-avatar-sm">{{ substr($user->name, 0, 1) }}</div>
                                <div>
                                    <div class="fp-user-name">{{ $user->name }}</div>
                                    <div class="fp-user-email">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="font-size:0.8rem;color:#9090aa">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td>
                            @if($user->is_active)
                                <span class="badge-active">Aktif</span>
                            @else
                                <span class="badge-inactive">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="fp-actions" style="justify-content:center">
                                <button class="fp-btn fp-btn-outline fp-btn-sm"
                                    title="Edit"
                                    onclick="openEdit(
                                        {{ $user->id }},
                                        '{{ addslashes($user->name) }}',
                                        '{{ $user->email }}',
                                        {{ $user->is_active ? 1 : 0 }}
                                    )">✏️
                                </button>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="fp-btn fp-btn-sm {{ $user->is_active ? 'fp-btn-danger' : 'fp-btn-success' }}"
                                        title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}"
                                        onclick="return confirm('{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }} kasir {{ $user->name }}?')">
                                        {{ $user->is_active ? '🔒' : '🔓' }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="fp-empty">
                                <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                                </svg>
                                <p>Belum ada akun kasir. Tambahkan kasir terlebih dahulu.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL: TAMBAH --}}
<div class="fp-modal-overlay" id="modal-tambah">
    <div class="fp-modal">
        <div class="fp-modal-header">
            <span class="fp-modal-title">👤 Tambah Akun Kasir</span>
            <button class="fp-modal-close" onclick="closeModal('modal-tambah')">✕</button>
        </div>
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="fp-form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" placeholder="contoh: Budi Santoso" required>
            </div>
            <div class="fp-form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="contoh: budi@email.com" required>
            </div>
            <div class="fp-form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Minimal 6 karakter" required>
            </div>
            <div class="fp-form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" placeholder="Ulangi password" required>
            </div>
            <div class="fp-modal-footer">
                <button type="button" class="fp-btn fp-btn-outline" onclick="closeModal('modal-tambah')">Batal</button>
                <button type="submit" class="fp-btn fp-btn-primary">Simpan Akun</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL: EDIT --}}
<div class="fp-modal-overlay" id="modal-edit">
    <div class="fp-modal">
        <div class="fp-modal-header">
            <span class="fp-modal-title">✏️ Edit Akun Kasir</span>
            <button class="fp-modal-close" onclick="closeModal('modal-edit')">✕</button>
        </div>
        <form id="form-edit" action="" method="POST">
            @csrf
            @method('PUT')
            <div class="fp-form-group">
                <label>Nama Lengkap</label>
                <input type="text" id="edit-name" name="name" required>
            </div>
            <div class="fp-form-group">
                <label>Email</label>
                <input type="email" id="edit-email" name="email" required>
            </div>
            <div class="fp-form-group">
                <label>Password Baru</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak ingin ganti">
                <div class="fp-form-hint">Isi hanya jika ingin mengganti password</div>
            </div>
            <div class="fp-form-group">
                <label>Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" placeholder="Ulangi password baru">
            </div>
            <div class="fp-form-group">
                <label>Status Akun</label>
                <div class="fp-toggle-row">
                    <span class="fp-toggle-label">Akun aktif</span>
                    <label class="fp-toggle">
                        <input type="checkbox" id="edit-active" name="is_active">
                        <span class="fp-toggle-slider"></span>
                    </label>
                </div>
            </div>
            <div class="fp-modal-footer">
                <button type="button" class="fp-btn fp-btn-outline" onclick="closeModal('modal-edit')">Batal</button>
                <button type="submit" class="fp-btn fp-btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(id) {
    document.getElementById(id).classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    document.getElementById(id).classList.remove('open');
    document.body.style.overflow = '';
}
document.querySelectorAll('.fp-modal-overlay').forEach(el => {
    el.addEventListener('click', function(e) {
        if (e.target === this) closeModal(this.id);
    });
});
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') ['modal-tambah', 'modal-edit'].forEach(closeModal);
});

function openEdit(id, name, email, isActive) {
    document.getElementById('edit-name').value    = name;
    document.getElementById('edit-email').value   = email;
    document.getElementById('edit-active').checked = isActive == 1;
    document.getElementById('form-edit').action   = '/users/' + id;
    openModal('modal-edit');
}
</script>

</x-app-layout>