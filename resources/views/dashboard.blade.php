<x-app-layout>

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&family=Playfair+Display:ital,wght@0,700;1,600&display=swap');

.db-wrap * { font-family: 'Plus Jakarta Sans', sans-serif; }

.db-wrap {
    max-width: 1160px;
    margin: 0 auto;
    padding: 2.5rem 1.5rem 5rem;
}

/* HERO */
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
    right: -10px;
    bottom: -40px;
    opacity: 0.06;
    transform: rotate(-15deg);
}

.db-hero-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.95rem;
    font-weight: 700;
    color: #fff;
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

.hb-label {
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    color: #fda4af;
}

.hb-value {
    font-family: 'DM Mono', monospace;
    font-size: 2.8rem;
    font-weight: 700;
    color: #fff;
}

.hb-sub {
    font-size: 0.73rem;
    color: rgba(255,255,255,0.4);
}

/* STATS */
.db-stats {
    display: grid;
    grid-template-columns: repeat(3,1fr);
    gap:1rem;
    margin-bottom:1.5rem;
}

.db-stat {
    background:#fff;
    border-radius:18px;
    border:1px solid #f5e8eb;
    padding:1.4rem;
}

/* BOTTOM GRID */
.db-bottom {
    display:grid;
    grid-template-columns:320px 1fr;
    gap:1.25rem;
}

/* METRICS */
.db-metrics {
    background:#fff;
    border-radius:18px;
    border:1px solid #f5e8eb;
    padding:1.5rem;
}

.db-metric-row {
    background:#faf7f5;
    border:1px solid #f0e8ec;
    border-radius:12px;
    padding:1rem;
    display:flex;
    justify-content:space-between;
    margin-bottom:0.7rem;
}

.db-metric-val {
    font-family:'DM Mono',monospace;
    font-size:1.5rem;
    font-weight:700;
}

/* CHART */
.db-chart {
    background:#fff;
    border-radius:18px;
    border:1px solid #f5e8eb;
    padding:1.5rem;
}

/* TABLE PREDICTION */
.db-compare {
    margin-top:1.5rem;
    background:#fff;
    border-radius:18px;
    border:1px solid #f5e8eb;
    padding:1.5rem;
}

.db-table {
    width:100%;
    border-collapse:collapse;
}

.db-table th {
    text-align:left;
    font-size:0.7rem;
    text-transform:uppercase;
    color:#a8a29e;
    padding-bottom:0.6rem;
}

.db-table td {
    padding:0.55rem 0;
    border-top:1px solid #f5ece8;
    font-family:'DM Mono',monospace;
}

</style>

<div class="db-wrap">

<div class="db-hero">

<div>
<h1 class="db-hero-title">Sistem Prediksi Penjualan Bunga</h1>
<p class="db-hero-sub">Ringkasan data dan prediksi terkini</p>
</div>

<div class="db-hero-box">
<div class="hb-label">Prediksi Bulan Berikutnya</div>
<div class="hb-value">{{ number_format($prediction) }}</div>
<div class="hb-sub">bunga · bulan ke-{{ $nextPeriod }}</div>
</div>

</div>


<div class="db-stats">

<div class="db-stat">
Total Dataset<br>
<strong>{{ $totalData }}</strong><br>
Periode {{ $periodeDataset }}
</div>

<div class="db-stat">
Prediksi Qty<br>
<strong>{{ number_format($prediction) }}</strong>
</div>

<div class="db-stat">
Periode Prediksi<br>
<strong>ke-{{ $nextPeriod }}</strong>
</div>

</div>


<div class="db-bottom">

<div class="db-metrics">

<div class="db-metric-row">
<div>
MAE<br>
<small>Mean Absolute Error</small>
</div>
<div class="db-metric-val">{{ $mae }}</div>
</div>

<div class="db-metric-row">
<div>
RMSE<br>
<small>Root Mean Square Error</small>
</div>
<div class="db-metric-val">{{ $rmse }}</div>
</div>

</div>

<div class="db-chart">

<h3>Grafik Penjualan Historis</h3>

<canvas id="salesChart" height="95"></canvas>

</div>

</div>


<div class="db-compare">

<h3>Perbandingan Prediksi vs Real</h3>

<table class="db-table">

<thead>
<tr>
<th>Tanggal</th>
<th>Prediksi</th>
<th>Real</th>
<th>Error</th>
</tr>
</thead>

<tbody>

@forelse($predictionComparison as $row)

<tr>

<td>{{ $row->tanggal }}</td>

<td>{{ number_format($row->predicted_sales) }}</td>

<td>
@if($row->actual_sales)
{{ number_format($row->actual_sales) }}
@else
-
@endif
</td>

<td>
@if($row->actual_sales)
{{ number_format(abs($row->predicted_sales - $row->actual_sales)) }}
@else
-
@endif
</td>

</tr>

@empty

<tr>
<td colspan="4">Belum ada data prediksi</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const labels = @json($labels);
const values = @json($values);
const prediction = {{ $prediction }};

const ctx = document.getElementById('salesChart').getContext('2d');

new Chart(ctx, {

type:'line',

data:{
labels:[...labels,'Prediksi'],

datasets:[

{
label:'Penjualan Bunga',
data:[...values,null],
borderColor:'#f43f5e',
borderWidth:2.5,
tension:0.45
},

{
label:'Prediksi',
data:[...Array(values.length).fill(null),prediction],
borderColor:'#ef4444',
backgroundColor:'#ef4444',
pointRadius:6,
showLine:false
}

]

},

options:{
responsive:true
}

});

</script>

</x-app-layout>