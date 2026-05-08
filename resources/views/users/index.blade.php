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
.fp-btn-danger{background:#FEE2E2;color:#dc2626;border:none}
.fp-btn-danger:hover{background:#fecaca}
.fp-btn-success{background:#ecfdf5;color:#065f46;border:none}
.fp-btn-success:hover{background:#d1fae5}
.fp-btn-sm{padding:.3rem .7rem;font-size:.78rem}

.fp-alert{display:flex;align-items:center;gap:.6rem;padding:.75rem 1.1rem;border-radius:12px;font-size:.84rem;font-weight:500;margin-bottom:1.1rem}
.fp-alert-success{background:#ecfdf5;border:1px solid #6ee7b7;color:#065f46}
.fp-alert-error{background:#fef2f2;border:1px solid #fca5a5;color:#991b1b}

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
.fp-toolbar-title{font-size:.9rem;font-weight:700;color:var(--dark)}
.fp-badge-count{background:var(--pk5);color:var(--pk1);border-radius:20px;padding:.15rem .65rem;font-size:.72rem;font-weight:700;border:1px solid #FBCEDE}

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

/* Toggle switch */
.fp-toggle-row{display:flex;align-items:center;justify-content:space-between;padding:.6rem .85rem;border:1px solid #FCE4EF;border-radius:10px;background:var(--pk6)}
.fp-toggle-label{font-size:.84rem;color:#7A2A4A;font-weight:500}
.fp-toggle{position:relative;width:38px;height:21px;flex-shrink:0}
.fp-toggle input{opacity:0;width:0;height:0}
.fp-toggle-slider{position:absolute;inset:0;cursor:pointer;background:#FBCEDE;border-radius:21px;transition:.3s}
.fp-toggle-slider::before{content:'';position:absolute;width:15px;height:15px;left:3px;top:3px;background:white;border-radius:50%;transition:.3s}
.fp-toggle input:checked + .fp-toggle-slider{background:var(--pk1)}
.fp-toggle input:checked + .fp-toggle-slider::before{transform:translateX(17px)}
</style>

<div>
    <div class="fp-eyebrow">FloraPredict</div>
    <h1 class="fp-title">Manajemen Kasir</h1>

    @if(session('success'))
    <div class="fp-alert fp-alert-success">✔ {{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="fp-alert fp-alert-error">⚠ {{ session('error') }}</div>
    @endif

    {{-- Stat cards --}}
    <div class="fp-stats-row">
        <div class="fp-stat-card c-rose">
            <div class="fp-stat-label">Total Kasir</div>
            <div class="fp-stat-val rose">{{ $users->count() }}</div>
        </div>
        <div class="fp-stat-card c-green">
            <div class="fp-stat-label">Kasir Aktif</div>
            <div class="fp-stat-val green">{{ $users->where('status', 'aktif')->count() }}</div>
        </div>
        <div class="fp-stat-card c-muted">
            <div class="fp-stat-label">Kasir Nonaktif</div>
            <div class="fp-stat-val muted">{{ $users->where('status', 'nonaktif')->count() }}</div>
        </div>
    </div>

    {{-- Table card --}}
    <div class="fp-card">
        <div class="fp-toolbar">
            <div class="fp-toolbar-left">
                <span class="fp-toolbar-title">Daftar Akun Kasir</span>
                <span class="fp-badge-count">{{ $users->count() }} kasir</span>
            </div>
            <button class="fp-btn fp-btn-primary" onclick="openModal('modal-tambah')">
                + Tambah Kasir
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
                        <th style="text-align:center;width:120px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
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
                        <td class="date-cell">{{ $user->created_at->format('d M Y') }}</td>
                        <td>
                            @if($user->status === 'aktif')
                                <span class="badge-active">Aktif</span>
                            @else
                                <span class="badge-inactive">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="fp-actions" style="justify-content:center">
                                <button class="fp-btn fp-btn-outline fp-btn-sm" title="Edit"
                                    onclick="openEdit({{ $user->id }},'{{ addslashes($user->name) }}','{{ $user->email }}',{{ $user->status === 'aktif' ? 1 : 0 }})">
                                    ✏️
                                </button>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="fp-btn fp-btn-sm {{ $user->status === 'aktif' ? 'fp-btn-danger' : 'fp-btn-success' }}"
                                        title="{{ $user->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}"
                                        onclick="return confirm('{{ $user->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }} kasir {{ $user->name }}?')">
                                        {{ $user->status === 'aktif' ? '🔒' : '🔓' }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="fp-empty">
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

{{-- MODAL TAMBAH --}}
<div class="fp-modal-overlay" id="modal-tambah">
    <div class="fp-modal">
        <div class="fp-modal-header">
            <span class="fp-modal-title">👤 Tambah Akun Kasir</span>
            <button class="fp-modal-close" onclick="closeModal('modal-tambah')">✕</button>
        </div>
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="fp-form-group"><label>Nama Lengkap</label><input type="text" name="name" placeholder="contoh: Budi Santoso" required></div>
            <div class="fp-form-group"><label>Email</label><input type="email" name="email" placeholder="contoh: budi@email.com" required></div>
            <div class="fp-form-group"><label>Password</label><input type="password" name="password" placeholder="Minimal 6 karakter" required></div>
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
        <form id="form-edit" action="" method="POST">
            @csrf @method('PUT')
            <div class="fp-form-group"><label>Nama Lengkap</label><input type="text" id="edit-name" name="name" required></div>
            <div class="fp-form-group"><label>Email</label><input type="email" id="edit-email" name="email" required></div>
            <div class="fp-form-group">
                <label>Password Baru</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak ingin ganti">
                <div class="fp-form-hint">Isi hanya jika ingin mengganti password</div>
            </div>
            <div class="fp-form-group"><label>Konfirmasi Password Baru</label><input type="password" name="password_confirmation" placeholder="Ulangi password baru"></div>
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
function openModal(id) { document.getElementById(id).classList.add('open'); document.body.style.overflow='hidden'; }
function closeModal(id) { document.getElementById(id).classList.remove('open'); document.body.style.overflow=''; }
document.querySelectorAll('.fp-modal-overlay').forEach(el => {
    el.addEventListener('click', function(e) { if (e.target===this) closeModal(this.id); });
});
document.addEventListener('keydown', e => {
    if (e.key==='Escape') ['modal-tambah','modal-edit'].forEach(closeModal);
});
function openEdit(id, name, email, isActive) {
    document.getElementById('edit-name').value = name;
    document.getElementById('edit-email').value = email;
    document.getElementById('edit-active').checked = isActive == 1;
    document.getElementById('form-edit').action = '/users/' + id;
    openModal('modal-edit');
}
</script>
</x-app-layout>