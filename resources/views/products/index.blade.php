<x-app-layout>
<style>
:root{--pk1:#E8185A;--pk2:#F04E8A;--pk3:#F87FB5;--pk4:#FDB8D4;--pk5:#FDE8F2;--pk6:#FFF2F8;--dark:#1A0A12}
*{box-sizing:border-box}

.fp-page-products{height:100%;min-height:0;padding-top:20px;padding-bottom:16px;display:flex;flex-direction:column}
.fp-page-products .products-page{height:100%;min-height:0;display:flex;flex-direction:column}
.fp-page-products .fp-title{margin-bottom:14px}
.fp-page-products .fp-alert{margin-bottom:12px}
.fp-page-products .fp-card{flex:1;min-height:0;display:flex;flex-direction:column}
.fp-page-products .fp-stok-info{padding:9px 14px}
.fp-page-products .fp-table-wrap{flex:1;min-height:0;overflow-x:auto;overflow-y:hidden}
.fp-page-products .fp-table th{position:sticky;top:0;background:var(--pk6);z-index:1}
.fp-page-products .fp-table th{padding:.68rem 1.1rem}
.fp-page-products .fp-table td{padding:.66rem 1.1rem}
.fp-page-products .fp-pagination{padding:.75rem 1.25rem}

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
.fp-btn-sm{padding:.3rem .7rem;font-size:.78rem}

.fp-alert{display:flex;align-items:center;gap:.6rem;padding:.75rem 1.1rem;border-radius:12px;font-size:.84rem;font-weight:500;margin-bottom:1.1rem}
.fp-alert-success{background:#ecfdf5;border:1px solid #6ee7b7;color:#065f46}
.fp-alert-error{background:#fef2f2;border:1px solid #fca5a5;color:#991b1b}

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
.fp-table td{padding:.78rem 1.1rem;font-size:.875rem;color:#4A2A3A;vertical-align:middle}
.fp-table td.row-num{font-size:.75rem;color:#CCA8BA;font-family:'DM Mono',monospace;width:48px}
.fp-actions{display:flex;align-items:center;gap:.35rem}
.fp-empty{text-align:center;padding:3rem 2rem;color:#CCA8BA}
.fp-empty p{font-size:.875rem;margin-top:.6rem}

.fp-prod-cell{display:flex;align-items:center;gap:10px}
.fp-prod-icon{width:34px;height:34px;border-radius:9px;background:var(--pk5);display:flex;align-items:center;justify-content:center;flex-shrink:0;border:1px solid #FBCEDE}
.fp-prod-name{font-size:.875rem;font-weight:600;color:var(--dark)}

.badge-active{display:inline-block;background:#ecfdf5;color:#065f46;border-radius:6px;padding:.2rem .65rem;font-size:.74rem;font-weight:600}
.badge-inactive{display:inline-block;background:#f3f4f6;color:#6b7280;border-radius:6px;padding:.2rem .65rem;font-size:.74rem;font-weight:600}
.stok-current{display:inline-flex;align-items:center;gap:4px;background:var(--pk5);border:1px solid #FBCEDE;border-radius:7px;padding:2px 9px;font-weight:700;color:var(--pk1);font-family:'DM Mono',monospace;font-size:.82rem}
.stok-minimum{display:inline-flex;align-items:center;font-family:'DM Mono',monospace;font-size:.82rem;font-weight:600;color:#7A4060}
.stok-low{background:#FEF2F2;border:1px solid #FECACA;color:#991B1B}
.stok-ok{background:#ECFDF5;border:1px solid #6EE7B7;color:#065F46}

.num-cell{font-family:'DM Mono',monospace;font-size:.84rem;color:var(--dark)}

.fp-pagination{padding:.9rem 1.25rem;border-top:1px solid #FCE4EF;display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap}

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
.fp-modal-body-name{font-weight:700;color:var(--dark)}

.fp-stok-info{display:flex;align-items:center;gap:8px;padding:10px 14px;background:linear-gradient(135deg,var(--pk6),#FFF5FA);border-bottom:1px solid #FCE4EF;font-size:11.5px;color:#7A4060}
.fp-stok-info strong{color:var(--pk1)}
</style>

<div class="products-page">
    <div class="fp-content-header">
        <div>
            <div class="fp-content-eyebrow">FloraPredict</div>
            <div class="fp-content-title">Produk Bunga</div>
            <div class="fp-content-subtitle">Kelola data produk, stok, harga, dan status bunga</div>
        </div>
    </div>

    @if(session('success'))
        <div class="fp-alert fp-alert-success">✔ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="fp-alert fp-alert-error">⚠ {{ session('error') }}</div>
    @endif

    <div class="fp-card">
        <div class="fp-toolbar">
            <div class="fp-toolbar-left">
                <span class="fp-toolbar-title">Daftar Produk Bunga</span>
                <span class="fp-badge-count">{{ $totalProducts }} produk</span>
                <span class="fp-badge-count">10 data per halaman</span>
            </div>
            <button class="fp-btn fp-btn-primary" onclick="openModal('modal-tambah')">
                + Tambah Produk
            </button>
        </div>

        <div class="fp-stok-info">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--pk1)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            Kolom <strong>Stok Saat Ini</strong> menampilkan jumlah stok yang tersedia sekarang. Jika stok di bawah minimum, akan ditandai <span style="background:#FEF2F2;color:#991B1B;padding:1px 6px;border-radius:4px;font-size:10.5px;font-weight:600">⚠ Low</span>
        </div>

        <div class="fp-table-wrap">
            <table class="fp-table">
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th>Nama Bunga</th>
                        <th>Satuan</th>
                        <th>Harga Jual</th>
                        <th>Stok Saat Ini</th>
                        <th>Stok Minimum</th>
                        <th>Status</th>
                        <th style="text-align:center;width:120px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $i => $product)
                        @php
                            $stokSaatIni = $product->stok_saat_ini ?? 0;
                            $stokMin     = $product->stok_minimum ?? 0;
                            $isLow       = $stokSaatIni < $stokMin;
                        @endphp
                        <tr>
                            <td class="row-num">{{ ($products->currentPage() - 1) * $products->perPage() + $i + 1 }}</td>
                            <td>
                                <div class="fp-prod-cell">
                                    <div class="fp-prod-icon">
                                        <svg width="22" height="22" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <line x1="20" y1="38" x2="20" y2="22" stroke="#4CAF50" stroke-width="2" stroke-linecap="round"/>
                                            <path d="M20 32 Q14 28 13 24 Q17 25 20 32Z" fill="#66BB6A"/>
                                            <ellipse cx="20" cy="12" rx="4" ry="7" fill="#E8185A" opacity="0.9"/>
                                            <ellipse cx="28" cy="16" rx="4" ry="7" transform="rotate(60 28 16)" fill="#F04E8A" opacity="0.85"/>
                                            <ellipse cx="27" cy="24" rx="4" ry="7" transform="rotate(120 27 24)" fill="#F87FB5" opacity="0.8"/>
                                            <ellipse cx="20" cy="26" rx="4" ry="7" transform="rotate(180 20 26)" fill="#E8185A" opacity="0.85"/>
                                            <ellipse cx="13" cy="24" rx="4" ry="7" transform="rotate(240 13 24)" fill="#F04E8A" opacity="0.8"/>
                                            <ellipse cx="12" cy="16" rx="4" ry="7" transform="rotate(300 12 16)" fill="#F87FB5" opacity="0.85"/>
                                            <circle cx="20" cy="19" r="5" fill="#FDB8D4"/>
                                            <circle cx="20" cy="19" r="3" fill="#FFF2F8"/>
                                            <circle cx="20" cy="19" r="1.5" fill="#E8185A"/>
                                        </svg>
                                    </div>
                                    <span class="fp-prod-name">{{ $product->nama_bunga }}</span>
                                </div>
                            </td>
                            <td style="color:#7A4060">{{ $product->satuan }}</td>
                            <td class="num-cell">
                                {{ $product->harga_jual ? 'Rp ' . number_format($product->harga_jual, 0, ',', '.') : '-' }}
                            </td>
                            <td>
                                <span class="stok-current {{ $isLow ? 'stok-low' : 'stok-ok' }}">
                                    {{ $isLow ? '⚠ ' : '✓ ' }}{{ number_format($stokSaatIni) }}
                                </span>
                            </td>
                            <td>
                                <span class="stok-minimum">{{ number_format($stokMin) }} {{ $product->satuan }}</span>
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
                                    <button class="fp-btn fp-btn-outline fp-btn-sm" title="Edit"
                                        onclick="openEdit(
                                            {{ $product->id }},
                                            '{{ addslashes($product->nama_bunga) }}',
                                            '{{ addslashes($product->satuan) }}',
                                            '{{ $product->harga_jual }}',
                                            {{ $product->stok_minimum }},
                                            {{ $product->stok_saat_ini ?? 0 }},
                                            {{ $product->is_active ? 1 : 0 }}
                                        )">
                                        ✏️
                                    </button>
                                    <button class="fp-btn fp-btn-danger fp-btn-sm" title="Nonaktifkan"
                                        onclick="openDelete({{ $product->id }}, '{{ addslashes($product->nama_bunga) }}')">
                                        🗑️
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="fp-empty"><p>Belum ada produk bunga. Tambahkan produk terlebih dahulu.</p></div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="fp-pagination">
            <div style="font-size:.82rem;color:#7A4060">
                Menampilkan <strong>{{ $products->firstItem() ?? 0 }}</strong> sampai <strong>{{ $products->lastItem() ?? 0 }}</strong>
                dari <strong>{{ number_format($products->total()) }}</strong> produk
                <br><span style="font-size:.75rem;color:#CCA8BA">Halaman {{ $products->currentPage() }} dari {{ $products->lastPage() }}</span>
            </div>
            <div style="display:flex;gap:.45rem;flex-wrap:wrap;align-items:center">
                @if($products->currentPage() > 1)
                    <a href="{{ $products->url(1) }}" class="fp-btn fp-btn-outline fp-btn-sm">« Pertama</a>
                @else
                    <span class="fp-btn fp-btn-outline fp-btn-sm" style="opacity:.4;cursor:not-allowed">« Pertama</span>
                @endif
                @if($products->onFirstPage())
                    <span class="fp-btn fp-btn-secondary fp-btn-sm" style="opacity:.4;cursor:not-allowed">← Sebelumnya</span>
                @else
                    <a href="{{ $products->previousPageUrl() }}" class="fp-btn fp-btn-secondary fp-btn-sm">← Sebelumnya</a>
                @endif
                @if($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}" class="fp-btn fp-btn-primary fp-btn-sm">Berikutnya →</a>
                @else
                    <span class="fp-btn fp-btn-primary fp-btn-sm" style="opacity:.4;cursor:not-allowed">Berikutnya →</span>
                @endif
                @if($products->currentPage() < $products->lastPage())
                    <a href="{{ $products->url($products->lastPage()) }}" class="fp-btn fp-btn-outline fp-btn-sm">Terakhir »</a>
                @else
                    <span class="fp-btn fp-btn-outline fp-btn-sm" style="opacity:.4;cursor:not-allowed">Terakhir »</span>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH --}}
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
                    <option value="Tangkai">Tangkai</option>
                    <option value="Pot">Pot</option>
                    <option value="Ikat">Ikat</option>
                </select>
            </div>
            <div class="fp-form-group">
                <label>Harga Jual (Rp)</label>
                <input type="number" name="harga_jual" placeholder="contoh: 10000" min="0">
                <div class="fp-form-hint">Opsional — bisa diisi nanti</div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                <div class="fp-form-group">
                    <label>Stok Saat Ini</label>
                    <input type="number" name="stok_saat_ini" placeholder="contoh: 100" min="0" required>
                    <div class="fp-form-hint">Jumlah stok yang tersedia</div>
                </div>
                <div class="fp-form-group">
                    <label>Stok Minimum</label>
                    <input type="number" name="stok_minimum" placeholder="contoh: 10" min="1" required>
                    <div class="fp-form-hint">Batas stok minimum</div>
                </div>
            </div>
            <div class="fp-modal-footer">
                <button type="button" class="fp-btn fp-btn-outline" onclick="closeModal('modal-tambah')">Batal</button>
                <button type="submit" class="fp-btn fp-btn-primary">Simpan Produk</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT --}}
<div class="fp-modal-overlay" id="modal-edit">
    <div class="fp-modal">
        <div class="fp-modal-header">
            <span class="fp-modal-title">✏️ Edit Produk Bunga</span>
            <button class="fp-modal-close" onclick="closeModal('modal-edit')">✕</button>
        </div>

        <form id="form-edit" method="POST">
            @csrf
            @method('PUT')

            <div class="fp-form-group">
                <label>Nama Bunga</label>
                <input type="text" id="edit-nama" name="nama_bunga" required>
            </div>

            <div class="fp-form-group">
                <label>Satuan</label>
                <select id="edit-satuan" name="satuan" required>
                    <option value="Tangkai">Tangkai</option>
                    <option value="Pot">Pot</option>
                    <option value="Ikat">Ikat</option>
                </select>
            </div>

            <div class="fp-form-group">
                <label>Harga Jual (Rp)</label>
                <input type="number" id="edit-harga" name="harga_jual" min="0">
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                <div class="fp-form-group">
                    <label>Stok Saat Ini</label>
                    <input type="number" id="edit-stok-saat-ini" name="stok_saat_ini" min="0" required>
                </div>

                <div class="fp-form-group">
                    <label>Stok Minimum</label>
                    <input type="number" id="edit-stok" name="stok_minimum" min="1" required>
                </div>
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

{{-- MODAL DELETE --}}
<div class="fp-modal-overlay" id="modal-delete">
    <div class="fp-modal" style="max-width:400px">

        <div class="fp-modal-icon">🗑️</div>

        <div class="fp-modal-title" style="margin-bottom:.5rem">
            Nonaktifkan Produk?
        </div>

        <div class="fp-modal-body-text">
            Kamu yakin ingin menonaktifkan produk
            <span class="fp-modal-body-name" id="delete-name-label"></span>?
            Produk tidak akan muncul di aplikasi mobile kasir.
        </div>

        <form id="form-delete" method="POST">
            @csrf
            @method('DELETE')

            <div class="fp-modal-footer">
                <button type="button" class="fp-btn fp-btn-outline" onclick="closeModal('modal-delete')">Batal</button>
                <button type="submit" class="fp-btn" style="background:#dc2626;color:#fff">Ya, Nonaktifkan</button>
            </div>
        </form>
    </div>
</div>

{{-- SCRIPT --}}
<script>
const baseUrl = "{{ url('products') }}";

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
        closeModal('modal-tambah');
        closeModal('modal-edit');
        closeModal('modal-delete');
    }
});

function openEdit(id, nama, satuan, harga, stokMin, stokSaatIni, isActive) {
    document.getElementById('edit-nama').value           = nama;
    document.getElementById('edit-satuan').value         = satuan;
    document.getElementById('edit-harga').value          = harga;
    document.getElementById('edit-stok').value           = stokMin;
    document.getElementById('edit-stok-saat-ini').value  = stokSaatIni;
    document.getElementById('edit-status').value         = isActive;

    document.getElementById('form-edit').action = baseUrl + '/' + id;
    openModal('modal-edit');
}

function openDelete(id, nama) {
    document.getElementById('delete-name-label').textContent = nama;
    document.getElementById('form-delete').action = baseUrl + '/' + id;
    openModal('modal-delete');
}
</script>

</x-app-layout>
