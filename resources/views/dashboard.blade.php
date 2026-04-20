<x-app-layout>

<style>
/* ── Base ── */
.fp-eyebrow {
    font-size: 0.7rem; font-weight: 700;
    letter-spacing: 0.14em; text-transform: uppercase;
    color: #e85d75; margin-bottom: 0.25rem;
}
.fp-title { font-size: 1.7rem; font-weight: 700; color: #1a1a2e; }
.fp-header { margin-bottom: 1.75rem; }
.fp-inner { max-width: 1100px; margin: 0 auto; }

/* ── Alert banner ── */
.fp-alert-banner {
    display: flex; align-items: center; gap: 0.75rem;
    padding: 0.85rem 1.1rem; border-radius: 12px;
    font-size: 0.84rem; font-weight: 500; margin-bottom: 1.5rem;
}
.fp-alert-warn {
    background: #fff7ed; border: 1px solid #fed7aa; color: #9a3412;
}
.fp-alert-info {
    background: #eff6ff; border: 1px solid #bfdbfe; color: #1e40af;
}
.fp-alert-none {
    background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534;
}

/* ── KPI Grid ── */
.dash-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 14px;
    margin-bottom: 20px;
}
.dash-card {
    background: #fff;
    border-radius: 16px;
    padding: 20px;
    border: 1px solid #ece8f0;
    box-shadow: 0 2px 12px rgba(232,93,117,0.06);
    position: relative;
    overflow: hidden;
}
.dash-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, #e85d75, #f4a0b0);
    border-radius: 16px 16px 0 0;
}
.dash-card small {
    font-size: 0.7rem; color: #a1a1b5;
    text-transform: uppercase; letter-spacing: 0.08em; font-weight: 700;
}
.dash-card h2 {
    font-size: 2rem; margin: 8px 0 0;
    font-family: 'DM Mono', monospace;
    color: #1a1a2e; font-weight: 500;
}
.dash-card h2.rose { color: #e85d75; }
.dash-card-sub {
    font-size: 0.72rem; color: #a1a1b5; margin-top: 4px;
}

/* ── Box ── */
.dash-box {
    background: #fff;
    border-radius: 16px;
    padding: 20px;
    border: 1px solid #ece8f0;
    margin-bottom: 16px;
    box-shadow: 0 2px 12px rgba(232,93,117,0.06);
}
.dash-box-header {
    display: flex; align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
}
.dash-box-title {
    font-size: 0.875rem; font-weight: 700; color: #1a1a2e;
}
.dash-box-sub {
    font-size: 0.72rem; color: #a1a1b5; margin-top: 2px;
}

/* ── Prediction belum jalan ── */
.fp-prediction-empty {
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    padding: 2.5rem 1rem; text-align: center;
    color: #c0bbd0;
}
.fp-prediction-empty svg { margin-bottom: 0.75rem; }
.fp-prediction-empty p { font-size: 0.84rem; }
.fp-prediction-empty span { font-size: 0.75rem; color: #d0bbd0; margin-top: 0.3rem; display: block; }

/* ── Two col ── */
.dash-two-col {
    display: grid;
    grid-template-columns: minmax(0, 1.5fr) minmax(0, 1fr);
    gap: 16px;
    margin-bottom: 16px;
}

/* ── Akurasi bar ── */
.acc-row {
    display: flex; align-items: center;
    margin-bottom: 12px; font-size: 0.8rem; color: #4a4a6a;
}
.acc-label { min-width: 90px; font-weight: 500; }
.bar-bg {
    flex: 1; height: 7px;
    background: #f1eef3; margin: 0 10px; border-radius: 5px;
}
.bar { height: 100%; border-radius: 5px; transition: width 0.6s ease; }
.green  { background: linear-gradient(90deg, #22c55e, #4ade80); }
.yellow { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
.red    { background: linear-gradient(90deg, #ef4444, #f87171); }
.acc-val { font-size: 0.75rem; font-weight: 700; min-width: 34px; text-align: right; }
.acc-val.green  { color: #16a34a; }
.acc-val.yellow { color: #d97706; }
.acc-val.red    { color: #dc2626; }

/* ── Slow moving ── */
.slow-item {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 12px; background: #fdf5f7;
    border-radius: 10px; margin-bottom: 8px;
    border: 1px solid #f9e4e9;
}
.slow-name { font-size: 0.84rem; font-weight: 600; color: #1a1a2e; flex: 1; }
.slow-rate { font-size: 0.72rem; color: #9090aa; }
.slow-badge {
    font-size: 0.68rem; font-weight: 700; padding: 3px 8px;
    border-radius: 20px; white-space: nowrap;
}
.badge-red    { background: #fee2e2; color: #991b1b; }
.badge-amber  { background: #fff7ed; color: #92400e; }

/* ── Stats row ── */
.stats-row {
    display: grid; grid-template-columns: repeat(2, 1fr);
    gap: 10px; margin-top: 12px;
}
.stat-item {
    background: #fdf5f7; border-radius: 10px;
    padding: 12px 14px; border: 1px solid #f9e4e9;
}
.stat-label { font-size: 0.7rem; color: #a1a1b5; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }
.stat-val   { font-size: 1.1rem; font-weight: 700; color: #1a1a2e; font-family: 'DM Mono', monospace; margin-top: 4px; }
.stat-val.rose { color: #e85d75; }

canvas { max-height: 200px; }
</style>

<div class="fp-inner">

    {{-- Header --}}
    <div class="fp-header">
        <div class="fp-eyebrow">FloraPredict</div>
        <h1 class="fp-title">Dashboard</h1>
    </div>

    {{-- Alert Banner — hanya muncul jika ada warning --}}
    @if(isset($warning) && $warning)
        <div class="fp-alert-banner fp-alert-warn">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="flex-shrink:0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
            </svg>
            {{ $warning }}
        </div>
    @elseif($predictionReady)
        <div class="fp-alert-banner fp-alert-none">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="flex-shrink:0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Model prediksi aktif — hasil tersedia untuk periode ke-{{ $nextPeriod }}
        </div>
    @else
        <div class="fp-alert-banner fp-alert-info">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="flex-shrink:0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
            </svg>
            Prediksi belum dijalankan — jalankan model untuk melihat hasil prediksi stok
        </div>
    @endif

    {{-- KPI Cards --}}
    <div class="dash-grid">
        <div class="dash-card">
            <small>Total Data</small>
            <h2>{{ $totalData }}</h2>
            <div class="dash-card-sub">baris dataset tersedia</div>
        </div>
        <div class="dash-card">
            <small>Hasil Prediksi</small>
            @if($predictionReady)
                <h2 class="rose">{{ number_format($prediction) }}</h2>
                <div class="dash-card-sub">prediksi periode ke-{{ $nextPeriod }}</div>
            @else
                <h2 class="rose" style="font-size:1.1rem;margin-top:12px;color:#c0bbd0">Belum ada</h2>
                <div class="dash-card-sub">model belum dijalankan</div>
            @endif
        </div>
        <div class="dash-card">
            <small>Periode</small>
            <h2>ke-{{ $nextPeriod }}</h2>
            <div class="dash-card-sub">periode prediksi berikutnya</div>
        </div>
    </div>

    {{-- Chart + Akurasi --}}
    <div class="dash-two-col">

        {{-- Grafik Penjualan --}}
        <div class="dash-box">
            <div class="dash-box-header">
                <div>
                    <div class="dash-box-title">Grafik Penjualan</div>
                    <div class="dash-box-sub">Tren quantity ordered per periode</div>
                </div>
            </div>
            @if($totalData > 0)
                <canvas id="chart"></canvas>
            @else
                <div class="fp-prediction-empty">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
                    </svg>
                    <p>Belum ada data grafik</p>
                    <span>Upload dataset terlebih dahulu</span>
                </div>
            @endif
        </div>

        {{-- Akurasi per Periode --}}
        <div class="dash-box">
            <div class="dash-box-header">
                <div>
                    <div class="dash-box-title">Akurasi per Periode</div>
                    <div class="dash-box-sub">Konsistensi data penjualan</div>
                </div>
            </div>
            @forelse($akurasiData ?? [] as $item)
            <div class="acc-row">
                <span class="acc-label">{{ $item['nama'] }}</span>
                <div class="bar-bg">
                    <div class="bar {{ $item['level'] }}" style="width:{{ $item['nilai'] }}%"></div>
                </div>
                <span class="acc-val {{ $item['level'] }}">{{ $item['nilai'] }}%</span>
            </div>
            @empty
            <div class="fp-prediction-empty">
                <p>Tidak ada data akurasi</p>
                <span>Upload dataset terlebih dahulu</span>
            </div>
            @endforelse
        </div>

    </div>

    {{-- MAE/RMSE + Slow Moving --}}
    <div class="dash-two-col">

        {{-- Statistik Model --}}
        <div class="dash-box">
            <div class="dash-box-header">
                <div>
                    <div class="dash-box-title">Statistik Model</div>
                    <div class="dash-box-sub">Error rate hasil prediksi terakhir</div>
                </div>
            </div>
            @if($predictionReady)
                <div class="stats-row">
                    <div class="stat-item">
                        <div class="stat-label">MAE</div>
                        <div class="stat-val rose">{{ number_format($mae, 2) }}</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-label">RMSE</div>
                        <div class="stat-val rose">{{ number_format($rmse, 2) }}</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-label">Total Data</div>
                        <div class="stat-val">{{ $totalData }}</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-label">Periode Prediksi</div>
                        <div class="stat-val">ke-{{ $nextPeriod }}</div>
                    </div>
                </div>
            @else
                <div class="fp-prediction-empty">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5"/>
                    </svg>
                    <p>Model belum dijalankan</p>
                    <span>MAE dan RMSE akan muncul setelah prediksi dijalankan</span>
                </div>
            @endif
        </div>

        {{-- Slow Moving --}}
        <div class="dash-box">
            <div class="dash-box-header">
                <div>
                    <div class="dash-box-title">Slow-Moving Bunga</div>
                    <div class="dash-box-sub">Bunga dengan penjualan paling lambat</div>
                </div>
            </div>
            @forelse($slowMovingData ?? [] as $item)
            <div class="slow-item">
                <div style="flex:1">
                    <div class="slow-name">{{ $item['nama'] }}</div>
                    <div class="slow-rate">{{ $item['rate'] }}</div>
                </div>
                <span class="slow-badge badge-{{ $item['level'] }}">{{ $item['label'] }}</span>
            </div>
            @empty
            <div class="fp-prediction-empty">
                <p>Tidak ada data slow-moving</p>
                <span>Upload dataset terlebih dahulu</span>
            </div>
            @endforelse
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const labels = @json($labels ?? []);
const values = @json($values ?? []);

if (document.getElementById('chart') && values.length > 0) {
    new Chart(document.getElementById('chart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                borderColor: '#e85d75',
                borderWidth: 2,
                tension: 0.4,
                pointRadius: 3,
                pointBackgroundColor: '#e85d75',
                backgroundColor: 'rgba(232,93,117,0.05)',
                fill: true
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    grid: { color: '#f1eef3' },
                    ticks: { font: { family: 'DM Mono', size: 11 }, color: '#a1a1b5' }
                },
                x: {
                    grid: { color: '#f1eef3' },
                    ticks: { font: { family: 'DM Mono', size: 11 }, color: '#a1a1b5' }
                }
            }
        }
    });
}
</script>

</x-app-layout>