<x-app-layout>

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap');
*{box-sizing:border-box}

:root{
    --pk1:#E8185A;--pk2:#F04E8A;--pk3:#F87FB5;--pk4:#FDB8D4;--pk5:#FDE8F2;--pk6:#FFF2F8;
    --dark:#1A0A12;
}

/* ── Page header ── */
.fp-eyebrow{font-size:10px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--pk1);margin-bottom:3px}
.fp-title{font-size:22px;font-weight:800;color:var(--dark);margin-bottom:14px}

/* ── Status bar ── */
.fp-status-ok{background:#fff;border:1px solid #FBCEDE;border-radius:12px;padding:10px 16px;font-size:13px;color:#7A1A3A;display:flex;align-items:center;gap:8px;margin-bottom:16px;position:relative}
.fp-status-ok::before{content:'✦';color:var(--pk1);font-size:14px;flex-shrink:0}
.fp-status-close{position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:#CCA8BA;cursor:pointer;font-size:16px;line-height:1}
.fp-status-warn{background:#FFF8E6;border:1px solid #FFE0A0;border-radius:12px;padding:10px 16px;font-size:13px;color:#7A5A00;display:flex;align-items:center;gap:8px;margin-bottom:16px}

/* ── Stat cards ── */
.fp-cards{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:18px}
.fp-card{background:#fff;border:1px solid #FCE4EF;border-radius:16px;padding:18px 20px;display:flex;align-items:flex-start;gap:14px;position:relative;overflow:hidden;transition:transform .15s,box-shadow .15s}
.fp-card:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(232,24,90,.08)}
.fp-card-icon{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;background:#FCE4EF}
.fp-card-body{flex:1;min-width:0}
.fp-card-lbl{font-size:10px;color:#CCA8BA;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;font-weight:600}
.fp-card-val{font-size:26px;font-weight:800;color:var(--dark);font-family:'DM Mono',monospace;line-height:1.1}
.fp-card-val.rose{color:var(--pk1)}
.fp-card-sub{font-size:11px;color:#CCA8BA;margin-top:3px}


/* ── 2-col grid ── */
.fp-cols2{display:grid;grid-template-columns:minmax(0,1.55fr) minmax(0,1fr);gap:14px;margin-bottom:14px}

/* ── Section card ── */
.fp-section{background:#fff;border:1px solid #FCE4EF;border-radius:16px;overflow:hidden}
.fp-sec-head{padding:14px 18px;border-bottom:1px solid #FCE4EF;display:flex;align-items:center;justify-content:space-between}
.fp-sec-title{font-size:14px;font-weight:700;color:var(--dark)}
.fp-sec-sub{font-size:11px;color:#CCA8BA;margin-top:2px}
.fp-sec-body{padding:16px 18px}
.fp-month-badge{display:inline-flex;align-items:center;gap:5px;background:var(--pk5);color:var(--pk1);font-size:11px;font-weight:700;border-radius:8px;padding:4px 10px;border:1px solid #FBCEDE;cursor:pointer;text-decoration:none}

/* ── Top 10 tabel (pengganti grafik) ── */
.fp-top10-tbl{width:100%;border-collapse:collapse;font-size:12.5px}
.fp-top10-tbl thead th{text-align:left;color:#CCA8BA;font-size:10px;font-weight:600;padding:0 14px 10px;border-bottom:1px solid #FCE4EF;text-transform:uppercase;letter-spacing:.3px}
.fp-top10-tbl tbody td{padding:9px 14px;border-bottom:1px solid #FFF0F6;color:#4A2A3A;white-space:nowrap}
.fp-top10-tbl tbody tr:last-child td{border-bottom:none}
.fp-top10-tbl tbody tr:hover td{background:#FFF8FC}
.fp-top10-rank{width:26px;height:26px;border-radius:8px;display:inline-flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff}
.fp-top10-rank.r1{background:var(--pk1)}
.fp-top10-rank.r2{background:var(--pk2)}
.fp-top10-rank.r3{background:var(--pk3);color:#7A1A3A}
.fp-top10-rank.rx{background:var(--pk5);color:var(--pk1)}
.fp-top10-pill{display:inline-flex;align-items:center;gap:4px;background:var(--pk5);border:1px solid #FBCEDE;border-radius:7px;padding:3px 9px;font-weight:700;color:var(--pk1);font-family:'DM Mono',monospace;font-size:12px}
.fp-top10-bar-wrap{width:120px;height:8px;background:#FFF0F6;border-radius:4px;overflow:hidden;display:inline-block;vertical-align:middle}
.fp-top10-bar-fill{height:100%;border-radius:4px;background:linear-gradient(90deg,var(--pk1),var(--pk3))}

/* ── Statistik model ── */
.fp-stat-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px}
.fp-stat-box{background:var(--pk6);border-radius:12px;padding:13px;border:1px solid #FCE4EF;position:relative;overflow:hidden}
.fp-stat-box-icon{position:absolute;right:10px;top:10px;font-size:18px;opacity:.35}
.fp-stat-lbl{font-size:10px;color:#CCA8BA;text-transform:uppercase;letter-spacing:.3px;margin-bottom:4px;font-weight:600}
.fp-stat-val{font-size:18px;font-weight:700;color:var(--dark);font-family:'DM Mono',monospace}
.fp-stat-val.rose{color:var(--pk1)}
.fp-stat-spark{margin-top:6px;height:28px;width:100%}
.fp-stat-spark path{stroke:var(--pk3);fill:none;stroke-width:1.5}

/* ── Tabel ── */
.fp-tbl{width:100%;border-collapse:collapse;font-size:12.5px;table-layout:fixed}
.fp-tbl th{text-align:left;color:#CCA8BA;font-size:10px;font-weight:600;padding:0 12px 10px;border-bottom:1px solid #FCE4EF;text-transform:uppercase;letter-spacing:.3px;white-space:nowrap}
.fp-tbl td{padding:9px 12px;border-bottom:1px solid #FFF0F6;color:#4A2A3A;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.fp-tbl tr:last-child td{border-bottom:none}
.fp-tbl tbody tr:hover td{background:#FFF8FC}

/* Badge stok */
.fp-badge{display:inline-flex;align-items:center;gap:5px;background:var(--pk5);border:1px solid #FBCEDE;border-radius:8px;padding:3px 10px;font-weight:700;color:var(--pk1);font-family:'DM Mono',monospace;font-size:12px}

/* ── Top5 ── */
.fp-top5-row{display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid #FFF0F6}
.fp-top5-row:last-child{border-bottom:none}
.fp-rank{width:24px;height:24px;border-radius:50%;font-size:11px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;color:#fff}
.fp-rank.r1{background:var(--pk1)}
.fp-rank.r2{background:var(--pk2)}
.fp-rank.r3{background:var(--pk3);color:#7A1A3A}
.fp-rank.rx{background:var(--pk5);color:var(--pk1)}
.fp-rankname{flex:1;font-size:12.5px;color:var(--dark);font-weight:500}
.fp-rankval{font-size:12.5px;font-weight:700;color:var(--pk1);font-family:'DM Mono',monospace}

.fp-empty{text-align:center;padding:28px 16px;color:#CCA8BA;font-size:13px}
.fp-scroll-table{max-height:340px;overflow:auto}

.fp-view-all{display:flex;align-items:center;justify-content:center;gap:6px;padding:10px;font-size:12px;font-weight:600;color:var(--pk1);cursor:pointer;border-top:1px solid #FFF0F6;text-decoration:none}
.fp-view-all:hover{background:var(--pk6)}

@media(max-width:1050px){
    .fp-cards{grid-template-columns:repeat(2,1fr)}
    .fp-cols2{grid-template-columns:1fr}
}
</style>

<div>
    <div class="fp-eyebrow">FloraPredict</div>
    <div class="fp-title">Dashboard</div>

    @if(isset($predictionReady) && $predictionReady)
        <div class="fp-status-ok" id="fp-status-bar">
            Model prediksi aktif — estimasi kebutuhan bunga untuk
            <strong style="color:var(--pk1)">{{ $nextMonthLabel ?? 'Bulan Depan' }}</strong> tersedia
            <button class="fp-status-close" onclick="document.getElementById('fp-status-bar').style.display='none'">×</button>
        </div>
    @else
        <div class="fp-status-warn">
            ⚠ Prediksi belum dijalankan — jalankan model untuk melihat estimasi kebutuhan bulan depan
        </div>
    @endif

    {{-- CARDS --}}
    <div class="fp-cards">
        <div class="fp-card">
            <div class="fp-card-icon">🗄️</div>
            <div class="fp-card-body">
                <div class="fp-card-lbl">Total Data</div>
                <div class="fp-card-val">{{ number_format($totalData) }}</div>
                <div class="fp-card-sub">baris dataset tersedia</div>
            </div>
        </div>

        <div class="fp-card">
            <div class="fp-card-icon">📊</div>
            <div class="fp-card-body">
                <div class="fp-card-lbl">Total Prediksi Penjualan</div>
                @if(isset($predictionReady) && $predictionReady)
                    <div class="fp-card-val rose">{{ number_format($prediction) }}</div>
                    <div class="fp-card-sub">total semua produk</div>
                @else
                    <div class="fp-card-val" style="font-size:15px;color:#CCA8BA;padding-top:4px">Belum ada</div>
                @endif
            </div>
        </div>

        <div class="fp-card">
            <div class="fp-card-icon">🌸</div>
            <div class="fp-card-body">
                <div class="fp-card-lbl">Jumlah Produk Diprediksi</div>
                <div class="fp-card-val">{{ number_format($totalProducts ?? 0) }}</div>
                <div class="fp-card-sub">jenis bunga dalam model</div>
            </div>
        </div>

        <div class="fp-card">
            <div class="fp-card-icon">📅</div>
            <div class="fp-card-body">
                <div class="fp-card-lbl">Periode Prediksi</div>
                <div class="fp-card-val" style="font-size:16px;padding-top:4px">{{ $nextMonthLabel ?? 'Bulan Depan' }}</div>
                <div class="fp-card-sub">estimasi kebutuhan stok</div>
            </div>
        </div>
    </div>

    {{-- BARIS 1: Top10 Tabel + Statistik --}}
    <div class="fp-cols2">
        {{-- Top 10 Tabel (menggantikan bar chart) --}}
        <div class="fp-section">
            <div class="fp-sec-head">
                <div>
                    <div class="fp-sec-title">Top 10 Produk Berdasarkan Prediksi</div>
                    <div class="fp-sec-sub">Estimasi kebutuhan tertinggi per produk bulan depan</div>
                </div>
                @if(isset($nextMonthLabel))
                    <span class="fp-month-badge">{{ $nextMonthLabel }} ▾</span>
                @endif
            </div>
            @if(isset($topBars) && count($topBars) > 0)
                <table class="fp-top10-tbl" id="fp-top10-tbl"></table>
            @else
                <div class="fp-sec-body">
                    <div class="fp-empty">Belum ada data produk</div>
                </div>
            @endif
        </div>

        <div class="fp-section">
            <div class="fp-sec-head">
                <div>
                    <div class="fp-sec-title">Statistik Model</div>
                    <div class="fp-sec-sub">Evaluasi model machine learning</div>
                </div>
            </div>
            <div class="fp-sec-body">
                @if(isset($predictionReady) && $predictionReady)
                    <div class="fp-stat-grid">
                        <div class="fp-stat-box">
                            <div class="fp-stat-box-icon">📉</div>
                            <div class="fp-stat-lbl">Rata-rata MAE</div>
                            <div class="fp-stat-val rose">{{ number_format($mae, 2) }}</div>
                        </div>
                        <div class="fp-stat-box">
                            <div class="fp-stat-box-icon">📈</div>
                            <div class="fp-stat-lbl">Rata-rata RMSE</div>
                            <div class="fp-stat-val rose">{{ number_format($rmse, 2) }}</div>
                        </div>
                        <div class="fp-stat-box">
                            <div class="fp-stat-box-icon">🎯</div>
                            <div class="fp-stat-lbl">Validation MAE</div>
                            <div class="fp-stat-val">{{ number_format($validationMae, 2) }}</div>
                        </div>
                        <div class="fp-stat-box">
                            <div class="fp-stat-box-icon">🛡️</div>
                            <div class="fp-stat-lbl">Validation RMSE</div>
                            <div class="fp-stat-val">{{ number_format($validationRmse, 2) }}</div>
                        </div>
                        <div class="fp-stat-box">
                            <div class="fp-stat-box-icon">🗄️</div>
                            <div class="fp-stat-lbl">Total Data</div>
                            <div class="fp-stat-val">{{ number_format($totalData) }}</div>
                        </div>
                        <div class="fp-stat-box">
                            <div class="fp-stat-box-icon">📅</div>
                            <div class="fp-stat-lbl">Periode</div>
                            <div class="fp-stat-val" style="font-size:13px;padding-top:3px">{{ $nextMonthLabel ?? 'Bulan Depan' }}</div>
                        </div>
                    </div>
                @else
                    <div class="fp-empty">Model belum dijalankan</div>
                @endif
            </div>
        </div>
    </div>

    {{-- BARIS 2: Tabel prediksi + Top5 + Perbandingan --}}
    <div style="display:grid;grid-template-columns:minmax(0,1.4fr) minmax(0,0.7fr) minmax(0,0.9fr);gap:14px">

        {{-- Tabel prediksi --}}
        <div class="fp-section">
            <div class="fp-sec-head">
                <div>
                    <div class="fp-sec-title">Tabel Kebutuhan Bunga Bulan Depan</div>
                    <div class="fp-sec-sub">Estimasi jumlah tangkai per produk — {{ $nextMonthLabel ?? 'bulan depan' }}</div>
                </div>
                @if(isset($nextMonthLabel))
                    <a href="{{ route('sales') }}" class="fp-month-badge">👁 Lihat Semua</a>
                @endif
            </div>
            <div class="fp-scroll-table">
                <table class="fp-tbl">
                    <colgroup>
                        <col style="width:32px">
                        <col>
                        <col style="width:120px">
                        <col style="width:65px">
                        <col style="width:65px">
                    </colgroup>
                    <thead>
                        <tr>
                            <th style="padding-left:14px">#</th>
                            <th>Nama Bunga</th>
                            <th>Butuh (tangkai)</th>
                            <th>MAE</th>
                            <th>RMSE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productPredictions as $item)
                            <tr>
                                <td style="padding-left:14px;color:#CCA8BA;font-size:11px">{{ $loop->iteration }}</td>
                                <td style="font-weight:600;color:var(--dark)">{{ $item['product_name'] }}</td>
                                <td>
                                    <span class="fp-badge">
                                        ✦ {{ number_format($item['prediction']) }}
                                    </span>
                                </td>
                                <td style="color:#7A4060">{{ number_format($item['mae'], 2) }}</td>
                                <td style="color:#7A4060">{{ number_format($item['rmse'], 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="fp-empty">Belum ada data prediksi</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Top 5 --}}
        <div class="fp-section">
            <div class="fp-sec-head">
                <div>
                    <div class="fp-sec-title">Top 5 Produk</div>
                    <div class="fp-sec-sub">Kebutuhan tertinggi — {{ $nextMonthLabel ?? 'bulan depan' }}</div>
                </div>
            </div>
            <div class="fp-sec-body" style="padding:12px 16px">
                @forelse($topProducts as $item)
                    <div class="fp-top5-row">
                        <div class="fp-rank {{ $loop->iteration == 1 ? 'r1' : ($loop->iteration == 2 ? 'r2' : ($loop->iteration == 3 ? 'r3' : 'rx')) }}">
                            {{ $loop->iteration }}
                        </div>
                        <span class="fp-rankname">{{ $item['product_name'] }}</span>
                        <span class="fp-rankval">{{ number_format($item['prediction']) }} tgk</span>
                    </div>
                @empty
                    <div class="fp-empty">Belum ada data</div>
                @endforelse
            </div>
        </div>

        {{-- Prediksi vs Real --}}
        <div class="fp-section">
            <div class="fp-sec-head">
                <div>
                    <div class="fp-sec-title">Prediksi vs Real</div>
                    <div class="fp-sec-sub">Perbandingan nilai aktual vs prediksi</div>
                </div>
            </div>
            <table class="fp-tbl" style="margin-top:4px">
                <thead>
                    <tr>
                        <th style="padding-left:14px">Tanggal</th>
                        <th>Prediksi</th>
                        <th>Real</th>
                        <th>Error</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($predictionComparison as $row)
                        <tr>
                            <td style="padding-left:14px;font-family:'DM Mono',monospace;font-size:10.5px">{{ $row->tanggal }}</td>
                            <td style="font-family:'DM Mono',monospace;font-size:11.5px">{{ number_format($row->predicted_sales) }}</td>
                            <td style="font-family:'DM Mono',monospace;font-size:11.5px">{{ number_format($row->actual_sales ?? 0) }}</td>
                            <td style="font-family:'DM Mono',monospace;font-size:11.5px;color:{{ ($row->error ?? 0) > 1000 ? 'var(--pk1)' : '#7A4060' }}">{{ number_format($row->error ?? 0) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="fp-empty" style="padding:16px">Belum ada data</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <a href="{{ route('sales') }}" class="fp-view-all">📈 Lihat Riwayat Lengkap</a>
        </div>
    </div>
</div>

<script>
const topBars = @json($topBars ?? []);
const tblEl = document.getElementById('fp-top10-tbl');
if (tblEl && topBars.length > 0) {
    const maxVal = Math.max(...topBars.map(i => i.prediction || 0));
    let html = `<thead><tr>
        <th style="width:36px;padding-left:14px">#</th>
        <th>Nama Produk</th>
        <th style="width:130px">Jumlah (tgk)</th>
        <th style="width:130px">Proporsi</th>
    </tr></thead><tbody>`;
    topBars.forEach((item, idx) => {
        const rank = idx + 1;
        const name = item.product_name ?? ('Produk #' + item.product_id);
        const val  = item.prediction ?? 0;
        const pct  = maxVal > 0 ? Math.round((val / maxVal) * 100) : 0;
        const rankClass = rank === 1 ? 'r1' : rank === 2 ? 'r2' : rank === 3 ? 'r3' : 'rx';
        html += `<tr>
            <td style="padding-left:14px">
                <span class="fp-top10-rank ${rankClass}">${rank}</span>
            </td>
            <td style="font-weight:600;color:var(--dark)">${name}</td>
            <td>
                <span class="fp-top10-pill">✦ ${val.toLocaleString('id-ID')}</span>
            </td>
            <td>
                <div style="display:flex;align-items:center;gap:8px">
                    <div class="fp-top10-bar-wrap">
                        <div class="fp-top10-bar-fill" style="width:${pct}%"></div>
                    </div>
                    <span style="font-size:11px;color:#CCA8BA;font-family:'DM Mono',monospace">${pct}%</span>
                </div>
            </td>
        </tr>`;
    });
    html += '</tbody>';
    tblEl.innerHTML = html;
}
</script>

</x-app-layout>