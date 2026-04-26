<x-app-layout>

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap');

*{box-sizing:border-box;margin:0;padding:0;font-family:'Plus Jakarta Sans',sans-serif}

.fp-main{margin:0 auto;padding:30px 20px;background:#fdf5f5}
.fp-breadcrumb{font-size:11px;color:#e8474f;font-weight:700;letter-spacing:.3px;margin-bottom:4px}
.fp-title{font-size:26px;font-weight:800;color:#1a1a2e;margin-bottom:16px}
.fp-status-ok{background:#f0fdf4;border:1px solid #86efac;border-radius:12px;padding:10px 14px;font-size:13px;color:#15803d;display:flex;align-items:center;gap:7px;margin-bottom:18px}
.fp-status-warn{background:#eff6ff;border:1px solid #bfdbfe;border-radius:12px;padding:10px 14px;font-size:13px;color:#1e40af;display:flex;align-items:center;gap:7px;margin-bottom:18px}
.fp-status-dot{width:7px;height:7px;border-radius:50%;background:#22c55e;flex-shrink:0}

.fp-cards{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:18px}
.fp-card{background:#fff;border:1px solid #f5e4e8;border-radius:16px;padding:18px;box-shadow:0 2px 14px rgba(232,93,117,.07)}
.fp-card-lbl{font-size:11px;color:#b0a0b0;text-transform:uppercase;letter-spacing:.4px;margin-bottom:8px;font-weight:700}
.fp-card-val{font-size:28px;font-weight:700;color:#1a1a2e;font-family:'DM Mono',monospace}
.fp-card-val.pink{color:#e8474f}
.fp-card-sub{font-size:11px;color:#b0a0b0;margin-top:4px}

.fp-cols2{display:grid;grid-template-columns:minmax(0,1.5fr) minmax(0,1fr);gap:14px;margin-bottom:14px}
.fp-section{background:#fff;border:1px solid #f5e4e8;border-radius:16px;padding:18px;box-shadow:0 2px 14px rgba(232,93,117,.07)}
.fp-sec-title{font-size:15px;font-weight:800;color:#1a1a2e;margin-bottom:3px}
.fp-sec-sub{font-size:12px;color:#b0a0b0;margin-bottom:14px}

.fp-stat-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px}
.fp-stat-box{background:#fdf5f5;border-radius:10px;padding:12px;border:1px solid #f5e0e5}
.fp-stat-lbl{font-size:10px;color:#b0a0b0;text-transform:uppercase;letter-spacing:.3px;margin-bottom:3px;font-weight:700}
.fp-stat-val{font-size:18px;font-weight:700;color:#1a1a2e;font-family:'DM Mono',monospace}
.fp-stat-val.pink{color:#e8474f}

.fp-tbl{width:100%;border-collapse:collapse;font-size:12px;table-layout:fixed}
.fp-tbl th{text-align:left;color:#b0a0b0;font-size:11px;font-weight:700;padding:0 10px 8px;border-bottom:1px solid #f5e4e8;text-transform:uppercase;letter-spacing:.3px;overflow:hidden;white-space:nowrap}
.fp-tbl td{padding:9px 10px;border-bottom:1px solid #f5e4e8;color:#1a1a2e;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.fp-tbl tr:last-child td{border-bottom:none}

.fp-top5-row{display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid #f5e4e8}
.fp-top5-row:last-child{border-bottom:none}
.fp-rank{width:20px;height:20px;border-radius:50%;background:#e8474f;color:#fff;font-size:10px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.fp-rank.gold{background:#ba7517}
.fp-rank.silver{background:#888780}
.fp-rank.bronze{background:#854f0b}
.fp-rankname{flex:1;font-size:12px;color:#1a1a2e}
.fp-rankval{font-size:12px;font-weight:700;color:#e8474f}

.bar-row{display:flex;align-items:center;gap:8px;margin-bottom:8px}
.bar-lbl{font-size:11px;color:#7f6f80;width:90px;text-align:right;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;flex-shrink:0}
.bar-track{flex:1;height:15px;background:#fdf5f5;border-radius:4px;overflow:hidden}
.bar-fill{height:100%;background:#e8474f;border-radius:4px}
.bar-num{font-size:11px;font-weight:700;width:42px;text-align:right;flex-shrink:0;color:#1a1a2e}

.fp-empty{text-align:center;padding:30px 16px;color:#b0a0b0;font-size:13px}
.fp-scroll-table{max-height:360px;overflow:auto}

@media(max-width:1000px){
    .fp-cards{grid-template-columns:repeat(2,1fr)}
    .fp-cols2{grid-template-columns:1fr}
}
</style>

<div class="fp-main">

    <div class="fp-breadcrumb">FLORAPREDICT</div>
    <div class="fp-title">Dashboard</div>

    @if(isset($predictionReady) && $predictionReady)
        <div class="fp-status-ok">
            <div class="fp-status-dot"></div>
            Model prediksi aktif — hasil tersedia untuk periode berikutnya
        </div>
    @else
        <div class="fp-status-warn">
            Prediksi belum dijalankan — jalankan model untuk melihat hasil prediksi
        </div>
    @endif

    <div class="fp-cards">
        <div class="fp-card">
            <div class="fp-card-lbl">Total Data</div>
            <div class="fp-card-val">{{ number_format($totalData) }}</div>
            <div class="fp-card-sub">baris dataset tersedia</div>
        </div>

        <div class="fp-card">
            <div class="fp-card-lbl">Total Prediksi Penjualan</div>
            @if(isset($predictionReady) && $predictionReady)
                <div class="fp-card-val pink">{{ number_format($prediction) }}</div>
                <div class="fp-card-sub">total prediksi semua produk</div>
            @else
                <div class="fp-card-val" style="font-size:18px;color:#bbb">Belum ada</div>
            @endif
        </div>

        <div class="fp-card">
            <div class="fp-card-lbl">Jumlah Produk Diprediksi</div>
            <div class="fp-card-val pink">{{ number_format($totalProducts ?? 0) }}</div>
            <div class="fp-card-sub">produk aktif dalam model</div>
        </div>

        <div class="fp-card">
            <div class="fp-card-lbl">Periode Prediksi</div>
            <div class="fp-card-val" style="font-size:20px;padding-top:6px">Berikutnya</div>
            <div class="fp-card-sub">periode berikutnya</div>
        </div>
    </div>

    <div class="fp-cols2">
        <div class="fp-section">
            <div class="fp-sec-title">Top 10 Produk Berdasarkan Prediksi</div>
            <div class="fp-sec-sub">Visualisasi hasil prediksi penjualan per produk</div>

            @if(isset($topBars) && count($topBars) > 0)
                <div id="fp-bars"></div>
            @else
                <div class="fp-empty">Belum ada data grafik produk</div>
            @endif
        </div>

        <div class="fp-section">
            <div class="fp-sec-title">Statistik Model</div>
            <div class="fp-sec-sub">Evaluasi model machine learning</div>

            @if(isset($predictionReady) && $predictionReady)
                <div class="fp-stat-grid">
                    <div class="fp-stat-box">
                        <div class="fp-stat-lbl">Rata-rata MAE</div>
                        <div class="fp-stat-val pink">{{ number_format($mae, 2) }}</div>
                    </div>

                    <div class="fp-stat-box">
                        <div class="fp-stat-lbl">Rata-rata RMSE</div>
                        <div class="fp-stat-val pink">{{ number_format($rmse, 2) }}</div>
                    </div>

                    <div class="fp-stat-box">
                        <div class="fp-stat-lbl">Validation MAE</div>
                        <div class="fp-stat-val">{{ number_format($validationMae, 2) }}</div>
                    </div>

                    <div class="fp-stat-box">
                        <div class="fp-stat-lbl">Validation RMSE</div>
                        <div class="fp-stat-val">{{ number_format($validationRmse, 2) }}</div>
                    </div>

                    <div class="fp-stat-box">
                        <div class="fp-stat-lbl">Total Data</div>
                        <div class="fp-stat-val">{{ number_format($totalData) }}</div>
                    </div>

                    <div class="fp-stat-box">
                        <div class="fp-stat-lbl">Periode</div>
                        <div class="fp-stat-val" style="font-size:14px">Berikutnya</div>
                    </div>
                </div>
            @else
                <div class="fp-empty">Model belum dijalankan</div>
            @endif
        </div>
    </div>

    <div class="fp-cols2">
        <div class="fp-section">
            <div class="fp-sec-title">Tabel Prediksi Per Produk</div>
            <div class="fp-sec-sub">Hasil model ML per produk — periode berikutnya</div>

            <div class="fp-scroll-table">
                <table class="fp-tbl">
                    <colgroup>
                        <col style="width:40px">
                        <col>
                        <col style="width:100px">
                        <col style="width:80px">
                        <col style="width:80px">
                    </colgroup>
                    <tr>
                        <th>#</th>
                        <th>Nama Bunga</th>
                        <th>Prediksi</th>
                        <th>MAE</th>
                        <th>RMSE</th>
                    </tr>

                    @forelse($productPredictions as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item['product_name'] }}</td>
                            <td style="font-weight:700;color:#e8474f">
                                {{ number_format($item['prediction']) }}
                            </td>
                            <td>{{ number_format($item['mae'], 2) }}</td>
                            <td>{{ number_format($item['rmse'], 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Belum ada data prediksi produk</td>
                        </tr>
                    @endforelse
                </table>
            </div>
        </div>

        <div style="display:flex;flex-direction:column;gap:14px">
            <div class="fp-section">
                <div class="fp-sec-title">Top 5 Produk</div>
                <div class="fp-sec-sub">Prediksi penjualan tertinggi</div>

                @forelse($topProducts as $item)
                    <div class="fp-top5-row">
                        <div class="fp-rank {{ $loop->iteration == 1 ? 'gold' : ($loop->iteration == 2 ? 'silver' : ($loop->iteration == 3 ? 'bronze' : '')) }}">
                            {{ $loop->iteration }}
                        </div>
                        <span class="fp-rankname">{{ $item['product_name'] }}</span>
                        <span class="fp-rankval">{{ number_format($item['prediction']) }}</span>
                    </div>
                @empty
                    <div class="fp-empty">Belum ada data top produk</div>
                @endforelse
            </div>

            <div class="fp-section">
                <div class="fp-sec-title">Prediksi vs Real</div>
                <div class="fp-sec-sub">Perbandingan nilai aktual vs prediksi</div>

                <table class="fp-tbl">
                    <tr>
                        <th>Tanggal</th>
                        <th>Prediksi</th>
                        <th>Real</th>
                        <th>Error</th>
                    </tr>

                    @forelse($predictionComparison as $row)
                        <tr>
                            <td>{{ $row->tanggal }}</td>
                            <td>{{ number_format($row->predicted_sales) }}</td>
                            <td>{{ number_format($row->actual_sales ?? 0) }}</td>
                            <td>{{ number_format($row->error ?? 0) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Belum ada data perbandingan</td>
                        </tr>
                    @endforelse
                </table>
            </div>
        </div>
    </div>

</div>

<script>
const topBars = @json($topBars ?? []);

const barContainer = document.getElementById('fp-bars');

if (barContainer && topBars.length > 0) {
    const maxBar = Math.max(...topBars.map(item => item.prediction || 0));

    topBars.forEach(item => {
        const name = item.product_name ?? ('Produk #' + item.product_id);
        const value = item.prediction ?? 0;
        const pct = maxBar > 0 ? Math.round((value / maxBar) * 100) : 0;

        barContainer.innerHTML += `
            <div class="bar-row">
                <span class="bar-lbl">${name}</span>
                <div class="bar-track">
                    <div class="bar-fill" style="width:${pct}%"></div>
                </div>
                <span class="bar-num">${value.toLocaleString('id-ID')}</span>
            </div>
        `;
    });
}
</script>

</x-app-layout>