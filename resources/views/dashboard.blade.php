<x-app-layout>

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap');
*{box-sizing:border-box;margin:0;padding:0}

:root{
    --pk1:#E8185A;--pk2:#F04E8A;--pk3:#F87FB5;--pk4:#FDB8D4;--pk5:#FDE8F2;--pk6:#FFF2F8;
    --dark:#1A0A12;--muted:#9A7A8A;--border:#FCE4EF;--surface:#fff;
}

/* ── Page header ── */
.db-header{display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px}
.db-eyebrow{font-size:10px;font-weight:700;letter-spacing:.16em;text-transform:uppercase;color:var(--pk1);margin-bottom:4px}
.db-title{font-size:24px;font-weight:800;color:var(--dark);line-height:1}
.db-date{font-size:12px;color:var(--muted);background:var(--pk6);border:1px solid var(--border);border-radius:8px;padding:6px 14px;font-weight:500}

/* ── Model status banner ── */
.db-model-banner{border-radius:14px;padding:14px 20px;margin-bottom:18px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px}
.db-model-banner.active{background:linear-gradient(135deg,#FFF0F7,#FDE8F2);border:1px solid #FBCEDE}
.db-model-banner.inactive{background:#FFF8E6;border:1px solid #FFE0A0}
.db-model-left{display:flex;align-items:center;gap:14px}
.db-model-dot{width:10px;height:10px;border-radius:50%;flex-shrink:0}
.db-model-dot.active{background:var(--pk1);box-shadow:0 0 0 3px rgba(232,24,90,.2)}
.db-model-dot.inactive{background:#F59E0B}
.db-model-text-title{font-size:13px;font-weight:700;color:var(--dark)}
.db-model-text-sub{font-size:12px;color:var(--muted);margin-top:2px}
.db-model-cta{display:inline-flex;align-items:center;gap:7px;padding:9px 18px;background:var(--pk1);color:#fff;border:none;border-radius:10px;font-size:12px;font-weight:700;text-decoration:none;cursor:pointer;transition:all .18s;font-family:'Plus Jakarta Sans',sans-serif;white-space:nowrap}
.db-model-cta:hover{background:var(--pk2);transform:translateY(-1px)}
.db-model-cta.outline{background:transparent;color:#B45309;border:1px solid #FCD34D}
.db-model-cta.outline:hover{background:#FFFBEB}

/* ── Stat cards row ── */
.db-statrow{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:18px}
.db-stat{background:var(--surface);border:1px solid var(--border);border-radius:16px;padding:18px 20px;position:relative;overflow:hidden;transition:transform .18s,box-shadow .18s}
.db-stat:hover{transform:translateY(-3px);box-shadow:0 10px 28px rgba(232,24,90,.09)}
.db-stat-accent{position:absolute;top:0;left:0;width:4px;height:100%;border-radius:16px 0 0 16px}
.db-stat-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:12px}
.db-stat-icon{width:38px;height:38px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:17px;background:var(--pk6)}
.db-stat-trend{font-size:10px;font-weight:700;padding:3px 8px;border-radius:6px}
.db-stat-trend.up{background:#ECFDF5;color:#065F46}
.db-stat-trend.neu{background:var(--pk6);color:var(--pk1)}
.db-stat-lbl{font-size:10px;color:var(--muted);font-weight:600;letter-spacing:.3px;text-transform:uppercase;margin-bottom:4px}
.db-stat-val{font-size:26px;font-weight:800;color:var(--dark);font-family:'DM Mono',monospace;line-height:1}
.db-stat-val.rose{color:var(--pk1)}
.db-stat-sub{font-size:10px;color:var(--muted);margin-top:3px}

/* ── 3-col layout ── */
.db-row{display:grid;gap:12px;margin-bottom:12px}
.db-row-3{grid-template-columns:minmax(0,1.2fr) minmax(0,1fr) minmax(0,0.85fr)}
.db-row-2{grid-template-columns:minmax(0,1.5fr) minmax(0,1fr)}

/* ── Section card ── */
.db-sec{background:var(--surface);border:1px solid var(--border);border-radius:14px;overflow:hidden}
.db-sec-head{padding:13px 16px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between}
.db-sec-title{font-size:12.5px;font-weight:700;color:var(--dark)}
.db-sec-sub{font-size:10.5px;color:var(--muted);margin-top:2px}
.db-badge{display:inline-flex;align-items:center;gap:5px;background:var(--pk5);color:var(--pk1);font-size:10px;font-weight:700;border-radius:7px;padding:3px 9px;border:1px solid var(--border)}

/* Chart */
.db-chart-wrap{padding:8px 16px 16px}
.db-chart-area{position:relative;height:100px;display:flex;align-items:flex-end;gap:5px}
.db-bar-col{flex:1;display:flex;flex-direction:column;align-items:center;gap:4px}
.db-bar{width:100%;border-radius:5px 5px 0 0;background:var(--pk4)}
.db-bar.active{background:var(--pk1)}
.db-bar-lbl{font-size:8px;color:var(--muted);font-weight:600;font-family:'DM Mono',monospace}

/* Quick links */
.db-quicklinks{display:grid;grid-template-columns:1fr 1fr;gap:8px;padding:12px 14px}
.db-ql{display:flex;align-items:center;gap:8px;padding:10px 12px;background:var(--pk6);border:1px solid var(--border);border-radius:10px;text-decoration:none;transition:all .18s;cursor:pointer}
.db-ql:hover{background:var(--pk5);transform:translateX(2px)}
.db-ql-icon{width:30px;height:30px;border-radius:8px;background:var(--pk5);display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;border:1px solid var(--border)}
.db-ql-title{font-size:11px;font-weight:700;color:var(--dark)}
.db-ql-sub{font-size:9.5px;color:var(--muted);margin-top:1px}

/* Top 3 podium list */
.db-pod-rank{width:22px;height:22px;border-radius:6px;display:inline-flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;color:#fff;flex-shrink:0}
.db-pod-rank.p1{background:var(--pk1)}
.db-pod-rank.p2{background:var(--pk2)}
.db-pod-rank.p3{background:var(--pk3);color:#7A1A3A}

/* Recent sales table */
.db-mini-tbl{width:100%;border-collapse:collapse;font-size:12px}
.db-mini-tbl th{padding:8px 12px;text-align:left;font-size:9.5px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--muted);border-bottom:1px solid var(--border);background:var(--pk6)}
.db-mini-tbl td{padding:8px 12px;border-bottom:1px solid #FFF0F6;color:#4A2A3A;vertical-align:middle}
.db-mini-tbl tr:last-child td{border-bottom:none}
.db-mini-tbl tbody tr:hover td{background:var(--pk6)}
.db-pill{display:inline-flex;align-items:center;background:var(--pk5);border:1px solid var(--border);border-radius:6px;padding:2px 8px;font-weight:700;color:var(--pk1);font-family:'DM Mono',monospace;font-size:11px}

/* Accuracy model */
.db-sec-body{padding:16px}
.db-metric-row{display:flex;justify-content:space-between;align-items:center;margin-bottom:5px}
.db-metric-lbl{font-size:11px;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.3px}
.db-metric-val{font-size:22px;font-weight:800;color:var(--pk1);font-family:'DM Mono',monospace}
.db-metric-bar{height:5px;background:#FFF0F6;border-radius:3px;overflow:hidden;margin-bottom:14px}
.db-metric-bar-fill{height:100%;border-radius:3px;background:linear-gradient(90deg,var(--pk1),var(--pk3))}
.db-acc-big{text-align:center;padding:16px 0}
.db-acc-pct{font-size:36px;font-weight:800;color:var(--pk1);font-family:'DM Mono',monospace;line-height:1}
.db-acc-sub{font-size:11px;color:var(--muted);margin-top:4px}
.db-acc-bar-wrap{height:8px;background:#FFF0F6;border-radius:4px;overflow:hidden;margin-top:10px}
.db-acc-bar-fill{height:100%;background:linear-gradient(90deg,var(--pk1),var(--pk3));border-radius:4px;transition:width 1s ease}

.db-view-all{display:flex;align-items:center;justify-content:center;gap:5px;padding:10px;font-size:11px;font-weight:600;color:var(--pk1);text-decoration:none;border-top:1px solid #FFF0F6}
.db-view-all:hover{background:var(--pk6)}
.db-empty{text-align:center;padding:24px;color:var(--muted);font-size:11px}

/* Line chart SVG */
.db-line-wrap{padding:8px 16px 6px;height:130px;position:relative}

@media(max-width:1100px){
    .db-statrow{grid-template-columns:repeat(2,1fr)}
    .db-row-3,.db-row-2{grid-template-columns:1fr}
}
</style>

<div>
    {{-- Header --}}
    <div class="db-header">
        <div>
            <div class="db-eyebrow">FloraPredict</div>
            <div class="db-title">Dashboard</div>
        </div>
        <div class="db-date">📅 {{ now()->translatedFormat('l, d F Y') }}</div>
    </div>

    {{-- Model Status Banner --}}
    @if(isset($predictionReady) && $predictionReady)
        <div class="db-model-banner active">
            <div class="db-model-left">
                <div class="db-model-dot active"></div>
                <div>
                    <div class="db-model-text-title">Model prediksi aktif — estimasi stok tersedia untuk {{ $nextMonthLabel ?? 'bulan depan' }}</div>
                    <div class="db-model-text-sub">MAE {{ number_format($mae ?? 0, 2) }} · RMSE {{ number_format($rmse ?? 0, 2) }} · {{ number_format($totalProducts ?? 0) }} jenis bunga diprediksi</div>
                </div>
            </div>
            <a href="{{ route('prediksi') }}" class="db-model-cta">📊 Lihat Hasil Prediksi →</a>
        </div>
    @else
        <div class="db-model-banner inactive">
            <div class="db-model-left">
                <div class="db-model-dot inactive"></div>
                <div>
                    <div class="db-model-text-title">Model prediksi belum dijalankan</div>
                    <div class="db-model-text-sub">Jalankan model untuk mendapatkan estimasi kebutuhan stok bulan depan</div>
                </div>
            </div>
           <a href="{{ route('prediksi') }}" class="db-model-cta outline">📊 Buka Halaman Prediksi</a>
        </div>
    @endif

    {{-- Stat Cards --}}
    <div class="db-statrow">
        <div class="db-stat">
            <div class="db-stat-accent" style="background:var(--pk1)"></div>
            <div class="db-stat-top">
                <div class="db-stat-icon">🗄️</div>
                <span class="db-stat-trend neu">Dataset</span>
            </div>
            <div class="db-stat-lbl">Total Data Historis</div>
            <div class="db-stat-val">{{ number_format($totalData ?? 0) }}</div>
            <div class="db-stat-sub">baris data penjualan</div>
        </div>
        <div class="db-stat">
            <div class="db-stat-accent" style="background:var(--pk2)"></div>
            <div class="db-stat-top">
                <div class="db-stat-icon">
                    <svg width="18" height="18" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="18" cy="16" r="4" fill="#E8185A"/>
                        <ellipse cx="18" cy="8" rx="3.5" ry="5.5" fill="#F87FB5"/>
                        <ellipse cx="18" cy="24" rx="3.5" ry="5.5" fill="#F87FB5"/>
                        <ellipse cx="10" cy="16" rx="5.5" ry="3.5" fill="#F87FB5"/>
                        <ellipse cx="26" cy="16" rx="5.5" ry="3.5" fill="#F87FB5"/>
                        <ellipse cx="12.5" cy="10.5" rx="3.5" ry="5" transform="rotate(-45 12.5 10.5)" fill="#FDB8D4"/>
                        <ellipse cx="23.5" cy="10.5" rx="3.5" ry="5" transform="rotate(45 23.5 10.5)" fill="#FDB8D4"/>
                        <ellipse cx="12.5" cy="21.5" rx="3.5" ry="5" transform="rotate(45 12.5 21.5)" fill="#FDB8D4"/>
                        <ellipse cx="23.5" cy="21.5" rx="3.5" ry="5" transform="rotate(-45 23.5 21.5)" fill="#FDB8D4"/>
                        <line x1="18" y1="28" x2="18" y2="34" stroke="#4CAF50" stroke-width="2" stroke-linecap="round"/>
                        <path d="M18 31 Q14 28 12 25" stroke="#4CAF50" stroke-width="1.5" stroke-linecap="round" fill="none"/>
                    </svg>
                </div>
                <span class="db-stat-trend neu">Produk</span>
            </div>
            <div class="db-stat-lbl">Jenis Bunga</div>
            <div class="db-stat-val">{{ number_format($totalProducts ?? 0) }}</div>
            <div class="db-stat-sub">dalam database</div>
        </div>
        <div class="db-stat">
            <div class="db-stat-accent" style="background:var(--pk3)"></div>
            <div class="db-stat-top">
                <div class="db-stat-icon">📅</div>
                <span class="db-stat-trend neu">Periode</span>
            </div>
            <div class="db-stat-lbl">Estimasi Untuk</div>
            <div class="db-stat-val" style="font-size:15px;padding-top:6px">{{ $nextMonthLabel ?? 'Bulan Depan' }}</div>
            <div class="db-stat-sub">target prediksi model</div>
        </div>
        <div class="db-stat">
            <div class="db-stat-accent" style="background:var(--pk1)"></div>
            <div class="db-stat-top">
                <div class="db-stat-icon">📊</div>
                <span class="db-stat-trend {{ isset($predictionReady) && $predictionReady ? 'up' : 'neu' }}">
                    {{ isset($predictionReady) && $predictionReady ? 'Aktif' : 'Pending' }}
                </span>
            </div>
            <div class="db-stat-lbl">Total Prediksi</div>
            @if(isset($predictionReady) && $predictionReady)
                <div class="db-stat-val rose">{{ number_format($prediction ?? 0) }}</div>
                <div class="db-stat-sub">tangkai semua produk</div>
            @else
                <div class="db-stat-val" style="font-size:13px;color:var(--muted);padding-top:6px">Belum ada</div>
                <div class="db-stat-sub">jalankan model dulu</div>
            @endif
        </div>
    </div>

    {{-- Row 1: Tren + Top 3 + Quick Links --}}
    <div class="db-row db-row-3">
        {{-- Tren Penjualan --}}
        <div class="db-sec">
            <div class="db-sec-head">
                <div>
                    <div class="db-sec-title">Tren Penjualan Historis</div>
                    <div class="db-sec-sub">6 bulan terakhir (total semua produk)</div>
                </div>
                <select id="db-period-select" onchange="renderTrend(this.value)" style="border:1px solid var(--border);border-radius:7px;padding:4px 8px;font-size:10px;font-family:'Plus Jakarta Sans',sans-serif;color:var(--dark);background:var(--pk6);cursor:pointer;outline:none">
                    <option value="6">6 Bulan Terakhir</option>
                    <option value="12">12 Bulan Terakhir</option>
                </select>
            </div>
            <div class="db-line-wrap">
                <svg id="db-line-svg" width="100%" height="110" viewBox="0 0 400 110" preserveAspectRatio="none"></svg>
                <div id="db-trend-xlabels" style="display:flex;justify-content:space-between;padding:0 4px;margin-top:2px"></div>
            </div>
        </div>

        {{-- Top 3 Produk --}}
        <div class="db-sec">
            <div class="db-sec-head">
                <div>
                    <div class="db-sec-title">🏆 Top 3 Produk</div>
                    <div class="db-sec-sub">Penjualan tertinggi bulan ini</div>
                </div>
            </div>
            <div style="padding:10px 14px">
                @if(isset($topProducts) && $topProducts->count() >= 1)
                    @foreach($topProducts->take(3) as $i => $item)
                    <div style="display:flex;align-items:center;gap:8px;padding:7px 0;{{ !$loop->last ? 'border-bottom:1px solid #FFF0F6' : '' }}">
                        <div class="db-pod-rank p{{ $i+1 }}">{{ $i+1 }}</div>
                        <span style="flex:1;font-size:12px;font-weight:600;color:var(--dark)">{{ $item['product_name'] ?? 'N/A' }}</span>
                        <span style="font-size:12px;font-weight:700;color:var(--pk1);font-family:'DM Mono',monospace">
                            {{ number_format($item['prediction'] ?? 0) }} tgk
                        </span>
                    </div>
                    @endforeach
                    <a href="{{ route('prediksi') }}" class="db-view-all" style="margin:8px -14px -10px;border-radius:0 0 14px 14px">Lihat Semua →</a>
                @else
                    <div class="db-empty">Belum ada data Top Products</div>
                @endif
            </div>
        </div>

        {{-- Quick Links --}}
        <div class="db-sec">
            <div class="db-sec-head">
                <div>
                    <div class="db-sec-title">Menu Cepat</div>
                    <div class="db-sec-sub">Akses fitur utama</div>
                </div>
            </div>
            <div class="db-quicklinks">
                <a href="{{ route('prediksi') }}" class="db-ql">
                    <div class="db-ql-icon">📊</div>
                    <div><div class="db-ql-title">Prediksi</div><div class="db-ql-sub">Generate & lihat estimasi</div></div>
                </a>
                <a href="{{ route('sales') }}" class="db-ql">
                    <div class="db-ql-icon">📈</div>
                    <div><div class="db-ql-title">Riwayat</div><div class="db-ql-sub">Data penjualan lengkap</div></div>
                </a>
                <a href="{{ route('products.index') }}" class="db-ql">
                    <div class="db-ql-icon">🌸</div>
                    <div><div class="db-ql-title">Produk</div><div class="db-ql-sub">Kelola jenis bunga</div></div>
                </a>
                <a href="#" class="db-ql">
                    <div class="db-ql-icon">📥</div>
                    <div><div class="db-ql-title">Import Data</div><div class="db-ql-sub">Upload dataset baru</div></div>
                </a>
            </div>
        </div>
    </div>

    {{-- Row 2: Riwayat + Akurasi --}}
    <div class="db-row db-row-2">
        {{-- Riwayat Penjualan Terbaru --}}
        <div class="db-sec">
            <div class="db-sec-head">
                <div>
                    <div class="db-sec-title">Riwayat Penjualan Terbaru</div>
                    <div class="db-sec-sub">10 transaksi terakhir dari database</div>
                </div>
                <a href="{{ route('sales') }}" class="db-badge">Lihat Semua →</a>
            </div>
            <table class="db-mini-tbl">
                <thead>
                    <tr>
                        <th style="padding-left:14px">Tanggal</th>
                        <th>Produk</th>
                        <th>Jumlah (tgk)</th>
                        <th>Kasir</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentSales ?? [] as $row)
                        <tr>
                            <td style="padding-left:14px;font-family:'DM Mono',monospace;font-size:10.5px;color:var(--muted)">{{ $row->tanggal }}</td>
                            <td style="font-weight:600;color:var(--dark)">
                                <div style="display:flex;align-items:center;gap:6px">
                                    <span style="font-size:14px">
                                        @php
                                            $flowerEmojis = ['Mawar'=>'🌹','Kenanga'=>'🌼','Krisan'=>'🌻','Anggrek'=>'🌸','Tulip'=>'🌷'];
                                            $name = $row->product_name ?? '';
                                            echo $flowerEmojis[$name] ?? '🌺';
                                        @endphp
                                    </span>
                                    {{ $row->product_name ?? '-' }}
                                </div>
                            </td>
                            <td><span class="db-pill">{{ number_format($row->qty ?? 0) }}</span></td>
                            <td style="font-size:11px;color:var(--muted)">{{ $row->kasir_name ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4"><div class="db-empty">Belum ada data penjualan</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Akurasi Model --}}
        <div class="db-sec">
            <div class="db-sec-head">
                <div>
                    <div class="db-sec-title">Akurasi Model</div>
                    <div class="db-sec-sub">Ringkasan performa model prediksi</div>
                </div>
            </div>
            @if(isset($predictionReady) && $predictionReady)
                <div class="db-sec-body">
                    <div class="db-metric-row" style="margin-bottom:4px">
                        <span class="db-metric-lbl">Rata-rata MAE</span>
                        <span class="db-metric-val" style="font-size:18px">{{ number_format($mae ?? 0, 2) }}</span>
                    </div>
                    <div class="db-metric-bar">
                        <div class="db-metric-bar-fill" style="width:{{ min(100, (($mae ?? 0) / 500) * 100) }}%"></div>
                    </div>
                    <div class="db-metric-row" style="margin-bottom:4px">
                        <span class="db-metric-lbl">Rata-rata RMSE</span>
                        <span class="db-metric-val" style="font-size:18px">{{ number_format($rmse ?? 0, 2) }}</span>
                    </div>
                    <div class="db-metric-bar">
                        <div class="db-metric-bar-fill" style="width:{{ min(100, (($rmse ?? 0) / 700) * 100) }}%"></div>
                    </div>
                    <div class="db-acc-big">
                        @php $accuracy = isset($mae) && $mae > 0 ? max(0, 100 - (($mae / max($prediction ?? 1, 1)) * 100)) : ($modelAccuracy ?? 87); @endphp
                        <div class="db-acc-pct">{{ number_format($accuracy, 0) }}%</div>
                        <div class="db-acc-sub">Akurasi Model</div>
                        <div class="db-acc-bar-wrap">
                            <div class="db-acc-bar-fill" style="width:{{ $accuracy }}%"></div>
                        </div>
                    </div>
                    <a href="{{ route('prediksi') }}" class="db-view-all" style="margin:-4px -16px -16px;border-radius:0 0 14px 14px">📊 Detail Statistik Model →</a>
                </div>
            @else
                <div class="db-empty" style="padding:40px 16px">
                    <div style="font-size:30px;margin-bottom:8px">🤖</div>
                    <div style="font-weight:600;color:var(--dark);margin-bottom:4px">Model belum dijalankan</div>
                    <div style="font-size:10px">Akurasi akan tampil setelah prediksi di-generate</div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
const trendData = @json($monthlySalesTrend ?? []);

function renderTrend(months) {
    const data = trendData.slice(-parseInt(months));
    if (!data.length) return;

    const svg = document.getElementById('db-line-svg');
    const labelsEl = document.getElementById('db-trend-xlabels');
    const W = 400, H = 110, pad = { t: 12, r: 8, b: 8, l: 8 };
    const maxVal = Math.max(...data.map(d => d.total || 0)) || 1;
    const minVal = Math.min(...data.map(d => d.total || 0));

    const xStep = (W - pad.l - pad.r) / (data.length - 1 || 1);
    const pts = data.map((d, i) => {
        const x = pad.l + i * xStep;
        const y = pad.t + ((maxVal - (d.total || 0)) / (maxVal - minVal || 1)) * (H - pad.t - pad.b);
        return { x, y, val: d.total || 0 };
    });

    // Area gradient path
    let areaPath = `M${pts[0].x},${H - pad.b}`;
    pts.forEach(p => { areaPath += ` L${p.x},${p.y}`; });
    areaPath += ` L${pts[pts.length-1].x},${H - pad.b} Z`;

    // Smooth line
    let linePath = `M${pts[0].x},${pts[0].y}`;
    for (let i = 1; i < pts.length; i++) {
        const cpx = (pts[i-1].x + pts[i].x) / 2;
        linePath += ` C${cpx},${pts[i-1].y} ${cpx},${pts[i].y} ${pts[i].x},${pts[i].y}`;
    }

    svg.innerHTML = `
        <defs>
            <linearGradient id="areaGrad" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0%" stop-color="#E8185A" stop-opacity="0.18"/>
                <stop offset="100%" stop-color="#E8185A" stop-opacity="0.02"/>
            </linearGradient>
        </defs>
        <path d="${areaPath}" fill="url(#areaGrad)"/>
        <path d="${linePath}" fill="none" stroke="#E8185A" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
        ${pts.map(p => `<circle cx="${p.x}" cy="${p.y}" r="3.5" fill="#E8185A" stroke="white" stroke-width="1.5"/>`).join('')}
    `;

    labelsEl.innerHTML = data.map(d => `<span style="font-size:8.5px;color:#9A7A8A;font-weight:600">${d.label ?? ''}</span>`).join('');
}

renderTrend(6);
</script>

</x-app-layout>