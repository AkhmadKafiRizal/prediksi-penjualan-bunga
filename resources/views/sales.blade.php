<x-app-layout>
<style>
:root{--pk1:#E8185A;--pk2:#F04E8A;--pk3:#F87FB5;--pk4:#FDB8D4;--pk5:#FDE8F2;--pk6:#FFF2F8;--dark:#1A0A12}
*{box-sizing:border-box}

.fp-eyebrow{font-size:10px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--pk1);margin-bottom:3px}
.fp-title{font-size:22px;font-weight:800;color:var(--dark);margin-bottom:18px}

.fp-btn{display:inline-flex;align-items:center;gap:.4rem;padding:.5rem 1.1rem;border:none;border-radius:10px;font-family:inherit;font-size:.84rem;font-weight:600;cursor:pointer;text-decoration:none;transition:all .2s}
.fp-btn-primary{background:linear-gradient(135deg,var(--pk1),var(--pk2));color:#fff;box-shadow:0 4px 14px rgba(232,24,90,.3)}
.fp-btn-primary:hover{box-shadow:0 6px 20px rgba(232,24,90,.4);transform:translateY(-1px)}
.fp-btn-outline{background:#fff;color:#7A2A4A;border:1px solid #FCE4EF}
.fp-btn-outline:hover{border-color:var(--pk3);background:var(--pk6)}
.fp-btn-secondary{background:var(--pk5);color:var(--pk1);border:1px solid #FBCEDE}
.fp-btn-secondary:hover{background:var(--pk4);color:#7A1A3A}
.fp-btn-danger{background:#FEE2E2;color:#dc2626;border:none}
.fp-btn-danger:hover{background:#fecaca}
.fp-btn-sm{padding:.3rem .7rem;font-size:.78rem}

.fp-alert{display:flex;align-items:center;gap:.6rem;padding:.75rem 1.1rem;border-radius:12px;font-size:.84rem;font-weight:500;margin-bottom:1.1rem}
.fp-alert-success{background:#ecfdf5;border:1px solid #6ee7b7;color:#065f46}
.fp-alert-error{background:#fef2f2;border:1px solid #fca5a5;color:#991b1b}

.fp-upload-area{background:#fff;border:1.5px dashed var(--pk3);border-radius:14px;padding:14px 18px;display:flex;align-items:center;gap:12px;flex-wrap:wrap;margin-bottom:16px}
.fp-file-label{display:inline-flex;align-items:center;gap:.5rem;padding:.5rem .9rem;border:1px solid #FCE4EF;border-radius:9px;background:var(--pk6);font-size:.84rem;color:#7A2A4A;cursor:pointer;transition:all .15s}
.fp-file-label:hover{border-color:var(--pk2);background:var(--pk5);color:var(--pk1)}
.fp-file-label input[type="file"]{display:none}
#file-name-display{font-style:italic;color:#CCA8BA;font-size:.8rem}
.fp-upload-hint{font-size:.75rem;color:#CCA8BA}

.fp-stats-row{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px;margin-bottom:16px}
.fp-stat-card{background:#fff;border-radius:14px;padding:16px 18px;border:1px solid #FCE4EF;position:relative;overflow:hidden}
.fp-stat-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;border-radius:3px 3px 0 0}
.fp-stat-card.c-rose::before{background:linear-gradient(90deg,var(--pk1),var(--pk2))}
.fp-stat-card.c-blue::before{background:linear-gradient(90deg,#378add,#85b7eb)}
.fp-stat-card.c-green::before{background:linear-gradient(90deg,#22c55e,#86efac)}
.fp-stat-label{font-size:.68rem;color:#CCA8BA;font-weight:600;text-transform:uppercase;letter-spacing:.09em}
.fp-stat-val{font-size:1.75rem;font-weight:800;color:var(--dark);font-family:'DM Mono',monospace;margin-top:6px}
.fp-stat-val.rose{color:var(--pk1)}
.fp-stat-val.green{color:#15803d}
.fp-stat-val.text-sm{font-size:1rem;padding-top:8px}

.fp-card{background:#fff;border-radius:16px;border:1px solid #FCE4EF;overflow:hidden}
.fp-toolbar{display:flex;align-items:center;justify-content:space-between;padding:.9rem 1.25rem;border-bottom:1px solid #FCE4EF;flex-wrap:wrap;gap:.7rem}
.fp-toolbar-left{display:flex;align-items:center;gap:.65rem;flex-wrap:wrap}
.fp-toolbar-title{font-size:.9rem;font-weight:700;color:var(--dark)}
.fp-badge-count{background:var(--pk5);color:var(--pk1);border-radius:20px;padding:.15rem .65rem;font-size:.72rem;font-weight:700;border:1px solid #FBCEDE}

.fp-search-form{display:flex;align-items:center;gap:.5rem}
.fp-search-box{display:flex;align-items:center;gap:.5rem;background:var(--pk6);border:1px solid #FCE4EF;border-radius:10px;padding:.42rem .85rem}
.fp-search-box input{border:none;background:transparent;font-family:inherit;font-size:.84rem;color:var(--dark);outline:none;width:180px}
.fp-search-box input::placeholder{color:#CCA8BA}

.fp-table-wrap{overflow-x:auto;max-height:540px}
.fp-table{width:100%;border-collapse:collapse}
.fp-table thead tr{background:var(--pk6)}
.fp-table th{padding:.75rem 1.1rem;text-align:left;font-size:.67rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#CCA8BA;border-bottom:1px solid #FCE4EF;white-space:nowrap;position:sticky;top:0;background:var(--pk6);z-index:1}
.fp-table th.right,.fp-table td.right{text-align:right}
.fp-table tbody tr{border-bottom:1px solid #FFF0F6;transition:background .12s}
.fp-table tbody tr:last-child{border-bottom:none}
.fp-table tbody tr:hover{background:var(--pk6)}
.fp-table td{padding:.78rem 1.1rem;font-size:.875rem;color:#4A2A3A;vertical-align:middle}
.fp-table td.row-num{font-size:.75rem;color:#CCA8BA;font-family:'DM Mono',monospace;width:48px}

.badge-date{display:inline-block;background:var(--pk5);color:#7A2A4A;border-radius:6px;padding:.2rem .6rem;font-size:.77rem;font-weight:600;font-family:'DM Mono',monospace}
.badge-promo{display:inline-block;background:var(--pk5);color:var(--pk1);border-radius:6px;padding:.2rem .6rem;font-size:.74rem;font-weight:700;border:1px solid #FBCEDE}
.badge-no-promo{display:inline-block;background:#f3f4f6;color:#6b7280;border-radius:6px;padding:.2rem .6rem;font-size:.74rem;font-weight:700}
.num-cell{font-family:'DM Mono',monospace;font-size:.84rem;color:var(--dark)}
.price-cell{font-family:'DM Mono',monospace;font-size:.84rem;font-weight:700;color:var(--pk1)}
.fp-actions{display:flex;align-items:center;gap:.35rem}
.fp-empty{text-align:center;padding:3rem 2rem;color:#CCA8BA}
.fp-empty p{font-size:.875rem;margin-top:.6rem}

.fp-pagination{padding:.9rem 1.25rem;border-top:1px solid #FCE4EF}

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
.fp-form-group input,.fp-form-group select{width:100%;padding:.6rem .85rem;border:1px solid #FCE4EF;border-radius:10px;font-family:inherit;font-size:.875rem;color:var(--dark);background:var(--pk6);outline:none;box-sizing:border-box;transition:border .15s,box-shadow .15s}
.fp-form-group input:focus,.fp-form-group select:focus{border-color:var(--pk2);box-shadow:0 0 0 3px rgba(232,24,90,.1);background:#fff}
.fp-form-hint{font-size:.72rem;color:#CCA8BA;margin-top:.3rem}
.fp-modal-footer{display:flex;justify-content:flex-end;gap:.55rem;margin-top:1.4rem;padding-top:1.1rem;border-top:1px solid #FCE4EF}
.fp-modal-icon{width:50px;height:50px;background:var(--pk5);border-radius:13px;display:flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:.9rem}
.fp-modal-body-text{font-size:.875rem;color:#4A2A3A;line-height:1.6}
</style>

<div>
    <div class="fp-eyebrow">FloraPredict</div>
    <h1 class="fp-title">Data Penjualan Bunga</h1>

    @if($lastUpload)
    <div style="font-size:.79rem;color:#CCA8BA;margin-bottom:12px;display:flex;align-items:center;gap:5px">
        🕐 Dataset terakhir diupload: <strong style="color:#7A2A4A">{{ $lastUpload }}</strong>
    </div>
    @endif

    @if(session('success'))
    <div class="fp-alert fp-alert-success">✔ {{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="fp-alert fp-alert-error">⚠ {{ session('error') }}</div>
    @endif

    <form action="{{ route('upload.dataset') }}" method="POST" enctype="multipart/form-data" id="upload-form">
        @csrf
        <div class="fp-upload-area">
            <label class="fp-file-label">
                <input type="file" name="dataset" id="dataset-input" accept=".csv,.txt" required>
                📁 <span id="file-name-display">Pilih file CSV…</span>
            </label>
            <button type="submit" class="fp-btn fp-btn-primary">Import ke Database</button>
            <a href="{{ route('predictions.generate') }}" id="generate-prediction-btn" class="fp-btn fp-btn-secondary">
                Generate Prediksi
            </a>
            <span class="fp-upload-hint">* Upload CSV akan langsung masuk ke database dan digunakan sebagai dataset training.</span>
        </div>
    </form>

    <div class="fp-stats-row">
        <div class="fp-stat-card c-rose">
            <div class="fp-stat-label">Total Data Database</div>
            <div class="fp-stat-val rose">{{ number_format($totalData ?? 0) }}</div>
        </div>
        <div class="fp-stat-card c-blue">
            <div class="fp-stat-label">Rentang Dataset</div>
            <div class="fp-stat-val text-sm">{{ $periodeDataset ?? '-' }}</div>
        </div>
        <div class="fp-stat-card c-green">
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
                    🔍 <input type="text" name="search" placeholder="Cari tanggal / produk…" value="{{ $search ?? '' }}">
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
                        <td class="row-num">{{ ($rows->currentPage() - 1) * $rows->perPage() + $i + 1 }}</td>
                        <td class="num-cell" style="font-size:.8rem">{{ $row->id }}</td>
                        <td>
                            <div style="font-weight:600;color:var(--dark)">{{ $row->nama_bunga ?? 'Produk #' . $row->product_id }}</div>
                            <div style="font-size:.72rem;color:#CCA8BA">Product ID: {{ $row->product_id }}</div>
                        </td>
                        <td><span class="badge-date">{{ $row->tanggal }}</span></td>
                        <td class="right num-cell">{{ number_format($row->jumlah) }}</td>
                        <td class="right price-cell">Rp {{ number_format($row->harga * 1000, 0, ',', '.') }}</td>
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
                                    onclick="openEdit({{ $row->id }},'{{ $row->product_id }}','{{ $row->tanggal }}','{{ $row->jumlah }}','{{ $row->harga }}','{{ $row->promo }}')">✏️</button>
                                <button type="button" class="fp-btn fp-btn-danger fp-btn-sm" title="Hapus"
                                    onclick="openDelete({{ $row->id }}, '{{ $row->tanggal }}')">🗑️</button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8"><div class="fp-empty"><p>Belum ada data penjualan di database.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="fp-pagination" style="display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap">
            <div style="font-size:.82rem;color:#7A4060">
                Menampilkan <strong>{{ $rows->firstItem() }}</strong> sampai <strong>{{ $rows->lastItem() }}</strong>
                dari <strong>{{ number_format($rows->total()) }}</strong> data
                <br><span style="font-size:.75rem;color:#CCA8BA">Halaman {{ $rows->currentPage() }} dari {{ $rows->lastPage() }}</span>
            </div>
            <div style="display:flex;gap:.45rem;flex-wrap:wrap;align-items:center">
                @if($rows->currentPage() > 1)
                    <a href="{{ $rows->url(1) }}" class="fp-btn fp-btn-outline fp-btn-sm">« Pertama</a>
                @else
                    <span class="fp-btn fp-btn-outline fp-btn-sm" style="opacity:.4;cursor:not-allowed">« Pertama</span>
                @endif
                @if($rows->onFirstPage())
                    <span class="fp-btn fp-btn-secondary fp-btn-sm" style="opacity:.4;cursor:not-allowed">← Sebelumnya</span>
                @else
                    <a href="{{ $rows->previousPageUrl() }}" class="fp-btn fp-btn-secondary fp-btn-sm">← Sebelumnya</a>
                @endif
                @if($rows->hasMorePages())
                    <a href="{{ $rows->nextPageUrl() }}" class="fp-btn fp-btn-primary fp-btn-sm">Berikutnya →</a>
                @else
                    <span class="fp-btn fp-btn-primary fp-btn-sm" style="opacity:.4;cursor:not-allowed">Berikutnya →</span>
                @endif
                @if($rows->currentPage() < $rows->lastPage())
                    <a href="{{ $rows->url($rows->lastPage()) }}" class="fp-btn fp-btn-outline fp-btn-sm">Terakhir »</a>
                @else
                    <span class="fp-btn fp-btn-outline fp-btn-sm" style="opacity:.4;cursor:not-allowed">Terakhir »</span>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- MODAL EDIT --}}
<div class="fp-modal-overlay" id="modal-edit">
    <div class="fp-modal">
        <div class="fp-modal-header">
            <span class="fp-modal-title">✏️ Edit Data Penjualan</span>
            <button class="fp-modal-close" onclick="closeModal('modal-edit')">✕</button>
        </div>
        <form id="form-edit" action="" method="POST">
            @csrf @method('PUT')
            <div class="fp-form-group"><label>Product ID</label><input type="number" id="edit-product-id" name="product_id" min="1" required></div>
            <div class="fp-form-group"><label>Tanggal</label><input type="date" id="edit-tanggal" name="tanggal" required></div>
            <div class="fp-form-group"><label>Jumlah</label><input type="number" id="edit-jumlah" name="jumlah" min="0" required></div>
            <div class="fp-form-group"><label>Harga</label><input type="number" id="edit-harga" name="harga" min="0" required></div>
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

{{-- MODAL DELETE --}}
<div class="fp-modal-overlay" id="modal-delete">
    <div class="fp-modal" style="max-width:400px">
        <div class="fp-modal-icon">🗑️</div>
        <div class="fp-modal-title" style="margin-bottom:.5rem">Hapus Data?</div>
        <div class="fp-modal-body-text">
            Kamu yakin ingin menghapus data tanggal <strong id="delete-period-label"></strong>?
            Tindakan ini <strong>tidak bisa dibatalkan</strong>.
        </div>
        <form id="form-delete" action="" method="POST">
            @csrf @method('DELETE')
            <div class="fp-modal-footer">
                <button type="button" class="fp-btn fp-btn-outline" onclick="closeModal('modal-delete')">Batal</button>
                <button type="submit" class="fp-btn" style="background:#dc2626;color:#fff">Ya, Hapus</button>
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
    if (!['csv','txt'].includes(file.name.split('.').pop().toLowerCase())) { e.preventDefault(); alert('File harus berformat CSV atau TXT'); return; }
    if (file.size > 5 * 1024 * 1024) { e.preventDefault(); alert('Ukuran file maksimal 5MB'); return; }
    if (!confirm('Upload CSV ini akan langsung menambahkan data ke database penjualans.\n\nYakin ingin melanjutkan?')) e.preventDefault();
});
document.getElementById('generate-prediction-btn').addEventListener('click', function(e) {
    if (!confirm('Generate prediksi akan menjalankan model Machine Learning berdasarkan data terbaru.\n\nLanjutkan?')) e.preventDefault();
});
function openModal(id) { document.getElementById(id).classList.add('open'); document.body.style.overflow='hidden'; }
function closeModal(id) { document.getElementById(id).classList.remove('open'); document.body.style.overflow=''; }
document.querySelectorAll('.fp-modal-overlay').forEach(el => { el.addEventListener('click', function(e) { if (e.target===this) closeModal(this.id); }); });
document.addEventListener('keydown', e => { if (e.key==='Escape') ['modal-edit','modal-delete'].forEach(closeModal); });
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