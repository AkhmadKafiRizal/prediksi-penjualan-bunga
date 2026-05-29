<x-app-layout>
<style>
:root{--pk1:#E8185A;--pk2:#F04E8A;--pk3:#F87FB5;--pk4:#FDB8D4;--pk5:#FDE8F2;--pk6:#FFF2F8;--dark:#1A0A12}
*{box-sizing:border-box}

.fp-page-sales{height:100%;min-height:0;padding-top:20px;padding-bottom:16px;display:flex;flex-direction:column}
.fp-page-sales .sales-page{height:100%;min-height:0;display:flex;flex-direction:column}
.fp-page-sales .fp-title{margin-bottom:14px}
.fp-page-sales .fp-stats-row{margin-bottom:12px}
.fp-page-sales .fp-alert{margin-bottom:12px}
.fp-page-sales .fp-card{flex:1;min-height:0;display:flex;flex-direction:column}
.fp-page-sales .fp-table-wrap{flex:1;min-height:0;max-height:none;overflow:auto}

.fp-eyebrow{font-size:10px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--pk1);margin-bottom:3px}
.fp-title{font-size:22px;font-weight:800;color:var(--dark);margin-bottom:18px}

.fp-btn{display:inline-flex;align-items:center;gap:.4rem;padding:.5rem 1.1rem;border:none;border-radius:10px;font-family:inherit;font-size:.84rem;font-weight:600;cursor:pointer;text-decoration:none;transition:all .2s}
.fp-btn-primary{background:linear-gradient(135deg,var(--pk1),var(--pk2));color:#fff;box-shadow:0 4px 14px rgba(232,24,90,.3)}
.fp-btn-primary:hover{box-shadow:0 6px 20px rgba(232,24,90,.4);transform:translateY(-1px)}
.fp-btn-outline{background:#fff;color:#7A2A4A;border:1px solid #FCE4EF}
.fp-btn-outline:hover{border-color:var(--pk3);background:var(--pk6)}
.fp-btn-secondary{background:var(--pk5);color:var(--pk1);border:1px solid #FBCEDE}
.fp-btn-secondary:hover{background:var(--pk4);color:#7A1A3A}
.fp-btn-success{background:linear-gradient(135deg,#16a34a,#22c55e);color:#fff;box-shadow:0 4px 14px rgba(22,163,74,.25)}
.fp-btn-success:hover{box-shadow:0 6px 20px rgba(22,163,74,.35);transform:translateY(-1px)}
.fp-btn-success.is-loading{opacity:.78;pointer-events:none;transform:none;box-shadow:0 4px 14px rgba(22,163,74,.18)}
.fp-btn-sm{padding:.3rem .7rem;font-size:.78rem}

.fp-alert{display:flex;align-items:center;gap:.6rem;padding:.75rem 1.1rem;border-radius:12px;font-size:.84rem;font-weight:500;margin-bottom:1.1rem}
.fp-alert-success{background:#ecfdf5;border:1px solid #6ee7b7;color:#065f46}
.fp-alert-error{background:#fef2f2;border:1px solid #fca5a5;color:#991b1b}

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
.fp-toolbar-actions{display:flex;align-items:center;gap:.45rem;flex-wrap:wrap}
.fp-toolbar-title-group{display:flex;flex-direction:column;gap:.15rem;min-width:230px}
.fp-toolbar-title{font-size:.9rem;font-weight:700;color:var(--dark)}
.fp-toolbar-meta{font-size:.75rem;color:#9B6A80;font-weight:500;line-height:1.35}
.fp-badge-count{background:var(--pk5);color:var(--pk1);border-radius:20px;padding:.15rem .65rem;font-size:.72rem;font-weight:700;border:1px solid #FBCEDE}

.fp-export-scope-panel{display:flex;align-items:flex-start;gap:.75rem;padding:.9rem 1.25rem;border-bottom:1px solid #FCE4EF;background:#FFF8FC;color:#7A4060}
.fp-export-scope-panel.is-active{background:#ECFDF5;border-bottom-color:#A7F3D0;color:#065F46}
.fp-export-scope-icon{width:28px;height:28px;border-radius:9px;display:inline-flex;align-items:center;justify-content:center;background:#fff;border:1px solid currentColor;font-size:.78rem;font-weight:900;line-height:1;flex-shrink:0}
.fp-export-scope-title{font-size:.8rem;font-weight:800;color:inherit;margin-bottom:2px}
.fp-export-scope-text{font-size:.82rem;line-height:1.45;color:inherit}
.fp-export-scope-text strong{font-weight:800}
.fp-filter-bar{display:flex;align-items:center;gap:.55rem;padding:.85rem 1.25rem;border-bottom:1px solid #FCE4EF;flex-wrap:wrap;background:var(--pk6)}
.fp-filter-label{font-size:.72rem;font-weight:700;color:#7A2A4A;text-transform:uppercase;letter-spacing:.08em;white-space:nowrap}
.fp-filter-select{padding:.42rem .75rem;border:1px solid #FCE4EF;border-radius:9px;font-family:inherit;font-size:.82rem;color:var(--dark);background:#fff;outline:none;cursor:pointer;transition:border .15s}
.fp-filter-select:focus{border-color:var(--pk2);box-shadow:0 0 0 3px rgba(232,24,90,.08)}
.fp-filter-sep{width:1px;height:18px;background:#FCE4EF;flex-shrink:0}
.fp-search-box{display:flex;align-items:center;gap:.5rem;background:#fff;border:1px solid #FCE4EF;border-radius:10px;padding:.42rem .85rem}
.fp-search-box input{border:none;background:transparent;font-family:inherit;font-size:.84rem;color:var(--dark);outline:none;width:210px}
.fp-search-box input::placeholder{color:#CCA8BA}

.fp-table-note{display:flex;align-items:flex-start;gap:.55rem;padding:.65rem 1.25rem;border-bottom:1px solid #FCE4EF;background:#fff;color:#7A4060;font-size:.78rem;line-height:1.4}
.fp-table-note-icon{width:22px;height:22px;border-radius:7px;background:var(--pk5);color:var(--pk1);display:inline-flex;align-items:center;justify-content:center;font-weight:900;flex-shrink:0}
.fp-table-note strong{font-weight:800;color:#5B213D}

.fp-sales-toast{position:fixed;right:24px;bottom:24px;z-index:9999;display:flex;align-items:flex-start;gap:.7rem;max-width:360px;padding:.85rem 1rem;border-radius:14px;background:#fff;border:1px solid #A7F3D0;box-shadow:0 16px 40px rgba(6,95,70,.16);color:#065F46;opacity:0;pointer-events:none;transform:translateY(14px);transition:opacity .18s ease,transform .18s ease}
.fp-sales-toast.is-visible{opacity:1;transform:translateY(0)}
.fp-sales-toast.is-error{border-color:#FCA5A5;box-shadow:0 16px 40px rgba(153,27,27,.14);color:#991B1B}
.fp-sales-toast-icon{width:30px;height:30px;border-radius:10px;background:#ECFDF5;color:#16A34A;display:inline-flex;align-items:center;justify-content:center;font-weight:900;flex-shrink:0}
.fp-sales-toast.is-error .fp-sales-toast-icon{background:#FEF2F2;color:#DC2626}
.fp-sales-toast-title{font-size:.86rem;font-weight:800;color:#064E3B;margin-bottom:2px}
.fp-sales-toast-text{font-size:.78rem;line-height:1.4;color:#047857}
.fp-sales-toast.is-error .fp-sales-toast-title{color:#991B1B}
.fp-sales-toast.is-error .fp-sales-toast-text{color:#B91C1C}

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
.fp-empty{text-align:center;padding:3rem 2rem;color:#CCA8BA}
.fp-empty p{font-size:.875rem;margin-top:.6rem}
.fp-pagination{padding:.9rem 1.25rem;border-top:1px solid #FCE4EF}
</style>

<div class="sales-page">
    <div class="fp-content-header">
        <div>
            <div class="fp-content-eyebrow">FloraPredict</div>
            <div class="fp-content-title">Data Penjualan Bunga</div>
            <div class="fp-content-subtitle">Dataset penjualan historis dan transaksi mobile</div>
        </div>
    </div>

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
    @if($databaseError ?? false)
    <div class="fp-alert fp-alert-error">⚠ {{ $databaseError }}</div>
    @endif

    <div class="fp-stats-row">
        <div class="fp-stat-card c-rose">
            <div class="fp-stat-label">Total Data Penjualan</div>
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
        ✔ Dataset siap digunakan — data tersedia di database dan dapat dipakai untuk analisis serta pelatihan model Machine Learning.
    </div>
    @else
    <div class="fp-alert fp-alert-error">
        ⚠ Dataset belum siap untuk training — data belum tersedia atau belum valid.
    </div>
    @endif

    <div class="fp-card">
        @php
            $bulanLabels = [
                1 => 'Januari',
                2 => 'Februari',
                3 => 'Maret',
                4 => 'April',
                5 => 'Mei',
                6 => 'Juni',
                7 => 'Juli',
                8 => 'Agustus',
                9 => 'September',
                10 => 'Oktober',
                11 => 'November',
                12 => 'Desember',
            ];
            $activeExportFilters = [];

            if ($filterTahun ?? false) {
                $activeExportFilters[] = 'Tahun ' . $filterTahun;
            }

            if ($filterBulan ?? false) {
                $activeExportFilters[] = 'Bulan ' . ($bulanLabels[(int) $filterBulan] ?? $filterBulan);
            }

            if ($filterTanggal ?? false) {
                $tanggalLabel = 'Tanggal ' . $filterTanggal;

                if (($filterTahun ?? false) && ! ($filterBulan ?? false)) {
                    $tanggalLabel = 'tanggal ' . $filterTanggal . ' di semua bulan';
                } elseif (! ($filterTahun ?? false) && ! ($filterBulan ?? false)) {
                    $tanggalLabel = 'tanggal ' . $filterTanggal . ' di semua bulan dan semua tahun';
                } elseif (! ($filterTahun ?? false) && ($filterBulan ?? false)) {
                    $tanggalLabel = 'tanggal ' . $filterTanggal . ' di semua tahun';
                }

                $activeExportFilters[] = $tanggalLabel;
            }

            if ($search ?? false) {
                $activeExportFilters[] = 'Pencarian "' . $search . '"';
            }

            $exportScopeText = empty($activeExportFilters)
                ? 'Export akan mengambil semua data penjualan karena belum ada filter aktif.'
                : 'Export akan mengambil data sesuai filter aktif: ' . implode(' - ', $activeExportFilters) . '. Klik Reset Filter jika ingin export semua data.';
        @endphp

        <div class="fp-toolbar">
            <div class="fp-toolbar-left">
                <div class="fp-toolbar-title-group">
                    <span class="fp-toolbar-title">Dataset Penjualan dari Database</span>
                    <span class="fp-toolbar-meta">Data diurutkan dari transaksi terbaru ke terlama.</span>
                </div>
                <span class="fp-badge-count">{{ number_format($totalData ?? 0) }} baris</span>
                <span class="fp-badge-count">25 data per halaman</span>
            </div>
            <div class="fp-toolbar-actions">
                <a href="{{ route('sales.export.excel', request()->only(['search','tahun','bulan','tanggal'])) }}"
                   class="fp-btn fp-btn-success fp-btn-sm fp-export-sales-btn"
                   title="{{ $exportScopeText }}"
                   data-loading-label="Menyiapkan file...">
                    ⬇ Export Data Penjualan (.xlsx)
                </a>
            </div>
        </div>

        <div class="fp-export-scope-panel {{ empty($activeExportFilters) ? '' : 'is-active' }}">
            <span class="fp-export-scope-icon">i</span>
            <div>
                <div class="fp-export-scope-title">
                    {{ empty($activeExportFilters) ? 'Export Semua Data' : 'Export Mengikuti Filter Aktif' }}
                </div>
                <div class="fp-export-scope-text">{{ $exportScopeText }}</div>
            </div>
        </div>

        <form method="GET" action="{{ route('sales') }}" id="filter-form">
            <div class="fp-filter-bar">
                <span class="fp-filter-label">🗓 Filter:</span>

                <select name="tahun" class="fp-filter-select" onchange="document.getElementById('filter-form').submit()">
                    <option value="">Semua Tahun</option>
                    @foreach($availableYears ?? [] as $year)
                    <option value="{{ $year }}" {{ ($filterTahun ?? '') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>

                <select name="bulan" class="fp-filter-select" onchange="document.getElementById('filter-form').submit()">
                    <option value="">Semua Bulan</option>
                    @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $idx => $bln)
                    <option value="{{ $idx+1 }}" {{ ($filterBulan ?? '') == ($idx+1) ? 'selected' : '' }}>{{ $bln }}</option>
                    @endforeach
                </select>

                <select name="tanggal" class="fp-filter-select" onchange="document.getElementById('filter-form').submit()">
                    <option value="">Semua Tanggal</option>
                    @for($d = 1; $d <= 31; $d++)
                    <option value="{{ $d }}" {{ ($filterTanggal ?? '') == $d ? 'selected' : '' }}>{{ $d }}</option>
                    @endfor
                </select>

                <div class="fp-filter-sep"></div>

                <div class="fp-search-box">
                    🔍 <input type="text" name="search" placeholder="Cari produk, tanggal, kasir, atau ID..."
                        value="{{ $search ?? '' }}">
                </div>

                @if(($search ?? false) || ($filterTahun ?? false) || ($filterBulan ?? false) || ($filterTanggal ?? false))
                <a href="{{ route('sales') }}" class="fp-btn fp-btn-outline fp-btn-sm">✕ Reset Filter</a>
                @endif

            </div>
        </form>

        <div class="fp-table-note">
            <span class="fp-table-note-icon">i</span>
            <span>
                <strong>Catatan:</strong> kolom <strong>Kasir</strong> menampilkan nama kasir untuk transaksi mobile. Label <strong>Data historis</strong> berarti data berasal dari dataset awal, bukan transaksi mobile kasir.
            </span>
        </div>

        <div class="fp-table-wrap">
            <table class="fp-table">
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th>ID</th>
                        <th>Nama Bunga</th>
                        <th>Kasir</th>
                        <th>Tanggal</th>
                        <th class="right">Jumlah Terjual</th>
                        <th class="right">Harga</th>
                        <th style="text-align:center">Promo</th>
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
                        <td>
                            <span style="font-weight:600;color:var(--dark)">{{ $row->kasir_name ?? 'Data historis' }}</span>
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
                    </tr>
                    @empty
                    <tr><td colspan="8"><div class="fp-empty"><p>Belum ada data penjualan di database.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="fp-pagination" style="display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap">
            @php $filterQuery = http_build_query(request()->only(['search','tahun','bulan','tanggal'])); @endphp
            <div style="font-size:.82rem;color:#7A4060">
                Menampilkan <strong>{{ $rows->firstItem() ?? 0 }}</strong> sampai <strong>{{ $rows->lastItem() ?? 0 }}</strong>
                dari <strong>{{ number_format($rows->total()) }}</strong> data
                <br><span style="font-size:.75rem;color:#CCA8BA">Halaman {{ $rows->currentPage() }} dari {{ $rows->lastPage() }}</span>
            </div>
            <div style="display:flex;gap:.45rem;flex-wrap:wrap;align-items:center">
                @if($rows->currentPage() > 1)
                    <a href="{{ $rows->url(1) . ($filterQuery ? '&'.$filterQuery : '') }}" class="fp-btn fp-btn-outline fp-btn-sm">« Pertama</a>
                @else
                    <span class="fp-btn fp-btn-outline fp-btn-sm" style="opacity:.4;cursor:not-allowed">« Pertama</span>
                @endif
                @if($rows->onFirstPage())
                    <span class="fp-btn fp-btn-secondary fp-btn-sm" style="opacity:.4;cursor:not-allowed">← Sebelumnya</span>
                @else
                    <a href="{{ $rows->previousPageUrl() . ($filterQuery ? '&'.$filterQuery : '') }}" class="fp-btn fp-btn-secondary fp-btn-sm">← Sebelumnya</a>
                @endif
                @if($rows->hasMorePages())
                    <a href="{{ $rows->nextPageUrl() . ($filterQuery ? '&'.$filterQuery : '') }}" class="fp-btn fp-btn-primary fp-btn-sm">Berikutnya →</a>
                @else
                    <span class="fp-btn fp-btn-primary fp-btn-sm" style="opacity:.4;cursor:not-allowed">Berikutnya →</span>
                @endif
                @if($rows->currentPage() < $rows->lastPage())
                    <a href="{{ $rows->url($rows->lastPage()) . ($filterQuery ? '&'.$filterQuery : '') }}" class="fp-btn fp-btn-outline fp-btn-sm">Terakhir »</a>
                @else
                    <span class="fp-btn fp-btn-outline fp-btn-sm" style="opacity:.4;cursor:not-allowed">Terakhir »</span>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="fp-sales-toast" id="sales-export-toast" role="status" aria-live="polite">
    <span class="fp-sales-toast-icon">✓</span>
    <div>
        <div class="fp-sales-toast-title">File sedang disiapkan</div>
        <div class="fp-sales-toast-text">Export Excel akan mengikuti filter aktif. Mohon tunggu sampai download dimulai.</div>
    </div>
</div>

<script>
const salesSearchInput = document.querySelector('.fp-search-box input');
if (salesSearchInput) {
    salesSearchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') document.getElementById('filter-form').submit();
    });
}

const salesExportButton = document.querySelector('.fp-export-sales-btn');
const salesExportToast = document.getElementById('sales-export-toast');
let salesExportToastTimer = null;

function showSalesExportToast(type, title, text) {
    if (! salesExportToast) return;

    const toastIcon = salesExportToast.querySelector('.fp-sales-toast-icon');
    const toastTitle = salesExportToast.querySelector('.fp-sales-toast-title');
    const toastText = salesExportToast.querySelector('.fp-sales-toast-text');
    const isError = type === 'error';

    salesExportToast.classList.toggle('is-error', isError);
    if (toastIcon) toastIcon.textContent = isError ? '!' : '✓';
    if (toastTitle) toastTitle.textContent = title;
    if (toastText) toastText.textContent = text;

    salesExportToast.classList.add('is-visible');
    window.clearTimeout(salesExportToastTimer);

    salesExportToastTimer = window.setTimeout(function() {
        salesExportToast.classList.remove('is-visible');
    }, 4200);
}

if (salesExportButton) {
    const originalExportLabel = salesExportButton.textContent.trim();

    function resetSalesExportButton() {
        salesExportButton.classList.remove('is-loading');
        salesExportButton.removeAttribute('aria-disabled');
        salesExportButton.textContent = originalExportLabel;
    }

    function salesExportFilename(response) {
        const disposition = response.headers.get('content-disposition') || '';
        const utf8Match = disposition.match(/filename\*=UTF-8''([^;]+)/i);
        const plainMatch = disposition.match(/filename="?([^"]+)"?/i);

        if (utf8Match) return decodeURIComponent(utf8Match[1]);
        if (plainMatch) return plainMatch[1];

        return 'laporan-data-penjualan.xlsx';
    }

    salesExportButton.addEventListener('click', async function(e) {
        if (! window.fetch || ! window.URL || salesExportButton.classList.contains('is-loading')) {
            return;
        }

        e.preventDefault();
        showSalesExportToast(
            'success',
            'File sedang disiapkan',
            'Export Excel akan mengikuti filter aktif. Mohon tunggu sampai download dimulai.'
        );

        salesExportButton.classList.add('is-loading');
        salesExportButton.setAttribute('aria-disabled', 'true');
        salesExportButton.textContent = salesExportButton.dataset.loadingLabel || 'Menyiapkan file...';

        try {
            const response = await fetch(salesExportButton.href, {
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
            downloadLink.download = salesExportFilename(response);
            document.body.appendChild(downloadLink);
            downloadLink.click();
            downloadLink.remove();

            window.setTimeout(function() {
                window.URL.revokeObjectURL(downloadUrl);
            }, 1000);

            showSalesExportToast(
                'success',
                'File siap diunduh',
                'Download Excel sudah dimulai. Tombol export sudah bisa dipakai lagi.'
            );
        } catch (error) {
            showSalesExportToast(
                'error',
                'Export belum berhasil',
                'File belum bisa disiapkan. Coba ulangi, gunakan filter lebih kecil, atau periksa koneksi MongoDB.'
            );
        } finally {
            resetSalesExportButton();
        }
    });
}
</script>
</x-app-layout>
