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
.fp-btn-success{background:linear-gradient(135deg,#16a34a,#22c55e);color:#fff;box-shadow:0 4px 14px rgba(22,163,74,.25)}
.fp-btn-success:hover{box-shadow:0 6px 20px rgba(22,163,74,.35);transform:translateY(-1px)}
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
.fp-toolbar-title{font-size:.9rem;font-weight:700;color:var(--dark)}
.fp-badge-count{background:var(--pk5);color:var(--pk1);border-radius:20px;padding:.15rem .65rem;font-size:.72rem;font-weight:700;border:1px solid #FBCEDE}

.fp-filter-bar{display:flex;align-items:center;gap:.55rem;padding:.85rem 1.25rem;border-bottom:1px solid #FCE4EF;flex-wrap:wrap;background:var(--pk6)}
.fp-filter-label{font-size:.72rem;font-weight:700;color:#7A2A4A;text-transform:uppercase;letter-spacing:.08em;white-space:nowrap}
.fp-filter-select{padding:.42rem .75rem;border:1px solid #FCE4EF;border-radius:9px;font-family:inherit;font-size:.82rem;color:var(--dark);background:#fff;outline:none;cursor:pointer;transition:border .15s}
.fp-filter-select:focus{border-color:var(--pk2);box-shadow:0 0 0 3px rgba(232,24,90,.08)}
.fp-filter-sep{width:1px;height:18px;background:#FCE4EF;flex-shrink:0}
.fp-search-box{display:flex;align-items:center;gap:.5rem;background:#fff;border:1px solid #FCE4EF;border-radius:10px;padding:.42rem .85rem}
.fp-search-box input{border:none;background:transparent;font-family:inherit;font-size:.84rem;color:var(--dark);outline:none;width:160px}
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
.fp-empty{text-align:center;padding:3rem 2rem;color:#CCA8BA}
.fp-empty p{font-size:.875rem;margin-top:.6rem}
.fp-pagination{padding:.9rem 1.25rem;border-top:1px solid #FCE4EF}
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
    @if($databaseError ?? false)
    <div class="fp-alert fp-alert-error">⚠ {{ $databaseError }}</div>
    @endif

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
            <a href="{{ route('sales.export', request()->only(['search','tahun','bulan','tanggal'])) }}"
               class="fp-btn fp-btn-success fp-btn-sm">
                ⬇ Export CSV
            </a>
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
                    🔍 <input type="text" name="search" placeholder="Cari tanggal / produk…"
                        value="{{ $search ?? '' }}">
                </div>

                @if(($search ?? false) || ($filterTahun ?? false) || ($filterBulan ?? false) || ($filterTanggal ?? false))
                <a href="{{ route('sales') }}" class="fp-btn fp-btn-outline fp-btn-sm">✕ Reset Filter</a>
                @endif
            </div>
        </form>

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
                    </tr>
                    @empty
                    <tr><td colspan="7"><div class="fp-empty"><p>Belum ada data penjualan di database.</p></div></td></tr>
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

<script>
// Submit filter form on Enter in search box
document.querySelector('.fp-search-box input').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') document.getElementById('filter-form').submit();
});
</script>
</x-app-layout>
