<x-app-layout>
<style>
/* ═══ SHARED PINK GRADIENT CREAM THEME ═══ */
.fp-eyebrow{font-size:.68rem;font-weight:700;letter-spacing:.16em;text-transform:uppercase;background:linear-gradient(135deg,#c0253a,#e85d75);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;margin-bottom:.3rem;}
.fp-title{font-size:1.7rem;font-weight:700;color:#1a1a2e;}
.fp-header{margin-bottom:1.75rem;}
.fp-inner{max-width:1100px;margin:0 auto;}
.fp-btn{display:inline-flex;align-items:center;gap:.45rem;padding:.6rem 1.2rem;border:none;border-radius:10px;font-family:inherit;font-size:.84rem;font-weight:600;cursor:pointer;text-decoration:none;transition:all .2s ease;}
.fp-btn-primary{background:linear-gradient(135deg,#e85d75,#d44060);color:#fff;box-shadow:0 4px 16px rgba(232,93,117,.35);}
.fp-btn-primary:hover{background:linear-gradient(135deg,#d44060,#c0253a);transform:translateY(-1px);box-shadow:0 6px 20px rgba(232,93,117,.45);}
.fp-btn-outline{background:#fff;color:#4a4a6a;border:1px solid #f0e4e8;}
.fp-btn-outline:hover{border-color:#e85d75;color:#e85d75;background:#fff5f7;}
.fp-btn-danger{background:#fee2e2;color:#dc2626;border:none;}
.fp-btn-danger:hover{background:#fecaca;}
.fp-btn-success{background:#ecfdf5;color:#065f46;border:none;}
.fp-btn-success:hover{background:#d1fae5;}
.fp-btn-sm{padding:.35rem .75rem;font-size:.78rem;}
.fp-alert{display:flex;align-items:center;gap:.6rem;padding:.8rem 1.1rem;border-radius:12px;font-size:.84rem;font-weight:500;margin-bottom:1.25rem;}
.fp-alert-success{background:#ecfdf5;border:1px solid #6ee7b7;color:#065f46;}
.fp-alert-error{background:#fef2f2;border:1px solid #fca5a5;color:#991b1b;}
.fp-card{background:#fff;border-radius:18px;border:1px solid #f5e4e8;box-shadow:0 4px 24px rgba(232,93,117,.07);overflow:hidden;}
.fp-toolbar{display:flex;align-items:center;justify-content:space-between;padding:1rem 1.5rem;border-bottom:1px solid #f5e4e8;flex-wrap:wrap;gap:.75rem;background:linear-gradient(135deg,#fff8f9,#fff);}
.fp-toolbar-left{display:flex;align-items:center;gap:.75rem;}
.fp-toolbar-title{font-size:.9rem;font-weight:600;color:#4a4a6a;}
.fp-badge-count{background:linear-gradient(135deg,#fde8ec,#ffd0d8);color:#c0253a;border-radius:20px;padding:.15rem .7rem;font-size:.72rem;font-weight:700;}
.fp-search-form{display:flex;align-items:center;gap:.5rem;}
.fp-search-box{display:flex;align-items:center;gap:.5rem;background:#fdf6f0;border:1px solid #f0e4e8;border-radius:10px;padding:.45rem .85rem;}
.fp-search-box input{border:none;background:transparent;font-family:inherit;font-size:.84rem;color:#1a1a2e;outline:none;width:160px;}
.fp-search-box input::placeholder{color:#b0a0b0;}
.fp-table-wrap{overflow-x:auto;}
.fp-table{width:100%;border-collapse:collapse;}
.fp-table thead tr{background:linear-gradient(135deg,#fff5f7,#fdf0f3);}
.fp-table th{padding:.85rem 1.25rem;text-align:left;font-size:.67rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#b090a0;border-bottom:1px solid #f5e4e8;white-space:nowrap;}
.fp-table th.right,.fp-table td.right{text-align:right;}
.fp-table tbody tr{border-bottom:1px solid #faf0f3;transition:background .12s;}
.fp-table tbody tr:last-child{border-bottom:none;}
.fp-table tbody tr:hover{background:linear-gradient(135deg,#fff8f9,#fff5f7);}
.fp-table td{padding:.85rem 1.25rem;font-size:.875rem;color:#4a4a6a;vertical-align:middle;}
.fp-table td.row-num{font-size:.75rem;color:#c0b0c0;font-family:'DM Mono',monospace;width:48px;}
.badge-period{display:inline-block;background:linear-gradient(135deg,#fde8ec,#ffd0d8);color:#c0253a;border-radius:7px;padding:.22rem .65rem;font-size:.78rem;font-weight:600;font-family:'DM Mono',monospace;}
.badge-active{display:inline-block;background:linear-gradient(135deg,#d1fae5,#a7f3d0);color:#065f46;border-radius:7px;padding:.22rem .65rem;font-size:.75rem;font-weight:600;}
.badge-inactive{display:inline-block;background:#f3f4f6;color:#6b7280;border-radius:7px;padding:.22rem .65rem;font-size:.75rem;font-weight:600;}
.num-cell{font-family:'DM Mono',monospace;font-size:.84rem;color:#1a1a2e;}
.sales-cell{font-family:'DM Mono',monospace;font-size:.84rem;font-weight:600;color:#c0253a;}
.fp-actions{display:flex;align-items:center;gap:.4rem;}
.fp-empty{text-align:center;padding:3.5rem 2rem;color:#c0b0c0;}
.fp-empty p{font-size:.875rem;margin-top:.75rem;}
.fp-upload-card{background:linear-gradient(135deg,#fff8f9,#fff);border:1.5px dashed #f0b8c3;border-radius:16px;padding:1.2rem 1.5rem;display:flex;align-items:center;gap:1rem;flex-wrap:wrap;margin-bottom:2rem;}
.fp-file-label{display:inline-flex;align-items:center;gap:.5rem;padding:.55rem 1rem;border:1px solid #f0e4e8;border-radius:9px;background:#fdf6f0;font-size:.84rem;color:#4a4a6a;cursor:pointer;transition:all .15s;}
.fp-file-label:hover{border-color:#e85d75;background:#fff5f7;}
.fp-file-label input[type="file"]{display:none;}
#file-name-display{font-style:italic;color:#b0a0b0;font-size:.8rem;}
.fp-last-update{display:inline-flex;align-items:center;gap:.4rem;font-size:.79rem;color:#b0a0b0;margin-bottom:1.25rem;}
.fp-last-update strong{color:#4a4a6a;}
.fp-modal-overlay{display:none;position:fixed;inset:0;background:rgba(26,10,16,.5);backdrop-filter:blur(6px);z-index:999;align-items:center;justify-content:center;}
.fp-modal-overlay.open{display:flex;}
.fp-modal{background:#fff;border-radius:22px;padding:2rem;width:100%;max-width:460px;margin:1rem;box-shadow:0 28px 70px rgba(232,93,117,.18);animation:modalIn .2s ease;border:1px solid #f5e4e8;}
@keyframes modalIn{from{opacity:0;transform:translateY(16px) scale(.97)}to{opacity:1;transform:translateY(0) scale(1)}}
.fp-modal-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;}
.fp-modal-title{font-size:1.05rem;font-weight:700;color:#1a1a2e;}
.fp-modal-close{width:32px;height:32px;border-radius:9px;border:1px solid #f0e4e8;background:#fdf6f0;color:#b0a0b0;cursor:pointer;font-size:1rem;display:flex;align-items:center;justify-content:center;transition:all .15s;}
.fp-modal-close:hover{background:#fde8ec;color:#e85d75;border-color:#e85d75;}
.fp-form-group{margin-bottom:1.1rem;}
.fp-form-group label{display:block;font-size:.78rem;font-weight:600;color:#4a4a6a;margin-bottom:.4rem;}
.fp-form-group input,.fp-form-group select{width:100%;padding:.65rem .9rem;border:1px solid #f0e4e8;border-radius:10px;font-family:'Plus Jakarta Sans',sans-serif;font-size:.875rem;color:#1a1a2e;background:#fdf6f0;outline:none;box-sizing:border-box;transition:border .15s,box-shadow .15s;}
.fp-form-group input:focus,.fp-form-group select:focus{border-color:#e85d75;box-shadow:0 0 0 3px rgba(232,93,117,.12);background:#fff;}
.fp-form-hint{font-size:.72rem;color:#b0a0b0;margin-top:.3rem;}
.fp-modal-footer{display:flex;justify-content:flex-end;gap:.6rem;margin-top:1.5rem;padding-top:1.25rem;border-top:1px solid #f5e4e8;}
.fp-modal-icon{width:52px;height:52px;background:linear-gradient(135deg,#fde8ec,#ffd0d8);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:24px;margin-bottom:1rem;}
.fp-modal-body-text{font-size:.875rem;color:#4a4a6a;line-height:1.6;}
.fp-modal-body-period,.fp-modal-body-name{font-weight:700;color:#1a1a2e;}
.fp-stats-row{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px;margin-bottom:20px;}
.fp-stat-card{background:#fff;border-radius:16px;padding:18px 20px;border:1px solid #f5e4e8;box-shadow:0 2px 14px rgba(232,93,117,.07);position:relative;overflow:hidden;}
.fp-stat-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#c0253a,#e85d75,#f4a0b0);}
.fp-stat-label{font-size:.68rem;color:#b0a0b0;font-weight:700;text-transform:uppercase;letter-spacing:.09em;}
.fp-stat-val{font-size:1.9rem;font-weight:500;color:#1a1a2e;font-family:'DM Mono',monospace;margin-top:8px;}
.fp-stat-val.rose{background:linear-gradient(135deg,#c0253a,#e85d75);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
.fp-stat-val.green{color:#16a34a;}
.fp-avatar-sm{width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,#e85d75,#f4a0b0);color:white;font-size:13px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 2px 8px rgba(232,93,117,.25);}
.fp-user-cell{display:flex;align-items:center;gap:10px;}
.fp-user-name{font-weight:600;color:#1a1a2e;font-size:.875rem;}
.fp-user-email{font-size:.75rem;color:#b0a0b0;}
.fp-toggle-row{display:flex;align-items:center;justify-content:space-between;padding:.65rem .9rem;border:1px solid #f0e4e8;border-radius:10px;background:#fdf6f0;}
.fp-toggle-label{font-size:.84rem;color:#4a4a6a;font-weight:500;}
.fp-toggle{position:relative;width:40px;height:22px;flex-shrink:0;}
.fp-toggle input{opacity:0;width:0;height:0;}
.fp-toggle-slider{position:absolute;inset:0;cursor:pointer;background:#e0d0d8;border-radius:22px;transition:.3s;}
.fp-toggle-slider::before{content:'';position:absolute;width:16px;height:16px;left:3px;top:3px;background:white;border-radius:50%;transition:.3s;box-shadow:0 1px 4px rgba(0,0,0,.15);}
.fp-toggle input:checked+.fp-toggle-slider{background:linear-gradient(135deg,#22c55e,#4ade80);}
.fp-toggle input:checked+.fp-toggle-slider::before{transform:translateX(18px);}

</style>

<div class="fp-inner">
    <div class="fp-header">
        <div class="fp-eyebrow">FloraPredict</div>
        <h1 class="fp-title">Data Penjualan Bunga</h1>
    </div>

    @if($lastUpload)
    <div class="fp-last-update">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z"/></svg>
        Dataset terakhir diperbarui: <strong>{{ $lastUpload }}</strong>
    </div>
    @endif

    @if(session('success'))
    <div class="fp-alert fp-alert-success">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="fp-alert fp-alert-error">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
        {{ session('error') }}
    </div>
    @endif

    <form action="{{ route('upload.dataset') }}" method="POST" enctype="multipart/form-data" id="upload-form">
        @csrf
        <div class="fp-upload-card">
            <label class="fp-file-label">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13"/></svg>
                <input type="file" name="dataset" id="dataset-input" accept=".csv,.txt" required>
                <span id="file-name-display">Pilih file CSV…</span>
            </label>
            <button type="submit" class="fp-btn fp-btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                Upload Dataset
            </button>
            <span style="font-size:.77rem;color:#b0a0b0;">* Upload akan mengganti seluruh dataset</span>
        </div>
    </form>

    <div class="fp-card">
        <div class="fp-toolbar">
            <div class="fp-toolbar-left">
                <span class="fp-toolbar-title">Dataset Penjualan</span>
                @if(!empty($rows))
                <span class="fp-badge-count">{{ count($rows) }} baris</span>
                @endif
            </div>
            <form method="GET" action="{{ route('sales') }}" class="fp-search-form">
                <div class="fp-search-box">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="color:#b0a0b0;flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
                    <input type="text" name="search" placeholder="Cari periode…" value="{{ $search ?? '' }}">
                </div>
                @if($search ?? false)
                <a href="{{ route('sales') }}" class="fp-btn fp-btn-outline fp-btn-sm">✕ Reset</a>
                @endif
            </form>
        </div>
        <div class="fp-table-wrap">
            <table class="fp-table">
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        @foreach($header as $head)
                        <th class="{{ in_array(strtolower($head), ['sales','quantityordered','quantity_ordered']) ? 'right' : '' }}">{{ $head }}</th>
                        @endforeach
                        <th style="text-align:center;width:100px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rows as $i => $row)
                    <tr>
                        <td class="row-num">{{ $i + 1 }}</td>
                        @foreach($row as $colIndex => $cell)
                            @php
                                $colName = strtolower($header[$colIndex] ?? '');
                                $isYM    = str_contains($colName,'year') || str_contains($colName,'month') || str_contains($colName,'periode');
                                $isSales = str_contains($colName,'sales');
                                $isQty   = str_contains($colName,'quantity') || str_contains($colName,'qty');
                            @endphp
                            @if($isYM)
                                <td><span class="badge-period">{{ $cell }}</span></td>
                            @elseif($isSales)
                                <td class="right sales-cell">{{ is_numeric($cell) ? number_format($cell,2,',','.') : $cell }}</td>
                            @elseif($isQty)
                                <td class="right num-cell">{{ is_numeric($cell) ? number_format($cell) : $cell }}</td>
                            @else
                                <td>{{ $cell }}</td>
                            @endif
                        @endforeach
                        <td>
                            <div class="fp-actions" style="justify-content:center">
                                <button class="fp-btn fp-btn-outline fp-btn-sm" title="Edit" onclick="openEdit({{ $i }}, '{{ addslashes($row[0] ?? '') }}', '{{ addslashes($row[1] ?? '') }}', '{{ addslashes($row[2] ?? '') }}')">✏️</button>
                                <button class="fp-btn fp-btn-danger fp-btn-sm" title="Hapus" onclick="openDelete({{ $i }}, '{{ addslashes($row[0] ?? '') }}')">🗑️</button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="{{ count($header) + 2 }}">
                        <div class="fp-empty">
                            <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                            <p>Belum ada data. Upload dataset terlebih dahulu.</p>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="fp-modal-overlay" id="modal-edit">
    <div class="fp-modal">
        <div class="fp-modal-header">
            <span class="fp-modal-title">✏️ Edit Data Penjualan</span>
            <button class="fp-modal-close" onclick="closeModal('modal-edit')">✕</button>
        </div>
        <form id="form-edit" action="" method="POST">
            @csrf @method('PUT')
            <div class="fp-form-group"><label>Periode (YEAR_MONTH)</label><input type="text" id="edit-ym" name="YEAR_MONTH" pattern="\d{4}-\d{2}" maxlength="7" required><div class="fp-form-hint">Format: YYYY-MM · contoh: 2024-03</div></div>
            <div class="fp-form-group"><label>Quantity Ordered</label><input type="number" id="edit-qty" name="quantityOrdered" min="0" required></div>
            <div class="fp-form-group"><label>Sales (Rp)</label><input type="number" id="edit-sales" name="sales" min="0" step="0.01" required></div>
            <div class="fp-modal-footer">
                <button type="button" class="fp-btn fp-btn-outline" onclick="closeModal('modal-edit')">Batal</button>
                <button type="submit" class="fp-btn fp-btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<div class="fp-modal-overlay" id="modal-delete">
    <div class="fp-modal" style="max-width:400px">
        <div class="fp-modal-icon">🗑️</div>
        <div class="fp-modal-title" style="margin-bottom:.6rem">Hapus Data?</div>
        <div class="fp-modal-body-text">Kamu yakin ingin menghapus data periode <span class="fp-modal-body-period" id="delete-period-label"></span>? Tindakan ini <strong>tidak bisa dibatalkan</strong>.</div>
        <form id="form-delete" action="" method="POST">
            @csrf @method('DELETE')
            <div class="fp-modal-footer">
                <button type="button" class="fp-btn fp-btn-outline" onclick="closeModal('modal-delete')">Batal</button>
                <button type="submit" class="fp-btn" style="background:linear-gradient(135deg,#dc2626,#b91c1c);color:#fff;box-shadow:none;">Ya, Hapus</button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('dataset-input').addEventListener('change', function () {
    document.getElementById('file-name-display').textContent = this.files[0] ? this.files[0].name : 'Pilih file CSV…';
});
document.getElementById('upload-form').addEventListener('submit', function(e) {
    const file = document.getElementById('dataset-input').files[0];
    if (!file) return;
    const ext = file.name.split('.').pop().toLowerCase();
    if (!['csv','txt'].includes(ext)) { e.preventDefault(); alert('File harus berformat CSV atau TXT'); return; }
    if (file.size > 5 * 1024 * 1024) { e.preventDefault(); alert('Ukuran file maksimal 5MB'); return; }
    if (!confirm('Upload ini akan MENGGANTI seluruh dataset yang ada.\n\nYakin ingin melanjutkan?')) { e.preventDefault(); }
});
function openModal(id) { document.getElementById(id).classList.add('open'); document.body.style.overflow = 'hidden'; }
function closeModal(id) { document.getElementById(id).classList.remove('open'); document.body.style.overflow = ''; }
document.querySelectorAll('.fp-modal-overlay').forEach(el => { el.addEventListener('click', function(e) { if (e.target === this) closeModal(this.id); }); });
document.addEventListener('keydown', e => { if (e.key === 'Escape') ['modal-edit','modal-delete'].forEach(closeModal); });
function openEdit(index, ym, qty, sales) {
    document.getElementById('edit-ym').value = ym;
    document.getElementById('edit-qty').value = qty;
    document.getElementById('edit-sales').value = sales;
    document.getElementById('form-edit').action = '/data-penjualan/' + index;
    openModal('modal-edit');
}
function openDelete(index, ym) {
    document.getElementById('delete-period-label').textContent = ym;
    document.getElementById('form-delete').action = '/data-penjualan/' + index;
    openModal('modal-delete');
}
</script>
</x-app-layout>