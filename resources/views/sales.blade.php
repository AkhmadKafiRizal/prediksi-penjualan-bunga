<x-app-layout>
<style>
.fp-eyebrow{font-size:.68rem;font-weight:700;letter-spacing:.16em;text-transform:uppercase;background:linear-gradient(135deg,#c0253a,#e85d75);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;margin-bottom:.3rem;}
.fp-title{font-size:1.7rem;font-weight:700;color:#1a1a2e;}
.fp-header{margin-bottom:1.75rem;}
.fp-inner{margin:0 auto;}
.fp-btn{display:inline-flex;align-items:center;gap:.45rem;padding:.6rem 1.2rem;border:none;border-radius:10px;font-family:inherit;font-size:.84rem;font-weight:600;cursor:pointer;text-decoration:none;transition:all .2s ease;}
.fp-btn-primary{background:linear-gradient(135deg,#e85d75,#d44060);color:#fff;box-shadow:0 4px 16px rgba(232,93,117,.35);}
.fp-btn-primary:hover{background:linear-gradient(135deg,#d44060,#c0253a);transform:translateY(-1px);box-shadow:0 6px 20px rgba(232,93,117,.45);}
.fp-btn-outline{background:#fff;color:#4a4a6a;border:1px solid #f0e4e8;}
.fp-btn-outline:hover{border-color:#e85d75;color:#e85d75;background:#fff5f7;}
.fp-btn-danger{background:#fee2e2;color:#dc2626;border:none;}
.fp-btn-danger:hover{background:#fecaca;}
.fp-btn-sm{padding:.35rem .75rem;font-size:.78rem;}

.fp-alert{display:flex;align-items:center;gap:.6rem;padding:.8rem 1.1rem;border-radius:12px;font-size:.84rem;font-weight:500;margin-bottom:1.25rem;}
.fp-alert-success{background:#ecfdf5;border:1px solid #6ee7b7;color:#065f46;}
.fp-alert-error{background:#fef2f2;border:1px solid #fca5a5;color:#991b1b;}

.fp-card{background:#fff;border-radius:18px;border:1px solid #f5e4e8;box-shadow:0 4px 24px rgba(232,93,117,.07);overflow:hidden;}
.fp-toolbar{display:flex;align-items:center;justify-content:space-between;padding:1rem 1.5rem;border-bottom:1px solid #f5e4e8;flex-wrap:wrap;gap:.75rem;background:linear-gradient(135deg,#fff8f9,#fff);}
.fp-toolbar-left{display:flex;align-items:center;gap:.75rem;flex-wrap:wrap;}
.fp-toolbar-title{font-size:.9rem;font-weight:600;color:#4a4a6a;}
.fp-badge-count{background:linear-gradient(135deg,#fde8ec,#ffd0d8);color:#c0253a;border-radius:20px;padding:.15rem .7rem;font-size:.72rem;font-weight:700;}

.fp-search-form{display:flex;align-items:center;gap:.5rem;}
.fp-search-box{display:flex;align-items:center;gap:.5rem;background:#fdf6f0;border:1px solid #f0e4e8;border-radius:10px;padding:.45rem .85rem;}
.fp-search-box input{border:none;background:transparent;font-family:inherit;font-size:.84rem;color:#1a1a2e;outline:none;width:180px;}
.fp-search-box input::placeholder{color:#b0a0b0;}

.fp-table-wrap{overflow-x:auto;max-height:560px;}
.fp-table{width:100%;border-collapse:collapse;}
.fp-table thead tr{background:linear-gradient(135deg,#fff5f7,#fdf0f3);}
.fp-table th{padding:.85rem 1.25rem;text-align:left;font-size:.67rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#b090a0;border-bottom:1px solid #f5e4e8;white-space:nowrap;position:sticky;top:0;background:#fff5f7;z-index:1;}
.fp-table th.right,.fp-table td.right{text-align:right;}
.fp-table tbody tr{border-bottom:1px solid #faf0f3;transition:background .12s;}
.fp-table tbody tr:last-child{border-bottom:none;}
.fp-table tbody tr:hover{background:linear-gradient(135deg,#fff8f9,#fff5f7);}
.fp-table td{padding:.85rem 1.25rem;font-size:.875rem;color:#4a4a6a;vertical-align:middle;}
.fp-table td.row-num{font-size:.75rem;color:#c0b0c0;font-family:'DM Mono',monospace;width:48px;}

.badge-period{display:inline-block;background:linear-gradient(135deg,#fde8ec,#ffd0d8);color:#c0253a;border-radius:7px;padding:.22rem .65rem;font-size:.78rem;font-weight:600;font-family:'DM Mono',monospace;}
.badge-promo{display:inline-block;background:linear-gradient(135deg,#fde8ec,#ffd0d8);color:#c0253a;border-radius:7px;padding:.22rem .65rem;font-size:.75rem;font-weight:700;}
.badge-no-promo{display:inline-block;background:#f3f4f6;color:#6b7280;border-radius:7px;padding:.22rem .65rem;font-size:.75rem;font-weight:700;}

.num-cell{font-family:'DM Mono',monospace;font-size:.84rem;color:#1a1a2e;}
.sales-cell{font-family:'DM Mono',monospace;font-size:.84rem;font-weight:600;color:#c0253a;}
.fp-actions{display:flex;align-items:center;gap:.4rem;}
.fp-empty{text-align:center;padding:3.5rem 2rem;color:#c0b0c0;}
.fp-empty p{font-size:.875rem;margin-top:.75rem;}

.fp-upload-card{background:linear-gradient(135deg,#fff8f9,#fff);border:1.5px dashed #f0b8c3;border-radius:16px;padding:1.2rem 1.5rem;display:flex;align-items:center;gap:1rem;flex-wrap:wrap;margin-bottom:1.25rem;}
.fp-file-label{display:inline-flex;align-items:center;gap:.5rem;padding:.55rem 1rem;border:1px solid #f0e4e8;border-radius:9px;background:#fdf6f0;font-size:.84rem;color:#4a4a6a;cursor:pointer;transition:all .15s;}
.fp-file-label:hover{border-color:#e85d75;background:#fff5f7;}
.fp-file-label input[type="file"]{display:none;}
#file-name-display{font-style:italic;color:#b0a0b0;font-size:.8rem;}

.fp-last-update{display:inline-flex;align-items:center;gap:.4rem;font-size:.79rem;color:#b0a0b0;margin-bottom:1.25rem;}
.fp-last-update strong{color:#4a4a6a;}

.fp-stats-row{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px;margin-bottom:16px;}
.fp-stat-card{background:#fff;border-radius:16px;padding:18px 20px;border:1px solid #f5e4e8;box-shadow:0 2px 14px rgba(232,93,117,.07);position:relative;overflow:hidden;}
.fp-stat-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#c0253a,#e85d75,#f4a0b0);}
.fp-stat-label{font-size:.68rem;color:#b0a0b0;font-weight:700;text-transform:uppercase;letter-spacing:.09em;}
.fp-stat-val{font-size:1.9rem;font-weight:500;color:#1a1a2e;font-family:'DM Mono',monospace;margin-top:8px;}
.fp-stat-val.rose{background:linear-gradient(135deg,#c0253a,#e85d75);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
.fp-stat-val.green{color:#16a34a;}

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
.fp-modal-body-period{font-weight:700;color:#1a1a2e;}

.fp-pagination{padding:1rem 1.5rem;border-top:1px solid #f5e4e8;background:#fff;}

@media(max-width:900px){
    .fp-stats-row{grid-template-columns:1fr;}
}

.fp-btn-secondary{
    background:#fde8ec;
    color:#c0253a;
    border:1px solid #f0b8c3;
}

.fp-btn-secondary:hover{
    background:#fcd5db;
}

</style>

<div class="fp-inner">
    <div class="fp-header">
        <div class="fp-eyebrow">FloraPredict</div>
        <h1 class="fp-title">Data Penjualan Bunga</h1>
    </div>

    @if($lastUpload)
    <div class="fp-last-update">
        Dataset terakhir diupload: <strong>{{ $lastUpload }}</strong>
    </div>
    @endif

    @if(session('success'))
    <div class="fp-alert fp-alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="fp-alert fp-alert-error">
        {{ session('error') }}
    </div>
    @endif

    <form action="{{ route('upload.dataset') }}" method="POST" enctype="multipart/form-data" id="upload-form">
        @csrf
        <div class="fp-upload-card">
            <label class="fp-file-label">
                <input type="file" name="dataset" id="dataset-input" accept=".csv,.txt" required>
                <span id="file-name-display">Pilih file CSV…</span>
            </label>

            <button type="submit" class="fp-btn fp-btn-primary">
                Upload Dataset
            </button>

            <span style="font-size:.77rem;color:#b0a0b0;">
                * Upload disimpan sebagai file dataset. Data utama sistem berasal dari database penjualans.
            </span>
        </div>
    </form>

    <div class="fp-stats-row">
        <div class="fp-stat-card">
            <div class="fp-stat-label">Total Data Database</div>
            <div class="fp-stat-val rose">{{ number_format($totalData ?? 0) }}</div>
        </div>

        <div class="fp-stat-card">
            <div class="fp-stat-label">Rentang Dataset</div>
            <div class="fp-stat-val" style="font-size:1rem;padding-top:10px;">
                {{ $periodeDataset ?? '-' }}
            </div>
        </div>

        <div class="fp-stat-card">
            <div class="fp-stat-label">Jumlah Produk</div>
            <div class="fp-stat-val green">{{ number_format($totalProduk ?? 0) }}</div>
        </div>
    </div>

    @if(isset($datasetReady) && $datasetReady)
    <div class="fp-alert fp-alert-success">
        ✔ Dataset siap untuk training — data tersedia di database dan dapat digunakan oleh model Machine Learning.
    </div>
    @else
    <div class="fp-alert fp-alert-error">
        ⚠ Dataset belum siap untuk training — data belum tersedia atau belum valid.
    </div>
    @endif

    <div class="fp-card">
        <div class="fp-toolbar">
            <div class="fp-toolbar-left">
                <span class="fp-toolbar-title">Dataset Penjualan dari Database</span>
                <span class="fp-badge-count">{{ number_format($totalData ?? 0) }} baris</span>
                <span class="fp-badge-count">25 data per halaman</span>
            </div>

            <form method="GET" action="{{ route('sales') }}" class="fp-search-form">
                <div class="fp-search-box">
                    <input type="text" name="search" placeholder="Cari tanggal / produk…" value="{{ $search ?? '' }}">
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
                        <th>ID</th>
                        <th>Nama Bunga</th>
                        <th>Tanggal</th>
                        <th class="right">Jumlah</th>
                        <th class="right">Harga</th>
                        <th style="text-align:center">Promo</th>
                        <th style="text-align:center;width:100px">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($rows as $i => $row)
                    <tr>
                        <td class="row-num">
                            {{ ($rows->currentPage() - 1) * $rows->perPage() + $i + 1 }}
                        </td>

                        <td>{{ $row->id }}</td>

                        <td>
                            <strong>{{ $row->nama_bunga ?? 'Produk #' . $row->product_id }}</strong>
                            <div style="font-size:.72rem;color:#b0a0b0;">
                                Product ID: {{ $row->product_id }}
                            </div>
                        </td>

                        <td>
                            <span class="badge-period">{{ $row->tanggal }}</span>
                        </td>

                        <td class="right num-cell">
                            {{ number_format($row->jumlah) }}
                        </td>

                        <td class="right sales-cell">
                            Rp {{ number_format($row->harga, 0, ',', '.') }}
                        </td>

                        <td style="text-align:center">
                            @if((int) $row->promo === 1)
                                <span class="badge-promo">Promo</span>
                            @else
                                <span class="badge-no-promo">Tidak Promo</span>
                            @endif
                        </td>

                        <td>
                            <div class="fp-actions" style="justify-content:center">
                                <button type="button" class="fp-btn fp-btn-outline fp-btn-sm" title="Edit"
                                    onclick="openEdit(
                                        {{ $row->id }},
                                        '{{ $row->product_id }}',
                                        '{{ $row->tanggal }}',
                                        '{{ $row->jumlah }}',
                                        '{{ $row->harga }}',
                                        '{{ $row->promo }}'
                                    )">✏️</button>

                                <button type="button" class="fp-btn fp-btn-danger fp-btn-sm" title="Hapus"
                                    onclick="openDelete({{ $row->id }}, '{{ $row->tanggal }}')">🗑️</button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="fp-empty">
                                <p>Belum ada data penjualan di database.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        
                                        <div class="fp-pagination" style="display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
    <div style="font-size:.82rem;color:#8a7a8a;">
        Menampilkan
        <strong>{{ $rows->firstItem() }}</strong>
        sampai
        <strong>{{ $rows->lastItem() }}</strong>
        dari
        <strong>{{ number_format($rows->total()) }}</strong>
        data
        <br>
        <span style="font-size:.75rem;color:#b0a0b0;">
            Halaman {{ $rows->currentPage() }} dari {{ $rows->lastPage() }}
        </span>
    </div>

<div style="display:flex;gap:.5rem;flex-wrap:wrap;align-items:center;">

    {{-- Pertama --}}
    @if($rows->currentPage() > 1)
        <a href="{{ $rows->url(1) }}" class="fp-btn fp-btn-outline fp-btn-sm">
            « Pertama
        </a>
    @else
        <span class="fp-btn fp-btn-outline fp-btn-sm" style="opacity:.45;cursor:not-allowed;">
            « Pertama
        </span>
    @endif

    {{-- Sebelumnya (SECONDARY / soft pink) --}}
    @if($rows->onFirstPage())
        <span class="fp-btn fp-btn-secondary fp-btn-sm" style="opacity:.45;cursor:not-allowed;">
            ← Sebelumnya
        </span>
    @else
        <a href="{{ $rows->previousPageUrl() }}" class="fp-btn fp-btn-secondary fp-btn-sm">
            ← Sebelumnya
        </a>
    @endif

    {{-- Berikutnya (PRIMARY / strong pink) --}}
    @if($rows->hasMorePages())
        <a href="{{ $rows->nextPageUrl() }}" class="fp-btn fp-btn-primary fp-btn-sm">
            Berikutnya →
        </a>
    @else
        <span class="fp-btn fp-btn-primary fp-btn-sm" style="opacity:.45;cursor:not-allowed;">
            Berikutnya →
        </span>
    @endif

    {{-- Terakhir --}}
    @if($rows->currentPage() < $rows->lastPage())
        <a href="{{ $rows->url($rows->lastPage()) }}" class="fp-btn fp-btn-outline fp-btn-sm">
            Terakhir »
        </a>
    @else
        <span class="fp-btn fp-btn-outline fp-btn-sm" style="opacity:.45;cursor:not-allowed;">
            Terakhir »
        </span>
    @endif

</div>
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
            @csrf
            @method('PUT')

            <div class="fp-form-group">
                <label>Product ID</label>
                <input type="number" id="edit-product-id" name="product_id" min="1" required>
            </div>

            <div class="fp-form-group">
                <label>Tanggal</label>
                <input type="date" id="edit-tanggal" name="tanggal" required>
            </div>

            <div class="fp-form-group">
                <label>Jumlah</label>
                <input type="number" id="edit-jumlah" name="jumlah" min="0" required>
            </div>

            <div class="fp-form-group">
                <label>Harga</label>
                <input type="number" id="edit-harga" name="harga" min="0" required>
            </div>

            <div class="fp-form-group">
                <label>Promo</label>
                <input type="number" id="edit-promo" name="promo" min="0" max="1" required>
                <div class="fp-form-hint">Isi 0 jika tidak promo, 1 jika promo.</div>
            </div>

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
        <div class="fp-modal-body-text">
            Kamu yakin ingin menghapus data tanggal
            <span class="fp-modal-body-period" id="delete-period-label"></span>?
            Tindakan ini <strong>tidak bisa dibatalkan</strong>.
        </div>

        <form id="form-delete" action="" method="POST">
            @csrf
            @method('DELETE')

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

    if (!['csv','txt'].includes(ext)) {
        e.preventDefault();
        alert('File harus berformat CSV atau TXT');
        return;
    }

    if (file.size > 5 * 1024 * 1024) {
        e.preventDefault();
        alert('Ukuran file maksimal 5MB');
        return;
    }

    if (!confirm('Upload ini akan menyimpan file dataset baru.\n\nYakin ingin melanjutkan?')) {
        e.preventDefault();
    }
});

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
    if (e.key === 'Escape') ['modal-edit','modal-delete'].forEach(closeModal);
});

function openEdit(id, productId, tanggal, jumlah, harga, promo) {
    document.getElementById('edit-product-id').value = productId;
    document.getElementById('edit-tanggal').value = tanggal;
    document.getElementById('edit-jumlah').value = jumlah;
    document.getElementById('edit-harga').value = harga;
    document.getElementById('edit-promo').value = promo;
    document.getElementById('form-edit').action = '/data-penjualan/' + id;
    openModal('modal-edit');
}

function openDelete(id, tanggal) {
    document.getElementById('delete-period-label').textContent = tanggal;
    document.getElementById('form-delete').action = '/data-penjualan/' + id;
    openModal('modal-delete');
}
</script>

</x-app-layout>