<x-app-layout>

<style>
/* ── Header ── */
.fp-eyebrow {
    font-size: 0.7rem; font-weight: 700;
    letter-spacing: 0.14em; text-transform: uppercase;
    color: #e85d75; margin-bottom: 0.25rem;
}
.fp-title { font-size: 1.7rem; font-weight: 700; color: #1a1a2e; }
.fp-header { margin-bottom: 1.75rem; }
.fp-inner { margin: 0 auto; }

/* ── Buttons ── */
.fp-btn {
    display: inline-flex; align-items: center; gap: 0.45rem;
    padding: 0.6rem 1.2rem; border: none; border-radius: 9px;
    font-family: inherit; font-size: 0.84rem; font-weight: 600;
    cursor: pointer; text-decoration: none;
    transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
}
.fp-btn-primary {
    background: #e85d75; color: #fff;
    box-shadow: 0 4px 14px rgba(232,93,117,0.3);
}
.fp-btn-primary:hover {
    background: #c94060; transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(232,93,117,0.4);
}
.fp-btn-outline {
    background: #fff; color: #4a4a6a;
    border: 1px solid #ece8f0;
}
.fp-btn-outline:hover {
    border-color: #e85d75; color: #e85d75;
}
.fp-btn-secondary {
    background: #fde8ec;
    color: #c0253a;
    border: 1px solid #f0b8c3;
}
.fp-btn-secondary:hover {
    background: #fcd5db;
}
.fp-btn-danger {
    background: #fee2e2; color: #dc2626; border: none;
}
.fp-btn-danger:hover { background: #fecaca; }
.fp-btn-sm { padding: 0.35rem 0.75rem; font-size: 0.78rem; }

/* ── Alerts ── */
.fp-alert {
    display: flex; align-items: center; gap: 0.6rem;
    padding: 0.75rem 1.1rem; border-radius: 10px;
    font-size: 0.84rem; font-weight: 500; margin-bottom: 1.25rem;
}
.fp-alert-success {
    background: #ecfdf5; border: 1px solid #6ee7b7; color: #065f46;
}
.fp-alert-error {
    background: #fef2f2; border: 1px solid #fca5a5; color: #991b1b;
}

/* ── Card ── */
.fp-card {
    background: #fff; border-radius: 16px; border: 1px solid #ece8f0;
    box-shadow: 0 4px 24px rgba(232,93,117,0.07); overflow: hidden;
}
.fp-toolbar {
    display: flex; align-items: center; justify-content: space-between;
    padding: 1rem 1.5rem; border-bottom: 1px solid #ece8f0;
    flex-wrap: wrap; gap: 0.75rem;
}
.fp-toolbar-left {
    display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;
}
.fp-toolbar-title {
    font-size: 0.9rem; font-weight: 600; color: #4a4a6a;
}
.fp-badge-count {
    background: #fde8ec; color: #c94060; border-radius: 20px;
    padding: 0.15rem 0.65rem; font-size: 0.72rem; font-weight: 700;
}

/* ── Table ── */
.fp-table-wrap { overflow-x: auto; }
.fp-table { width: 100%; border-collapse: collapse; }
.fp-table thead tr { background: #fdf5f7; }
.fp-table th {
    padding: 0.8rem 1.25rem; text-align: left;
    font-size: 0.68rem; font-weight: 700; letter-spacing: 0.1em;
    text-transform: uppercase; color: #9090aa;
    border-bottom: 1px solid #ece8f0; white-space: nowrap;
}
.fp-table tbody tr {
    border-bottom: 1px solid #f3eff6; transition: background 0.12s;
}
.fp-table tbody tr:last-child { border-bottom: none; }
.fp-table tbody tr:hover { background: #fff5f7; }
.fp-table td {
    padding: 0.8rem 1.25rem; font-size: 0.875rem;
    color: #4a4a6a; vertical-align: middle;
}
.fp-table td.row-num {
    font-size: 0.75rem; color: #c0bbd0;
    font-family: 'DM Mono', monospace; width: 48px;
}
.fp-actions { display: flex; align-items: center; gap: 0.4rem; }
.fp-empty {
    text-align: center; padding: 3.5rem 2rem; color: #c0bbd0;
}
.fp-empty p { font-size: 0.875rem; margin-top: 0.75rem; }

/* Badge status */
.badge-active {
    display: inline-block; background: #ecfdf5; color: #065f46;
    border-radius: 6px; padding: 0.22rem 0.65rem;
    font-size: 0.75rem; font-weight: 600;
}
.badge-inactive {
    display: inline-block; background: #f3f4f6; color: #6b7280;
    border-radius: 6px; padding: 0.22rem 0.65rem;
    font-size: 0.75rem; font-weight: 600;
}
.num-cell {
    font-family: 'DM Mono', monospace;
    font-size: 0.84rem; color: #1a1a2e;
}

/* ── Pagination ── */
.fp-pagination {
    padding: 1rem 1.5rem;
    border-top: 1px solid #f3eff6;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
}

/* ── Modal ── */
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
    to { opacity:1; transform: translateY(0) scale(1); }
}
.fp-modal-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 1.5rem;
}
.fp-modal-title { font-size: 1.05rem; font-weight: 700; color: #1a1a2e; }
.fp-modal-close {
    width: 32px; height: 32px; border-radius: 8px;
    border: 1px solid #ece8f0; background: #faf7f5; color: #9090aa;
    cursor: pointer; font-size: 1rem;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.15s;
}
.fp-modal-close:hover {
    background: #fde8ec; color: #e85d75; border-color: #e85d75;
}
.fp-form-group { margin-bottom: 1.1rem; }
.fp-form-group label {
    display: block; font-size: 0.78rem; font-weight: 600;
    color: #4a4a6a; margin-bottom: 0.4rem;
}
.fp-form-group input,
.fp-form-group select {
    width: 100%; padding: 0.65rem 0.9rem;
    border: 1px solid #ece8f0; border-radius: 9px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 0.875rem; color: #1a1a2e;
    background: #faf7f5; outline: none; box-sizing: border-box;
    transition: border 0.15s, box-shadow 0.15s;
}
.fp-form-group input:focus,
.fp-form-group select:focus {
    border-color: #e85d75;
    box-shadow: 0 0 0 3px rgba(232,93,117,0.12);
    background: #fff;
}
.fp-form-hint {
    font-size: 0.72rem; color: #9090aa; margin-top: 0.3rem;
}
.fp-modal-footer {
    display: flex; justify-content: flex-end; gap: 0.6rem;
    margin-top: 1.5rem; padding-top: 1.25rem;
    border-top: 1px solid #f3eff6;
}
.fp-modal-icon {
    width: 52px; height: 52px; background: #fef2f2;
    border-radius: 14px; display: flex; align-items: center;
    justify-content: center; font-size: 24px; margin-bottom: 1rem;
}
.fp-modal-body-text {
    font-size: 0.875rem; color: #4a4a6a; line-height: 1.6;
}
.fp-modal-body-name { font-weight: 700; color: #1a1a2e; }
</style>

<div class="fp-inner">

    {{-- Header --}}
    <div class="fp-header">
        <div class="fp-eyebrow">FloraPredict</div>
        <h1 class="fp-title">Produk Bunga</h1>
    </div>

    {{-- Alerts --}}
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

    {{-- Table card --}}
    <div class="fp-card">
        <div class="fp-toolbar">
            <div class="fp-toolbar-left">
                <span class="fp-toolbar-title">Daftar Produk Bunga</span>
                <span class="fp-badge-count">{{ $totalProducts }} produk</span>
                <span class="fp-badge-count">10 data per halaman</span>
            </div>

            <button class="fp-btn fp-btn-primary" onclick="openModal('modal-tambah')">
                Tambah Produk
            </button>
        </div>

        <div class="fp-table-wrap">
            <table class="fp-table">
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th>Nama Bunga</th>
                        <th>Satuan</th>
                        <th>Harga Jual</th>
                        <th>Stok Minimum</th>
                        <th>Status</th>
                        <th style="text-align:center;width:120px">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($products as $i => $product)
                        <tr>
                            <td class="row-num">
                                {{ ($products->currentPage() - 1) * $products->perPage() + $i + 1 }}
                            </td>

                            <td style="font-weight:600;color:#1a1a2e">
                                {{ $product->nama_bunga }}
                            </td>

                            <td>{{ $product->satuan }}</td>

                            <td class="num-cell">
                                {{ $product->harga_jual ? 'Rp ' . number_format($product->harga_jual, 0, ',', '.') : '-' }}
                            </td>

                            <td class="num-cell">
                                {{ $product->stok_minimum }} {{ $product->satuan }}
                            </td>

                            <td>
                                @if($product->is_active)
                                    <span class="badge-active">Aktif</span>
                                @else
                                    <span class="badge-inactive">Nonaktif</span>
                                @endif
                            </td>

                            <td>
                                <div class="fp-actions">
                                    <button
                                        class="fp-btn fp-btn-outline fp-btn-sm"
                                        title="Edit"
                                        onclick="openEdit(
                                            {{ $product->id }},
                                            '{{ addslashes($product->nama_bunga) }}',
                                            '{{ $product->satuan }}',
                                            '{{ $product->harga_jual }}',
                                            {{ $product->stok_minimum }},
                                            {{ $product->is_active ? 1 : 0 }}
                                        )">
                                        ✏️
                                    </button>

                                    <button
                                        class="fp-btn fp-btn-danger fp-btn-sm"
                                        title="Nonaktifkan"
                                        onclick="openDelete({{ $product->id }}, '{{ addslashes($product->nama_bunga) }}')">
                                        🗑️
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="fp-empty">
                                    <p>Belum ada produk bunga. Tambahkan produk terlebih dahulu.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="fp-pagination">
            <div style="font-size:.82rem;color:#8a7a8a;">
                Menampilkan
                <strong>{{ $products->firstItem() ?? 0 }}</strong>
                sampai
                <strong>{{ $products->lastItem() ?? 0 }}</strong>
                dari
                <strong>{{ number_format($products->total()) }}</strong>
                produk
                <br>
                <span style="font-size:.75rem;color:#b0a0b0;">
                    Halaman {{ $products->currentPage() }} dari {{ $products->lastPage() }}
                </span>
            </div>

            <div style="display:flex;gap:.5rem;flex-wrap:wrap;align-items:center;">
                @if($products->currentPage() > 1)
                    <a href="{{ $products->url(1) }}" class="fp-btn fp-btn-outline fp-btn-sm">
                        « Pertama
                    </a>
                @else
                    <span class="fp-btn fp-btn-outline fp-btn-sm" style="opacity:.45;cursor:not-allowed;">
                        « Pertama
                    </span>
                @endif

                @if($products->onFirstPage())
                    <span class="fp-btn fp-btn-secondary fp-btn-sm" style="opacity:.45;cursor:not-allowed;">
                        ← Sebelumnya
                    </span>
                @else
                    <a href="{{ $products->previousPageUrl() }}" class="fp-btn fp-btn-secondary fp-btn-sm">
                        ← Sebelumnya
                    </a>
                @endif

                @if($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}" class="fp-btn fp-btn-primary fp-btn-sm">
                        Berikutnya →
                    </a>
                @else
                    <span class="fp-btn fp-btn-primary fp-btn-sm" style="opacity:.45;cursor:not-allowed;">
                        Berikutnya →
                    </span>
                @endif

                @if($products->currentPage() < $products->lastPage())
                    <a href="{{ $products->url($products->lastPage()) }}" class="fp-btn fp-btn-outline fp-btn-sm">
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

{{-- MODAL: TAMBAH --}}
<div class="fp-modal-overlay" id="modal-tambah">
    <div class="fp-modal">
        <div class="fp-modal-header">
            <span class="fp-modal-title">🌸 Tambah Produk Bunga</span>
            <button class="fp-modal-close" onclick="closeModal('modal-tambah')">✕</button>
        </div>

        <form action="{{ route('products.store') }}" method="POST">
            @csrf

            <div class="fp-form-group">
                <label>Nama Bunga</label>
                <input type="text" name="nama_bunga" placeholder="contoh: Mawar Merah" required>
            </div>

            <div class="fp-form-group">
                <label>Satuan</label>
                <select name="satuan" required>
                    <option value="tangkai">Tangkai</option>
                    <option value="pot">Pot</option>
                    <option value="ikat">Ikat</option>
                </select>
            </div>

            <div class="fp-form-group">
                <label>Harga Jual (Rp)</label>
                <input type="number" name="harga_jual" placeholder="contoh: 8000" min="0">
                <div class="fp-form-hint">Opsional — bisa diisi nanti</div>
            </div>

            <div class="fp-form-group">
                <label>Stok Minimum</label>
                <input type="number" name="stok_minimum" placeholder="contoh: 20" min="1" required>
                <div class="fp-form-hint">Notifikasi akan dikirim jika stok di bawah angka ini</div>
            </div>

            <div class="fp-modal-footer">
                <button type="button" class="fp-btn fp-btn-outline" onclick="closeModal('modal-tambah')">Batal</button>
                <button type="submit" class="fp-btn fp-btn-primary">Simpan Produk</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL: EDIT --}}
<div class="fp-modal-overlay" id="modal-edit">
    <div class="fp-modal">
        <div class="fp-modal-header">
            <span class="fp-modal-title">✏️ Edit Produk Bunga</span>
            <button class="fp-modal-close" onclick="closeModal('modal-edit')">✕</button>
        </div>

        <form id="form-edit" action="" method="POST">
            @csrf
            @method('PUT')

            <div class="fp-form-group">
                <label>Nama Bunga</label>
                <input type="text" id="edit-nama" name="nama_bunga" required>
            </div>

            <div class="fp-form-group">
                <label>Satuan</label>
                <select id="edit-satuan" name="satuan" required>
                    <option value="tangkai">Tangkai</option>
                    <option value="pot">Pot</option>
                    <option value="ikat">Ikat</option>
                </select>
            </div>

            <div class="fp-form-group">
                <label>Harga Jual (Rp)</label>
                <input type="number" id="edit-harga" name="harga_jual" min="0">
            </div>

            <div class="fp-form-group">
                <label>Stok Minimum</label>
                <input type="number" id="edit-stok" name="stok_minimum" min="1" required>
                <div class="fp-form-hint">Notifikasi akan dikirim jika stok di bawah angka ini</div>
            </div>

            <div class="fp-form-group">
                <label>Status</label>
                <select id="edit-status" name="is_active">
                    <option value="1">Aktif</option>
                    <option value="0">Nonaktif</option>
                </select>
            </div>

            <div class="fp-modal-footer">
                <button type="button" class="fp-btn fp-btn-outline" onclick="closeModal('modal-edit')">Batal</button>
                <button type="submit" class="fp-btn fp-btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL: NONAKTIFKAN --}}
<div class="fp-modal-overlay" id="modal-delete">
    <div class="fp-modal" style="max-width:400px">
        <div class="fp-modal-icon">🗑️</div>

        <div class="fp-modal-title" style="margin-bottom:0.6rem">
            Nonaktifkan Produk?
        </div>

        <div class="fp-modal-body-text">
            Kamu yakin ingin menonaktifkan produk
            <span class="fp-modal-body-name" id="delete-name-label"></span>?
            Produk tidak akan muncul di aplikasi mobile kasir.
        </div>

        <form id="form-delete" action="" method="POST">
            @csrf
            @method('DELETE')

            <div class="fp-modal-footer">
                <button type="button" class="fp-btn fp-btn-outline" onclick="closeModal('modal-delete')">Batal</button>
                <button type="submit" class="fp-btn" style="background:#dc2626;color:#fff;box-shadow:none;">
                    Ya, Nonaktifkan
                </button>
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
    if (e.key === 'Escape') {
        ['modal-tambah', 'modal-edit', 'modal-delete'].forEach(closeModal);
    }
});

function openEdit(id, nama, satuan, harga, stok, isActive) {
    document.getElementById('edit-nama').value = nama;
    document.getElementById('edit-satuan').value = satuan;
    document.getElementById('edit-harga').value = harga;
    document.getElementById('edit-stok').value = stok;
    document.getElementById('edit-status').value = isActive;
    document.getElementById('form-edit').action = '/products/' + id;
    openModal('modal-edit');
}

function openDelete(id, nama) {
    document.getElementById('delete-name-label').textContent = nama;
    document.getElementById('form-delete').action = '/products/' + id;
    openModal('modal-delete');
}
</script>

</x-app-layout>