<x-app-layout>

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap');

*{font-family:'Plus Jakarta Sans',sans-serif}

.fp-eyebrow { font-size:.68rem;font-weight:700;letter-spacing:.16em;text-transform:uppercase;background:linear-gradient(135deg,#c0253a,#e85d75);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;margin-bottom:.3rem; }
.fp-title { font-size:1.7rem;font-weight:700;color:#1a1a2e; }
.fp-header { margin-bottom:1.75rem; }
.fp-inner { max-width:1100px;margin:0 auto;padding:30px 20px; }

.fp-alert-banner { display:flex;align-items:center;gap:.75rem;padding:.85rem 1.1rem;border-radius:14px;font-size:.84rem;font-weight:500;margin-bottom:1.5rem; }
.fp-alert-warn  { background:#fff7ed;border:1px solid #fed7aa;color:#9a3412; }
.fp-alert-info  { background:#eff6ff;border:1px solid #bfdbfe;color:#1e40af; }
.fp-alert-none  { background:#f0fdf4;border:1px solid #bbf7d0;color:#166534; }

.dash-grid { display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:20px; }

.dash-card { background:#fff;border-radius:18px;padding:20px;border:1px solid #f5e4e8;box-shadow:0 2px 14px rgba(232,93,117,.07); }

.dash-card small { font-size:.68rem;color:#b0a0b0;text-transform:uppercase;letter-spacing:.09em;font-weight:700; }

.dash-card h2 { font-size:2rem;margin:8px 0 0;font-family:'DM Mono',monospace;color:#1a1a2e;font-weight:500; }

.dash-card h2.rose { background:linear-gradient(135deg,#c0253a,#e85d75);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text; }

.dash-card-sub { font-size:.72rem;color:#b0a0b0;margin-top:4px; }

.dash-box { background:#fff;border-radius:18px;padding:20px;border:1px solid #f5e4e8;margin-bottom:16px;box-shadow:0 2px 14px rgba(232,93,117,.07); }

.dash-box-header { display:flex;align-items:center;justify-content:space-between;margin-bottom:16px; }

.dash-box-title { font-size:.875rem;font-weight:700;color:#1a1a2e; }

.dash-box-sub { font-size:.72rem;color:#b0a0b0;margin-top:2px; }

.dash-two-col { display:grid;grid-template-columns:1.5fr 1fr;gap:16px;margin-bottom:16px; }

canvas { max-height:220px; }

.fp-prediction-empty { display:flex;flex-direction:column;align-items:center;justify-content:center;padding:2.5rem 1rem;text-align:center;color:#c0b0c0; }

.fp-prediction-empty p { font-size:.84rem; }

.stats-row { display:grid;grid-template-columns:repeat(2,1fr);gap:10px;margin-top:12px; }

.stat-item { background:#faf7f8;border-radius:12px;padding:14px 16px;border:1px solid #f5e0e5; }

.stat-label { font-size:.68rem;color:#b0a0b0;font-weight:700;text-transform:uppercase; }

.stat-val { font-size:1.15rem;font-weight:700;color:#1a1a2e;font-family:'DM Mono',monospace;margin-top:5px; }

.stat-val.rose { color:#e11d48; }

</style>


<div class="fp-inner">

<div class="fp-header">
<div class="fp-eyebrow">FloraPredict</div>
<h1 class="fp-title">Dashboard</h1>
</div>


@if(isset($warning) && $warning)
<div class="fp-alert-banner fp-alert-warn">
{{ $warning }}
</div>
@elseif(isset($predictionReady) && $predictionReady)
<div class="fp-alert-banner fp-alert-none">
Model prediksi aktif — hasil tersedia untuk periode ke-{{ $nextPeriod }}
</div>
@else
<div class="fp-alert-banner fp-alert-info">
Prediksi belum dijalankan — jalankan model untuk melihat hasil prediksi
</div>
@endif


<div class="dash-grid">

<div class="dash-card">
<small>Total Data</small>
<h2>{{ $totalData }}</h2>
<div class="dash-card-sub">baris dataset tersedia</div>
</div>

<div class="dash-card">
<small>Hasil Prediksi</small>
@if(isset($predictionReady) && $predictionReady)
<h2 class="rose">{{ number_format($prediction) }}</h2>
<div class="dash-card-sub">periode ke-{{ $nextPeriod }}</div>
@else
<h2 style="font-size:1rem;color:#bbb;margin-top:12px">Belum ada</h2>
@endif
</div>

<div class="dash-card">
<small>Periode Prediksi</small>
<h2>ke-{{ $nextPeriod }}</h2>
<div class="dash-card-sub">periode berikutnya</div>
</div>

</div>


<div class="dash-two-col">

<div class="dash-box">

<div class="dash-box-header">
<div>
<div class="dash-box-title">Grafik Penjualan</div>
<div class="dash-box-sub">Tren quantity ordered</div>
</div>
</div>

@if($totalData > 0)
<canvas id="chart"></canvas>
@else
<div class="fp-prediction-empty">
<p>Belum ada data grafik</p>
</div>
@endif

</div>


<div class="dash-box">

<div class="dash-box-header">
<div>
<div class="dash-box-title">Statistik Model</div>
<div class="dash-box-sub">Error prediksi terakhir</div>
</div>
</div>

@if(isset($predictionReady) && $predictionReady)

<div class="stats-row">

<div class="stat-item">
<div class="stat-label">MAE</div>
<div class="stat-val rose">{{ number_format($mae,2) }}</div>
</div>

<div class="stat-item">
<div class="stat-label">RMSE</div>
<div class="stat-val rose">{{ number_format($rmse,2) }}</div>
</div>

<div class="stat-item">
<div class="stat-label">Total Data</div>
<div class="stat-val">{{ $totalData }}</div>
</div>

<div class="stat-item">
<div class="stat-label">Periode</div>
<div class="stat-val">ke-{{ $nextPeriod }}</div>
</div>

</div>

@else

<div class="fp-prediction-empty">
<p>Model belum dijalankan</p>
</div>

@endif

</div>

</div>

</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const labels = @json($labels ?? []);
const values = @json($values ?? []);

if(document.getElementById('chart') && values.length>0){

new Chart(document.getElementById('chart'),{

type:'line',

data:{
labels:labels,
datasets:[{
data:values,
borderColor:'#e85d75',
borderWidth:2.5,
tension:0.4,
pointRadius:3,
pointBackgroundColor:'#e85d75',
fill:false
}]
},

options:{
plugins:{legend:{display:false}},
responsive:true
}

});

}

</script>

</x-app-layout>