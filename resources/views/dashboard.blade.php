<x-app-layout>

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&family=Playfair+Display:ital,wght@0,700;1,600&display=swap');

.db-wrap * { font-family: 'Plus Jakarta Sans', sans-serif; }

.db-wrap {
    max-width: 1160px;
    margin: 0 auto;
    padding: 2.5rem 1.5rem 5rem;
}

/* ══ HERO ══ */
.db-hero {
    position: relative;
    background: linear-gradient(135deg, #1a0a10 0%, #3d0f20 55%, #1a0a10 100%);
    border-radius: 24px;
    padding: 2.5rem 2.5rem;
    margin-bottom: 1.5rem;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1.5rem;
}

.db-hero::before {
    content: '🌸';
    position: absolute;
    font-size: 180px;
    right: -10px; bottom: -40px;
    opacity: 0.06;
    transform: rotate(-15deg);
    pointer-events: none;
}

.db-hero::after {
    content: '';
    position: absolute;
    top: -80px; left: -60px;
    width: 260px; height: 260px;
    background: radial-gradient(circle, rgba(244,63,94,0.2), transparent 70%);
    pointer-events: none;
}

.db-hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    background: rgba(244,63,94,0.2);
    border: 1px solid rgba(244,63,94,0.35);
    border-radius: 99px;
    padding: 0.28rem 0.9rem;
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: #fda4af;
    margin-bottom: 1rem;
}

.db-hero-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.95rem;
    font-weight: 700;
    color: #fff;
    line-height: 1.2;
    margin-bottom: 0.5rem;
}

.db-hero-sub {
    font-size: 0.85rem;
    color: rgba(255,255,255,0.45);
}

.db-hero-box {
    background: rgba(255,255,255,0.07);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 18px;
    padding: 1.4rem 2rem;
    text-align: center;
    backdrop-filter: blur(8px);
    min-width: 200px;
}

.db-hero-box .hb-label {
    font-size: 0.65rem;
    font-weight: 700;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: #fda4af;
    margin-bottom: 0.4rem;
}

.db-hero-box .hb-value {
    font-family: 'DM Mono', monospace;
    font-size: 2.8rem;
    font-weight: 700;
    color: #fff;
    line-height: 1;
    margin-bottom: 0.3rem;
}

.db-hero-box .hb-sub {
    font-size: 0.73rem;
    color: rgba(255,255,255,0.4);
}

/* ══ STAT CARDS ══ */
.db-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.db-stat {
    background: #fff;
    border-radius: 18px;
    border: 1px solid #f5e8eb;
    padding: 1.4rem 1.5rem;
    box-shadow: 0 4px 20px rgba(244,63,94,0.06);
    transition: transform 0.2s, box-shadow 0.2s;
    position: relative;
    overflow: hidden;
}

.db-stat:hover {
    transform: translateY(-5px);
    box-shadow: 0 14px 36px rgba(244,63,94,0.13);
}

.db-stat-icon {
    width: 42px; height: 42px;
    border-radius: 13px;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px;
    margin-bottom: 1rem;
}

.ic-pink  { background: #fff1f2; }
.ic-blue  { background: #eff6ff; }
.ic-green { background: #ecfdf5; }

.db-stat-label {
    font-size: 0.67rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #a8a29e;
    margin-bottom: 0.4rem;
}

.db-stat-value {
    font-family: 'DM Mono', monospace;
    font-size: 2.1rem;
    font-weight: 700;
    line-height: 1;
    margin-bottom: 0.55rem;
}

.v-rose  { color: #e11d48; }
.v-blue  { color: #2563eb; }
.v-green { color: #059669; }

.db-stat-meta {
    display: flex; align-items: center; gap: 0.4rem;
    font-size: 0.77rem; color: #a8a29e;
}

.db-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
.d-rose  { background: #f43f5e; }
.d-blue  { background: #3b82f6; }
.d-green { background: #10b981; }

/* ══ BOTTOM GRID ══ */
.db-bottom {
    display: grid;
    grid-template-columns: 320px 1fr;
    gap: 1.25rem;
    align-items: start;
}

/* metrics */
.db-metrics {
    background: #fff;
    border-radius: 18px;
    border: 1px solid #f5e8eb;
    box-shadow: 0 4px 20px rgba(244,63,94,0.06);
    padding: 1.5rem;
}

.db-panel-head { margin-bottom: 1.25rem; }
.db-panel-title { font-size: 0.95rem; font-weight: 700; color: #1c1917; margin-bottom: 0.2rem; }
.db-panel-sub   { font-size: 0.77rem; color: #a8a29e; }

.db-metric-row {
    background: #faf7f5;
    border: 1px solid #f0e8ec;
    border-radius: 12px;
    padding: 1rem 1.15rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 0.75rem;
}
.db-metric-row:last-of-type { margin-bottom: 1.25rem; }

.db-metric-name { font-size: 0.84rem; font-weight: 600; color: #44403c; }
.db-metric-desc { font-size: 0.71rem; color: #a8a29e; margin-top: 1px; }
.db-metric-val  {
    font-family: 'DM Mono', monospace;
    font-size: 1.55rem;
    font-weight: 700;
    color: #1c1917;
}

.db-period-strip {
    border-top: 1px solid #f5ece8;
    padding-top: 1.1rem;
    display: flex; align-items: center; gap: 0.6rem;
}

.db-period-lbl { font-size: 0.72rem; color: #a8a29e; }
.db-period-val {
    background: #fff1f2;
    color: #be123c;
    border-radius: 8px;
    padding: 0.22rem 0.6rem;
    font-size: 0.77rem;
    font-weight: 700;
    font-family: 'DM Mono', monospace;
}

/* chart */
.db-chart {
    background: #fff;
    border-radius: 18px;
    border: 1px solid #f5e8eb;
    box-shadow: 0 4px 20px rgba(244,63,94,0.06);
    padding: 1.5rem;
}

.db-chart-head {
    display: flex; align-items: flex-start; justify-content: space-between;
    margin-bottom: 1.5rem; flex-wrap: wrap; gap: 0.75rem;
}

.db-chart-badge {
    display: inline-flex; align-items: center; gap: 0.35rem;
    background: #fff1f2; color: #be123c;
    border-radius: 99px; padding: 0.3rem 0.85rem;
    font-size: 0.71rem; font-weight: 700;
}
.db-chart-badge::before {
    content: ''; width: 6px; height: 6px;
    border-radius: 50%; background: #f43f5e;
}

/* ══ RESPONSIVE ══ */
@media (max-width: 900px) { .db-bottom { grid-template-columns: 1fr; } }
@media (max-width: 640px) {
    .db-stats { grid-template-columns: 1fr; }
    .db-hero  { padding: 1.75rem 1.25rem; }
    .db-hero-title { font-size: 1.5rem; }
}
</style>

<div class="db-wrap">

    {{-- ── HERO ── --}}
    <div class="db-hero">
        <div>
            <div class="db-hero-eyebrow">🌸 FloraPredict · Ringkasan Sistem</div>
            <h1 class="db-hero-title">Sistem Prediksi<br>Penjualan Bunga</h1>
            <p class="db-hero-sub">Selamat datang kembali — berikut ringkasan data dan prediksi terkini.</p>
        </div>

        <div class="db-hero-box">
            <div class="hb-label">Prediksi Bulan Berikutnya</div>
            <div class="hb-value">{{ number_format($prediction) }}</div>
            <div class="hb-sub">bunga · bulan ke-{{ $nextPeriod }}</div>
        </div>
    </div>

    {{-- ── STAT CARDS ── --}}
    <div class="db-stats">

        <div class="db-stat">
            <div class="db-stat-icon ic-pink">💐</div>
            <div class="db-stat-label">Total Data Dataset</div>
            <div class="db-stat-value v-rose">{{ $totalData }}</div>
            <div class="db-stat-meta">
                <span class="db-dot d-rose"></span> Periode: {{ $totalData }} bulan
            </div>
        </div>

        <div class="db-stat">
            <div class="db-stat-icon ic-blue">📈</div>
            <div class="db-stat-label">Prediksi Qty</div>
            <div class="db-stat-value v-blue">{{ number_format($prediction) }}</div>
            <div class="db-stat-meta">
                <span class="db-dot d-blue"></span> Hasil model ML
            </div>
        </div>

        <div class="db-stat">
            <div class="db-stat-icon ic-green">🎯</div>
            <div class="db-stat-label">Periode Prediksi</div>
            <div class="db-stat-value v-green">ke-{{ $nextPeriod }}</div>
            <div class="db-stat-meta">
                <span class="db-dot d-green"></span> dari total {{ $totalData }} data
            </div>
        </div>

    </div>

    {{-- ── METRICS + CHART ── --}}
    <div class="db-bottom">

        {{-- Evaluasi model --}}
        <div class="db-metrics">
            <div class="db-panel-head">
                <div class="db-panel-title">Evaluasi Model ML</div>
                <div class="db-panel-sub">Performa berdasarkan data historis</div>
            </div>

            <div class="db-metric-row">
                <div>
                    <div class="db-metric-name">MAE</div>
                    <div class="db-metric-desc">Mean Absolute Error</div>
                </div>
                <div class="db-metric-val">{{ $mae }}</div>
            </div>

            <div class="db-metric-row">
                <div>
                    <div class="db-metric-name">RMSE</div>
                    <div class="db-metric-desc">Root Mean Square Error</div>
                </div>
                <div class="db-metric-val">{{ $rmse }}</div>
            </div>

            <div class="db-period-strip">
                <span class="db-period-lbl">Periode aktif:</span>
                <span class="db-period-val">{{ $totalData }} bulan</span>
            </div>
        </div>

        {{-- Grafik --}}
        <div class="db-chart">
            <div class="db-chart-head">
                <div>
                    <div class="db-panel-title">Grafik Penjualan Historis</div>
                    <div class="db-panel-sub">Tren penjualan bunga dari data historis</div>
                </div>
                <span class="db-chart-badge">{{ $totalData }} data</span>
            </div>
            <canvas id="salesChart" height="95"></canvas>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const labels = @json($labels);
const values = @json($values);

const ctx = document.getElementById('salesChart').getContext('2d');

const grad = ctx.createLinearGradient(0, 0, 0, 360);
grad.addColorStop(0,   'rgba(244,63,94,0.16)');
grad.addColorStop(0.65,'rgba(244,63,94,0.03)');
grad.addColorStop(1,   'rgba(244,63,94,0)');

new Chart(ctx, {
    type: 'line',
    data: {
        labels,
        datasets: [{
            label: 'Penjualan Bunga',
            data: values,
            borderColor: '#f43f5e',
            backgroundColor: grad,
            borderWidth: 2.5,
            pointBackgroundColor: '#f43f5e',
            pointBorderColor: '#fff',
            pointBorderWidth: 2.5,
            pointRadius: 5,
            pointHoverRadius: 8,
            pointHoverBackgroundColor: '#be123c',
            tension: 0.45,
            fill: true,
        }]
    },
    options: {
        responsive: true,
        interaction: { intersect: false, mode: 'index' },
        plugins: {
            legend: {
                labels: {
                    font: { family: 'Plus Jakarta Sans', size: 12, weight: '600' },
                    color: '#78716c',
                    usePointStyle: true,
                    pointStyleWidth: 8,
                }
            },
            tooltip: {
                backgroundColor: '#1c1917',
                titleColor: '#fda4af',
                bodyColor: '#e7e5e4',
                padding: 12,
                cornerRadius: 10,
                borderColor: 'rgba(244,63,94,0.25)',
                borderWidth: 1,
                titleFont: { family: 'Plus Jakarta Sans', weight: '700', size: 12 },
                bodyFont:  { family: 'DM Mono', size: 13 },
                callbacks: {
                    label: c => '  ' + Number(c.parsed.y).toLocaleString('id-ID')
                }
            }
        },
        scales: {
            y: {
                beginAtZero: false,
                grid: { color: 'rgba(0,0,0,0.04)', drawBorder: false },
                ticks: {
                    color: '#a8a29e',
                    font: { family: 'DM Mono', size: 11 },
                    callback: v => Number(v).toLocaleString('id-ID')
                }
            },
            x: {
                grid: { display: false },
                ticks: { color: '#a8a29e', font: { family: 'Plus Jakarta Sans', size: 11 } }
            }
        }
    }
});
</script>

</x-app-layout>