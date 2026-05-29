<x-app-layout>
<style>
:root{--pk1:#E8185A;--pk2:#F04E8A;--pk3:#F87FB5;--pk4:#FDB8D4;--pk5:#FDE8F2;--pk6:#FFF2F8;--dark:#1A0A12}
*{box-sizing:border-box}

.fp-page-products{min-height:100%;padding-top:20px;padding-bottom:16px;display:block}
.fp-page-products .products-page{min-height:0;display:block}
.fp-page-products .fp-title{margin-bottom:14px}
.fp-page-products .fp-alert{margin-bottom:12px}
.fp-page-products .fp-card{min-height:0;display:block}
.fp-page-products .fp-toolbar{padding:.75rem 1.15rem}
.fp-page-products .fp-filter-bar{padding:.65rem 1.15rem}
.fp-page-products .fp-stok-info{padding:.55rem 1rem}
.fp-page-products .fp-table-wrap{min-height:0;overflow-x:auto;overflow-y:visible}
.fp-page-products .fp-table th{background:var(--pk6)}
.fp-page-products .fp-table th{padding:.5rem 1rem}
.fp-page-products .fp-table td{padding:.43rem 1rem}
.fp-page-products .fp-prod-icon{width:30px;height:30px;border-radius:8px}
.fp-page-products .fp-prod-icon svg{width:19px;height:19px}
.fp-page-products .fp-actions .fp-btn-sm{padding:.24rem .52rem;font-size:.72rem}
.fp-page-products .fp-pagination{padding:.58rem 1.15rem}

.fp-eyebrow{font-size:10px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--pk1);margin-bottom:3px}
.fp-title{font-size:22px;font-weight:800;color:var(--dark);margin-bottom:20px}

.fp-btn{display:inline-flex;align-items:center;gap:.4rem;padding:.5rem 1.1rem;border:none;border-radius:10px;font-family:inherit;font-size:.84rem;font-weight:600;cursor:pointer;text-decoration:none;transition:all .2s}
.fp-btn-primary{background:linear-gradient(135deg,var(--pk1),var(--pk2));color:#fff;box-shadow:0 4px 14px rgba(232,24,90,.3)}
.fp-btn-primary:hover{box-shadow:0 6px 20px rgba(232,24,90,.4);transform:translateY(-1px)}
.fp-btn-success{background:#10B981;color:#fff;box-shadow:0 4px 14px rgba(16,185,129,.22)}
.fp-btn-success:hover{background:#059669;box-shadow:0 6px 20px rgba(16,185,129,.3);transform:translateY(-1px)}
.fp-btn-outline{background:#fff;color:#7A2A4A;border:1px solid #FCE4EF}
.fp-btn-outline:hover{border-color:var(--pk3);background:var(--pk6)}
.fp-btn-secondary{background:var(--pk5);color:var(--pk1);border:1px solid #FBCEDE}
.fp-btn-secondary:hover{background:var(--pk4);color:#7A1A3A}
.fp-btn-danger{background:#FEE2E2;color:#dc2626;border:none}
.fp-btn-danger:hover{background:#fecaca}
.fp-btn-deactivate{background:#fff;color:#B91C1C;border:1px solid #FECACA;box-shadow:none;padding:.28rem .58rem}
.fp-btn-deactivate:hover{background:#FEF2F2;border-color:#FCA5A5;transform:translateY(-1px)}
.fp-btn-activate{background:#ECFDF5;color:#047857;border:1px solid #A7F3D0;box-shadow:none;padding:.28rem .58rem}
.fp-btn-activate:hover{background:#10B981;border-color:#10B981;color:#fff;transform:translateY(-1px)}
.fp-btn-sm{padding:.3rem .7rem;font-size:.78rem}

.fp-alert{display:flex;align-items:center;gap:.6rem;padding:.75rem 1.1rem;border-radius:12px;font-size:.84rem;font-weight:500;margin-bottom:1.1rem}
.fp-alert-success{background:#ecfdf5;border:1px solid #6ee7b7;color:#065f46}
.fp-alert-error{background:#fef2f2;border:1px solid #fca5a5;color:#991b1b}
.fp-submit-toast{position:fixed;right:24px;top:24px;z-index:1100;display:none;align-items:center;gap:.55rem;padding:.78rem 1rem;border-radius:12px;background:#fff;color:#7A2A4A;border:1px solid #FCE4EF;box-shadow:0 18px 45px rgba(232,24,90,.16);font-size:.82rem;font-weight:700}
.fp-submit-toast.show{display:flex}
.fp-submit-toast-dot{width:9px;height:9px;border-radius:999px;background:var(--pk1);box-shadow:0 0 0 5px rgba(232,24,90,.12)}
.fp-btn.is-loading{opacity:.75;pointer-events:none}
.fp-export-toast{position:fixed;right:24px;bottom:24px;z-index:1100;display:flex;align-items:flex-start;gap:.7rem;max-width:360px;padding:.85rem 1rem;border-radius:14px;background:#fff;border:1px solid #A7F3D0;box-shadow:0 16px 40px rgba(6,95,70,.16);color:#065F46;opacity:0;pointer-events:none;transform:translateY(14px);transition:opacity .18s ease,transform .18s ease}
.fp-export-toast.is-visible{opacity:1;transform:translateY(0)}
.fp-export-toast.is-error{border-color:#FCA5A5;box-shadow:0 16px 40px rgba(153,27,27,.14);color:#991B1B}
.fp-export-toast-icon{width:30px;height:30px;border-radius:10px;background:#ECFDF5;color:#16A34A;display:inline-flex;align-items:center;justify-content:center;font-weight:900;flex-shrink:0}
.fp-export-toast.is-error .fp-export-toast-icon{background:#FEF2F2;color:#DC2626}
.fp-export-toast-title{font-size:.86rem;font-weight:800;color:#064E3B;margin-bottom:2px}
.fp-export-toast-text{font-size:.78rem;line-height:1.4;color:#047857}
.fp-export-toast.is-error .fp-export-toast-title{color:#991B1B}
.fp-export-toast.is-error .fp-export-toast-text{color:#B91C1C}

.fp-card{background:#fff;border-radius:16px;border:1px solid #FCE4EF;overflow:hidden}
.fp-toolbar{display:flex;align-items:center;justify-content:space-between;padding:.9rem 1.25rem;border-bottom:1px solid #FCE4EF;flex-wrap:wrap;gap:.7rem}
.fp-toolbar-left{display:flex;align-items:center;gap:.65rem;flex-wrap:wrap}
.fp-toolbar-actions{display:flex;align-items:center;justify-content:flex-end;gap:.55rem;flex-wrap:wrap}
.fp-toolbar-title-group{display:flex;flex-direction:column;gap:.15rem;min-width:230px}
.fp-toolbar-title{font-size:.9rem;font-weight:700;color:var(--dark)}
.fp-toolbar-meta{font-size:.75rem;color:#9B6A80;font-weight:500;line-height:1.35}
.fp-badge-count{background:var(--pk5);color:var(--pk1);border-radius:20px;padding:.15rem .65rem;font-size:.72rem;font-weight:700;border:1px solid #FBCEDE}

.fp-filter-bar{display:flex;align-items:center;gap:.55rem;padding:.85rem 1.25rem;border-bottom:1px solid #FCE4EF;flex-wrap:wrap;background:var(--pk6)}
.fp-filter-label{font-size:.72rem;font-weight:700;color:#7A2A4A;text-transform:uppercase;letter-spacing:.08em;white-space:nowrap}
.fp-filter-select{padding:.42rem .75rem;border:1px solid #FCE4EF;border-radius:9px;font-family:inherit;font-size:.82rem;color:var(--dark);background:#fff;outline:none;cursor:pointer;transition:border .15s}
.fp-filter-select:focus{border-color:var(--pk2);box-shadow:0 0 0 3px rgba(232,24,90,.08)}
.fp-filter-sep{width:1px;height:18px;background:#FCE4EF;flex-shrink:0}
.fp-search-box{display:flex;align-items:center;gap:.5rem;background:#fff;border:1px solid #FCE4EF;border-radius:10px;padding:.42rem .85rem}
.fp-search-box input{border:none;background:transparent;font-family:inherit;font-size:.84rem;color:var(--dark);outline:none;width:220px}
.fp-search-box input::placeholder{color:#CCA8BA}

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
.stok-empty{background:#FEF2F2;border:1px solid #FCA5A5;color:#B91C1C}
.stok-low{background:#FEF2F2;border:1px solid #FECACA;color:#991B1B}
.stok-ok{background:#ECFDF5;border:1px solid #6EE7B7;color:#065F46}

.num-cell{font-family:'DM Mono',monospace;font-size:.84rem;color:var(--dark)}
.fp-updated-cell{display:flex;flex-direction:column;gap:2px;min-width:112px}
.fp-updated-date{font-size:.78rem;font-weight:700;color:#7A4060;white-space:nowrap}
.fp-updated-note{font-size:.68rem;color:#CCA8BA;white-space:nowrap}

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
.fp-modal-warning{margin-top:.8rem;padding:.75rem .85rem;border-radius:12px;background:#FFF7ED;border:1px solid #FED7AA;color:#9A3412;font-size:.8rem;line-height:1.55}
.fp-modal-warning strong{font-weight:800}
.fp-form-note{display:flex;align-items:flex-start;gap:.55rem;padding:.7rem .85rem;border-radius:12px;background:#ECFDF5;border:1px solid #A7F3D0;color:#065F46;font-size:.78rem;line-height:1.45}
.fp-form-note strong{font-weight:800}

.fp-stok-info{display:flex;align-items:center;gap:8px;padding:10px 14px;background:linear-gradient(135deg,var(--pk6),#FFF5FA);border-bottom:1px solid #FCE4EF;font-size:11.5px;color:#7A4060}
.fp-stok-info strong{color:var(--pk1)}
.fp-action-muted{display:inline-flex;align-items:center;justify-content:center;border-radius:9px;padding:.3rem .65rem;background:#f3f4f6;color:#6b7280;font-size:.76rem;font-weight:700}
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
    @if($errors->any())
        <div class="fp-alert fp-alert-error">⚠ Periksa kembali input produk. Harga jual minimal Rp 5.000, stok minimum tidak boleh kurang dari 1, dan semua kolom wajib harus valid.</div>
    @endif

    <div class="fp-card">
        <div class="fp-toolbar">
            <div class="fp-toolbar-left">
                <div class="fp-toolbar-title-group">
                    <span class="fp-toolbar-title">Daftar Produk Bunga</span>
                    <span class="fp-toolbar-meta">Perubahan produk memengaruhi stok aplikasi kasir dan data yang dibaca Asisten AI.</span>
                </div>
                <span class="fp-badge-count">{{ $totalProducts }} produk</span>
                <span class="fp-badge-count">{{ $totalLowStock ?? 0 }} perlu restock</span>
                <span class="fp-badge-count">{{ $totalInactive ?? 0 }} nonaktif</span>
                <span class="fp-badge-count">10 data per halaman</span>
            </div>
            <div class="fp-toolbar-actions">
                <a href="{{ route('products.export') }}"
                   class="fp-btn fp-btn-success fp-export-products-btn"
                   data-loading-label="Menyiapkan file...">
                    Export Produk (.xlsx)
                </a>
                <button type="button" class="fp-btn fp-btn-primary" onclick="openModal('modal-tambah')">
                    + Tambah Produk
                </button>
            </div>
        </div>

        <form method="GET" action="{{ route('products.index') }}" id="product-filter-form">
            <div class="fp-filter-bar">
                <span class="fp-filter-label">Filter:</span>

                <div class="fp-search-box">
                    🔍 <input type="text" name="search" placeholder="Cari nama bunga, satuan, atau ID..."
                        value="{{ $search ?? '' }}">
                </div>

                <div class="fp-filter-sep"></div>

                <select name="status" class="fp-filter-select" onchange="document.getElementById('product-filter-form').submit()">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ ($filterStatus ?? '') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ ($filterStatus ?? '') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>

                <select name="stok" class="fp-filter-select" onchange="document.getElementById('product-filter-form').submit()">
                    <option value="">Semua Stok</option>
                    <option value="perlu_restock" {{ ($filterStok ?? '') === 'perlu_restock' ? 'selected' : '' }}>Perlu Restock</option>
                    <option value="habis" {{ ($filterStok ?? '') === 'habis' ? 'selected' : '' }}>Habis</option>
                    <option value="aman" {{ ($filterStok ?? '') === 'aman' ? 'selected' : '' }}>Aman</option>
                </select>

                @if(($search ?? false) || ($filterStatus ?? false) || ($filterStok ?? false))
                    <a href="{{ route('products.index') }}" class="fp-btn fp-btn-outline fp-btn-sm">✕ Reset Filter</a>
                @endif
            </div>
        </form>

        <div class="fp-stok-info">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--pk1)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span>
                <strong>Stok Saat Ini</strong> adalah stok tersedia sekarang. <strong>Habis</strong> = 0, <strong>Stok Rendah</strong> = stok saat ini <= stok minimum, dan <strong>Aman</strong> = stok di atas minimum.
            </span>
        </div>

        @php
            $hasProductFilters = ($search ?? false) || ($filterStatus ?? false) || ($filterStok ?? false);
            $emptyProductMessage = 'Belum ada produk bunga. Tambahkan produk terlebih dahulu.';

            if ($hasProductFilters) {
                $emptyProductMessage = 'Tidak ada produk yang cocok dengan filter saat ini.';

                if (($filterStatus ?? '') === 'nonaktif' && ! ($search ?? false) && ! ($filterStok ?? false)) {
                    $emptyProductMessage = 'Tidak ada produk nonaktif saat ini.';
                } elseif (($filterStatus ?? '') === 'aktif' && ! ($search ?? false) && ! ($filterStok ?? false)) {
                    $emptyProductMessage = 'Tidak ada produk aktif saat ini.';
                } elseif (($filterStok ?? '') === 'aman' && ! ($search ?? false) && ! ($filterStatus ?? false)) {
                    $emptyProductMessage = 'Tidak ada produk dengan stok aman saat ini.';
                } elseif (($filterStok ?? '') === 'habis' && ! ($search ?? false) && ! ($filterStatus ?? false)) {
                    $emptyProductMessage = 'Tidak ada produk yang stoknya habis saat ini.';
                } elseif (($filterStok ?? '') === 'perlu_restock' && ! ($search ?? false) && ! ($filterStatus ?? false)) {
                    $emptyProductMessage = 'Tidak ada produk yang perlu restock saat ini.';
                }
            }
        @endphp

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
                        <th>Terakhir Diperbarui</th>
                        <th style="text-align:center;width:170px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $i => $product)
                        @php
                            $stokSaatIni = $product->stok_saat_ini ?? 0;
                            $stokMin     = $product->stok_minimum ?? 0;
                            $isEmpty     = $stokSaatIni <= 0;
                            $isLow       = $stokSaatIni <= $stokMin;
                            $stokClass   = $isEmpty ? 'stok-empty' : ($isLow ? 'stok-low' : 'stok-ok');
                            $stokLabel   = $isEmpty ? 'Habis' : ($isLow ? 'Stok Rendah' : 'Aman');
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
                                <span class="stok-current {{ $stokClass }}" title="{{ $stokLabel }}">
                                    {{ $isLow ? '⚠ ' : '✓ ' }}{{ number_format($stokSaatIni) }}
                                </span>
                                <span style="font-size:.72rem;color:#9B6A80;margin-left:6px">{{ $stokLabel }}</span>
                            </td>
                            <td>
                                <span class="stok-minimum">{{ number_format($stokMin) }} {{ $product->satuan }}</span>
                            </td>
                            <td>
                                @if((int) ($product->is_active ?? 1) === 1)
                                    <span class="badge-active">Aktif</span>
                                @else
                                    <span class="badge-inactive">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="fp-updated-cell" title="Waktu terakhir data produk ini berubah">
                                    <span class="fp-updated-date">{{ $product->updated_at_label ?? 'Belum tercatat' }}</span>
                                    <span class="fp-updated-note">waktu update produk</span>
                                </div>
                            </td>
                            <td>
                                <div class="fp-actions">
                                    <button type="button" class="fp-btn fp-btn-outline fp-btn-sm" title="Edit"
                                        onclick="openEdit(
                                            {{ $product->id }},
                                            '{{ addslashes($product->nama_bunga) }}',
                                            '{{ addslashes($product->satuan) }}',
                                            '{{ $product->harga_jual }}',
                                            {{ $product->stok_minimum }},
                                            {{ $product->stok_saat_ini ?? 0 }}
                                        )">
                                        ✏️
                                    </button>
                                    @if((int) ($product->is_active ?? 1) === 1)
                                        <button type="button" class="fp-btn fp-btn-deactivate fp-btn-sm" title="Nonaktifkan produk"
                                            onclick="openDelete({{ $product->id }}, '{{ addslashes($product->nama_bunga) }}')">
                                            ⏻ Nonaktifkan
                                        </button>
                                    @else
                                        <button type="button" class="fp-btn fp-btn-activate fp-btn-sm" title="Aktifkan kembali produk"
                                            onclick="openActivate({{ $product->id }}, '{{ addslashes($product->nama_bunga) }}')">
                                            ✓ Aktifkan
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">
                                <div class="fp-empty"><p>{{ $emptyProductMessage }}</p></div>
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
            <button type="button" class="fp-modal-close" onclick="closeModal('modal-tambah')">✕</button>
        </div>
        <form action="{{ route('products.store') }}" method="POST" class="fp-action-form" data-loading-message="Menyimpan produk bunga...">
            @csrf
            <div class="fp-form-group">
                <label>Nama Bunga</label>
                <input type="text" name="nama_bunga" placeholder="contoh: Mawar Merah" required>
            </div>
            <div class="fp-form-group">
                <label>Satuan</label>
                <select name="satuan" required>
                    <option value="tangkai">Tangkai</option>
                </select>
                <div class="fp-form-hint">Dataset saat ini memakai satuan tangkai untuk semua produk.</div>
            </div>
            <div class="fp-form-group">
                <label>Harga Jual (Rp)</label>
                <input type="number" name="harga_jual" placeholder="contoh: 10000" min="5000" required>
                <div class="fp-form-hint">Minimal Rp 5.000 agar produk aman digunakan di kasir mobile.</div>
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
                    <div class="fp-form-hint">Standar project saat ini 10 tangkai, tetapi nilai tidak boleh kurang dari 1.</div>
                </div>
            </div>
            <div class="fp-form-note">
                <span>i</span>
                <span><strong>Produk baru otomatis aktif</strong> dan akan tampil di aplikasi kasir mobile setelah disimpan.</span>
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
            <button type="button" class="fp-modal-close" onclick="closeModal('modal-edit')">✕</button>
        </div>

        <form id="form-edit" method="POST" class="fp-action-form" data-loading-message="Menyimpan perubahan produk...">
            @csrf
            @method('PUT')

            <div class="fp-form-group">
                <label>Nama Bunga</label>
                <input type="text" id="edit-nama" name="nama_bunga" required>
                <div class="fp-form-hint">Perubahan nama akan memengaruhi tampilan laporan, prediksi, Asisten AI, dan aplikasi kasir mobile.</div>
            </div>

            <div class="fp-form-group">
                <label>Satuan</label>
                <select id="edit-satuan" name="satuan" required>
                    <option value="tangkai">Tangkai</option>
                </select>
                <div class="fp-form-hint">Dataset saat ini memakai satuan tangkai untuk semua produk.</div>
            </div>

            <div class="fp-form-group">
                <label>Harga Jual (Rp)</label>
                <input type="number" id="edit-harga" name="harga_jual" min="5000" required>
                <div class="fp-form-hint">Minimal Rp 5.000.</div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                <div class="fp-form-group">
                    <label>Stok Saat Ini</label>
                    <input type="number" id="edit-stok-saat-ini" name="stok_saat_ini" min="0" required>
                    <div class="fp-form-hint">Perubahan stok akan memengaruhi stok yang tampil di aplikasi kasir mobile.</div>
                </div>

                <div class="fp-form-group">
                    <label>Stok Minimum</label>
                    <input type="number" id="edit-stok" name="stok_minimum" min="1" required>
                    <div class="fp-form-hint">Standar project saat ini 10 tangkai dan dipakai untuk menandai status Stok Rendah.</div>
                </div>
            </div>

            <div class="fp-modal-footer">
                <button type="button" class="fp-btn fp-btn-outline" onclick="closeModal('modal-edit')">Batal</button>
                <button type="submit" class="fp-btn fp-btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL NAME CHANGE CONFIRM --}}
<div class="fp-modal-overlay" id="modal-name-change">
    <div class="fp-modal" style="max-width:430px">
        <div class="fp-modal-icon">i</div>

        <div class="fp-modal-title" style="margin-bottom:.5rem">
            Ubah Nama Produk?
        </div>

        <div class="fp-modal-body-text">
            Kamu akan mengubah nama produk dari
            <span class="fp-modal-body-name" id="name-change-old"></span>
            menjadi
            <span class="fp-modal-body-name" id="name-change-new"></span>.

            <div class="fp-modal-warning">
                <strong>Dampak:</strong> nama yang tampil di laporan, halaman prediksi, Asisten AI, dan aplikasi kasir mobile dapat ikut berubah karena data produk memakai product_id yang sama. Pastikan perubahan nama ini memang disengaja.
            </div>
        </div>

        <div class="fp-modal-footer">
            <button type="button" class="fp-btn fp-btn-outline" onclick="closeModal('modal-name-change')">Batal</button>
            <button type="button" class="fp-btn fp-btn-primary" onclick="confirmNameChange()">Ya, Lanjut Simpan</button>
        </div>
    </div>
</div>

{{-- MODAL DELETE --}}
<div class="fp-modal-overlay" id="modal-delete">
    <div class="fp-modal" style="max-width:400px">

        <div class="fp-modal-icon">⏻</div>

        <div class="fp-modal-title" style="margin-bottom:.5rem">
            Nonaktifkan Produk?
        </div>

        <div class="fp-modal-body-text">
            Kamu yakin ingin menonaktifkan produk
            <span class="fp-modal-body-name" id="delete-name-label"></span>?
            <div class="fp-modal-warning">
                <strong>Dampak:</strong> status produk akan berubah menjadi nonaktif di database, produk tidak tampil di aplikasi kasir mobile, dan tidak dipakai untuk transaksi baru. Data produk tetap tersimpan sebagai arsip dan bisa diaktifkan kembali lewat tombol Aktifkan.
            </div>
        </div>

        <form id="form-delete" method="POST" class="fp-action-form" data-loading-message="Menonaktifkan produk...">
            @csrf
            @method('DELETE')

            <div class="fp-modal-footer">
                <button type="button" class="fp-btn fp-btn-outline" onclick="closeModal('modal-delete')">Batal</button>
                <button type="submit" class="fp-btn" style="background:#dc2626;color:#fff">Ya, Nonaktifkan</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL ACTIVATE --}}
<div class="fp-modal-overlay" id="modal-activate">
    <div class="fp-modal" style="max-width:420px">

        <div class="fp-modal-icon">✓</div>

        <div class="fp-modal-title" style="margin-bottom:.5rem">
            Aktifkan Produk?
        </div>

        <div class="fp-modal-body-text">
            Kamu yakin ingin mengaktifkan kembali produk
            <span class="fp-modal-body-name" id="activate-name-label"></span>?
            <div class="fp-form-note" style="margin-top:.8rem">
                <span>i</span>
                <span><strong>Dampak:</strong> status produk akan kembali aktif di database, produk tampil lagi di aplikasi kasir mobile, dan dapat dipakai untuk transaksi baru. Pastikan harga, stok saat ini, dan stok minimum sudah benar sebelum produk digunakan kembali oleh kasir.</span>
            </div>
        </div>

        <form id="form-activate" method="POST" class="fp-action-form" data-loading-message="Mengaktifkan produk...">
            @csrf
            @method('PATCH')

            <div class="fp-modal-footer">
                <button type="button" class="fp-btn fp-btn-outline" onclick="closeModal('modal-activate')">Batal</button>
                <button type="submit" class="fp-btn" style="background:#10B981;color:#fff">Ya, Aktifkan</button>
            </div>
        </form>

    </div>
</div>

{{-- SCRIPT --}}
<div class="fp-submit-toast" id="product-submit-toast">
    <span class="fp-submit-toast-dot"></span>
    <span id="product-submit-toast-text">Memproses...</span>
</div>

<div class="fp-export-toast" id="product-export-toast" role="status" aria-live="polite">
    <span class="fp-export-toast-icon">✓</span>
    <div>
        <div class="fp-export-toast-title">File sedang disiapkan</div>
        <div class="fp-export-toast-text">Export daftar produk sedang dibuat. Mohon tunggu sampai download dimulai.</div>
    </div>
</div>

<script>
const baseUrl = "{{ url('products') }}";
const productExportButton = document.querySelector('.fp-export-products-btn');
const productExportToast = document.getElementById('product-export-toast');
let productExportToastTimer = null;

function showProductExportToast(type, title, text) {
    if (! productExportToast) return;

    const toastIcon = productExportToast.querySelector('.fp-export-toast-icon');
    const toastTitle = productExportToast.querySelector('.fp-export-toast-title');
    const toastText = productExportToast.querySelector('.fp-export-toast-text');
    const isError = type === 'error';

    productExportToast.classList.toggle('is-error', isError);
    if (toastIcon) toastIcon.textContent = isError ? '!' : '✓';
    if (toastTitle) toastTitle.textContent = title;
    if (toastText) toastText.textContent = text;

    productExportToast.classList.add('is-visible');
    window.clearTimeout(productExportToastTimer);

    productExportToastTimer = window.setTimeout(function() {
        productExportToast.classList.remove('is-visible');
    }, 4200);
}

function productExportFilename(response) {
    const disposition = response.headers.get('content-disposition') || '';
    const utf8Match = disposition.match(/filename\*=UTF-8''([^;]+)/i);
    const plainMatch = disposition.match(/filename="?([^"]+)"?/i);

    if (utf8Match) return decodeURIComponent(utf8Match[1]);
    if (plainMatch) return plainMatch[1];

    return 'daftar-produk-bunga.xlsx';
}

if (productExportButton) {
    const originalProductExportLabel = productExportButton.textContent.trim();

    function resetProductExportButton() {
        productExportButton.classList.remove('is-loading');
        productExportButton.removeAttribute('aria-disabled');
        productExportButton.textContent = originalProductExportLabel;
    }

    productExportButton.addEventListener('click', async function(e) {
        if (productExportButton.classList.contains('is-loading')) {
            e.preventDefault();
            return;
        }

        if (! window.fetch || ! window.URL) {
            return;
        }

        e.preventDefault();
        showProductExportToast(
            'success',
            'File sedang disiapkan',
            'Export daftar produk sedang dibuat. Mohon tunggu sampai download dimulai.'
        );

        productExportButton.classList.add('is-loading');
        productExportButton.setAttribute('aria-disabled', 'true');
        productExportButton.textContent = productExportButton.dataset.loadingLabel || 'Menyiapkan file...';

        try {
            const response = await fetch(productExportButton.href, {
                credentials: 'same-origin',
                headers: {'X-Requested-With': 'XMLHttpRequest'},
            });
            const contentType = response.headers.get('content-type') || '';

            if (! response.ok || ! contentType.includes('spreadsheetml.sheet')) {
                throw new Error('Export response is not an Excel file.');
            }

            const blob = await response.blob();
            const downloadUrl = window.URL.createObjectURL(blob);
            const downloadLink = document.createElement('a');

            downloadLink.href = downloadUrl;
            downloadLink.download = productExportFilename(response);
            document.body.appendChild(downloadLink);
            downloadLink.click();
            downloadLink.remove();

            window.setTimeout(function() {
                window.URL.revokeObjectURL(downloadUrl);
            }, 1000);

            showProductExportToast(
                'success',
                'File siap diunduh',
                'Download Excel daftar produk sudah dimulai. Tombol export sudah bisa dipakai lagi.'
            );
        } catch (error) {
            showProductExportToast(
                'error',
                'Export belum berhasil',
                'File produk belum bisa disiapkan. Coba ulangi atau periksa koneksi MongoDB.'
            );
        } finally {
            resetProductExportButton();
        }
    });
}

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
    if (e.key === 'Escape') {
        closeModal('modal-tambah');
        closeModal('modal-edit');
        closeModal('modal-name-change');
        closeModal('modal-delete');
        closeModal('modal-activate');
    }
});

document.querySelectorAll('.fp-action-form').forEach(form => {
    form.addEventListener('submit', function (event) {
        if (this.dataset.submitting === '1') {
            event.preventDefault();
            return;
        }

        if (this.id === 'form-edit') {
            const originalName = this.dataset.originalName || '';
            const currentName = document.getElementById('edit-nama')?.value || '';
            const nameChanged = normalizeProductName(originalName) !== normalizeProductName(currentName);

            if (nameChanged && this.dataset.nameChangeConfirmed !== '1') {
                event.preventDefault();
                openNameChangeConfirm(originalName, currentName);
                return;
            }
        }

        this.dataset.submitting = '1';

        const toast = document.getElementById('product-submit-toast');
        const toastText = document.getElementById('product-submit-toast-text');
        const submitButton = this.querySelector('button[type="submit"]');

        if (toast && toastText) {
            toastText.textContent = this.dataset.loadingMessage || 'Memproses perubahan produk...';
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

function normalizeProductName(name) {
    return String(name || '').trim().replace(/\s+/g, ' ').toLowerCase();
}

function openNameChangeConfirm(oldName, newName) {
    document.getElementById('name-change-old').textContent = oldName || '-';
    document.getElementById('name-change-new').textContent = newName || '-';
    openModal('modal-name-change');
}

function confirmNameChange() {
    const form = document.getElementById('form-edit');
    form.dataset.nameChangeConfirmed = '1';
    closeModal('modal-name-change');
    form.requestSubmit();
}

function openEdit(id, nama, satuan, harga, stokMin, stokSaatIni) {
    document.getElementById('edit-nama').value           = nama;
    document.getElementById('edit-satuan').value         = String(satuan || 'tangkai').toLowerCase();
    document.getElementById('edit-harga').value          = harga;
    document.getElementById('edit-stok').value           = stokMin;
    document.getElementById('edit-stok-saat-ini').value  = stokSaatIni;
    const form = document.getElementById('form-edit');
    form.action = baseUrl + '/' + id;
    form.dataset.originalName = nama;
    form.dataset.nameChangeConfirmed = '0';
    openModal('modal-edit');
}

function openDelete(id, nama) {
    document.getElementById('delete-name-label').textContent = nama;
    document.getElementById('form-delete').action = baseUrl + '/' + id;
    openModal('modal-delete');
}

function openActivate(id, nama) {
    document.getElementById('activate-name-label').textContent = nama;
    document.getElementById('form-activate').action = baseUrl + '/' + id + '/activate';
    openModal('modal-activate');
}
</script>

</x-app-layout>
