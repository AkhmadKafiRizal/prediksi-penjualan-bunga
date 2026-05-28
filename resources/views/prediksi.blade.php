<x-app-layout>

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap');
*{box-sizing:border-box;margin:0;padding:0}

:root{
    --pk1:#E8185A;--pk2:#F04E8A;--pk3:#F87FB5;--pk4:#FDB8D4;--pk5:#FDE8F2;--pk6:#FFF2F8;
    --dark:#1A0A12;--muted:#9A7A8A;--border:#FCE4EF;--surface:#fff;
}

/* ══════════════════════════════════════════
   WRAPPER UTAMA — kunci layout tidak berubah
   ══════════════════════════════════════════ */
.pr-wrapper {
    min-width: 1080px;
    width: 100%;
}

.pr-header{margin-bottom:20px}
.pr-eyebrow{font-size:10px;font-weight:700;letter-spacing:.16em;text-transform:uppercase;color:var(--pk1);margin-bottom:4px}
.pr-title{font-size:24px;font-weight:800;color:var(--dark);line-height:1;margin-bottom:4px}
.pr-subtitle{font-size:12px;color:var(--muted)}

/* ── Filter bar — nowrap agar tidak pindah baris ── */
.pr-filterbar{
    display:flex;
    align-items:center;
    gap:10px;
    margin-bottom:16px;
    flex-wrap:nowrap;   /* ← KUNCI: tidak boleh wrap */
    min-width:0;
}
.pr-filter-group{display:flex;flex-direction:column;gap:3px;flex-shrink:0}
.pr-filter-label{font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:var(--muted)}
.pr-filter-select{padding:7px 12px;border:1px solid var(--border);border-radius:10px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600;color:var(--dark);background:var(--pk6);cursor:pointer;outline:none;transition:border .15s}
.pr-filter-select:focus{border-color:var(--pk2)}
.pr-model-tag{display:inline-flex;align-items:center;gap:6px;background:var(--pk5);border:1px solid var(--border);border-radius:8px;padding:5px 12px;font-size:11px;font-weight:700;color:var(--pk1)}
.pr-model-dot{width:7px;height:7px;border-radius:50%;background:var(--pk1);box-shadow:0 0 0 2px rgba(232,24,90,.2)}
.pr-last-run{font-size:10px;color:var(--muted);margin-left:auto;flex-shrink:0}

/* ── Alert ── */
.pr-alert{border-radius:12px;padding:10px 14px;font-size:12.5px;display:flex;align-items:center;gap:9px;margin-bottom:16px}
.pr-alert.ok{background:var(--pk6);border:1px solid var(--border);color:#7A1A3A}
.pr-alert.warn{background:#FFF8E6;border:1px solid #FFE0A0;color:#7A5A00}
.pr-alert.success{background:#ECFDF5;border:1px solid #6EE7B7;color:#065F46}
.pr-alert.error{background:#FEF2F2;border:1px solid #FCA5A5;color:#991B1B}

/* ══════════════════════════════════════════
   5 EVAL CARDS — selalu 5 kolom, tidak collapse
   ══════════════════════════════════════════ */
.pr-evalrow{
    display:grid;
    grid-template-columns:repeat(5, minmax(0, 1fr));  /* ← fixed 5 kolom */
    gap:10px;
    margin-bottom:18px;
}
.pr-eval{background:var(--surface);border:1px solid var(--border);border-radius:13px;padding:14px 16px;min-width:0}
.pr-eval-lbl{font-size:9.5px;color:var(--muted);text-transform:uppercase;letter-spacing:.3px;font-weight:600;margin-bottom:6px}
.pr-eval-val{font-size:22px;font-weight:800;color:var(--dark);font-family:'DM Mono',monospace;line-height:1}
.pr-eval-val.rose{color:var(--pk1)}
.pr-eval-sub{font-size:10px;color:var(--muted);margin-top:4px}
.pr-eval-bar{height:4px;background:#FFF0F6;border-radius:2px;margin-top:8px;overflow:hidden}
.pr-eval-bar-fill{height:100%;border-radius:2px;background:linear-gradient(90deg,var(--pk1),var(--pk3))}

/* ── Hero generate ── */
.pr-hero{background:var(--surface);border:1px solid var(--border);border-radius:16px;padding:20px 24px;margin-bottom:16px;display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;position:relative;overflow:hidden}
.pr-hero::before{content:'';position:absolute;right:-20px;top:-20px;width:160px;height:160px;border-radius:50%;background:var(--pk6);z-index:0}
.pr-hero-left{position:relative;z-index:1;flex:1}
.pr-hero-label{font-size:9.5px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--pk3);margin-bottom:6px}
.pr-hero-title{font-size:16px;font-weight:800;color:var(--dark);margin-bottom:5px}
.pr-hero-desc{font-size:12.5px;color:var(--muted);line-height:1.6}
.pr-period-tag{display:inline-flex;align-items:center;gap:5px;background:var(--pk5);border:1px solid var(--border);border-radius:7px;padding:5px 10px;font-size:11px;font-weight:700;color:var(--pk1);margin-top:8px}
.pr-btn{display:inline-flex;align-items:center;gap:7px;padding:11px 20px;background:var(--pk1);color:#fff;border:none;border-radius:10px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;text-decoration:none;transition:all .2s;position:relative;z-index:1;box-shadow:0 4px 16px rgba(232,24,90,.3);white-space:nowrap;flex-shrink:0}
.pr-btn:hover{background:var(--pk2);transform:translateY(-2px)}

/* ══════════════════════════════════════════
   MAIN GRID — kolom kiri lebih lebar, fixed
   ══════════════════════════════════════════ */
.pr-main{
    display:grid;
    grid-template-columns: minmax(580px, 1.7fr) minmax(280px, 1fr);
    gap:12px;
    margin-bottom:12px;
}

/* ══════════════════════════════════════════
   BOTTOM GRID — fixed 2 kolom
   ══════════════════════════════════════════ */
.pr-bottom{
    display:grid;
    grid-template-columns: minmax(380px, 1fr) minmax(240px, 0.65fr);
    gap:12px;
}

/* ── Section ── */
.pr-sec{background:var(--surface);border:1px solid var(--border);border-radius:14px;overflow:hidden;min-width:0}
.pr-sec-head{padding:12px 16px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px}
.pr-sec-title{font-size:12.5px;font-weight:700;color:var(--dark)}
.pr-sec-sub{font-size:10.5px;color:var(--muted);margin-top:2px}
.pr-badge{display:inline-flex;align-items:center;gap:5px;background:var(--pk5);color:var(--pk1);font-size:10px;font-weight:700;border-radius:7px;padding:3px 9px;border:1px solid var(--border)}

/* Search */
.pr-search-wrap{position:relative;display:flex;align-items:center}
.pr-search-wrap input{padding:6px 10px 6px 30px;border:1px solid var(--border);border-radius:8px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;color:var(--dark);background:var(--pk6);outline:none;width:180px;transition:all .15s}
.pr-search-wrap input:focus{border-color:var(--pk2);background:#fff;width:220px}
.pr-search-wrap svg{position:absolute;left:8px;pointer-events:none}

/* Tables */
.pr-tbl{width:100%;border-collapse:collapse;font-size:12px;table-layout:fixed}
.pr-tbl th{text-align:left;color:var(--muted);font-size:9.5px;font-weight:700;padding:0 10px 9px;border-bottom:1px solid var(--border);background:var(--pk6);text-transform:uppercase;letter-spacing:.3px;white-space:nowrap}
.pr-tbl td{padding:8px 10px;border-bottom:1px solid #FFF0F6;color:#4A2A3A;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.pr-tbl tr:last-child td{border-bottom:none}
.pr-tbl tbody tr:hover td{background:var(--pk6)}
.pr-pill{display:inline-flex;align-items:center;gap:3px;background:var(--pk5);border:1px solid var(--border);border-radius:6px;padding:2px 8px;font-weight:700;color:var(--pk1);font-family:'DM Mono',monospace;font-size:11px}
.pr-scroll{max-height:380px;overflow:auto}
.pr-detail-scroll{max-height:none;overflow-x:auto;overflow-y:hidden}
.pr-row-num{font-variant-numeric:tabular-nums;white-space:nowrap}

/* Top 10 */
.pr-rank{width:24px;height:24px;border-radius:7px;display:inline-flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;color:#fff}
.pr-rank.r1{background:var(--pk1)}.pr-rank.r2{background:var(--pk2)}.pr-rank.r3{background:var(--pk3);color:#7A1A3A}.pr-rank.rx{background:var(--pk5);color:var(--pk1)}
.pr-bar-wrap{width:80px;height:6px;background:#FFF0F6;border-radius:3px;overflow:hidden;display:inline-block;vertical-align:middle}
.pr-bar-fill{height:100%;border-radius:3px;background:linear-gradient(90deg,var(--pk1),var(--pk3))}

/* Distribusi */
.pr-dist-row{display:flex;align-items:center;gap:8px;padding:7px 0;border-bottom:1px solid #FFF0F6}
.pr-dist-row:last-child{border-bottom:none}
.pr-dist-name{flex:1;font-size:11.5px;color:var(--dark);font-weight:500;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.pr-dist-pct{font-size:10px;font-weight:700;color:var(--muted);font-family:'DM Mono',monospace;width:34px;text-align:right;flex-shrink:0}
.pr-dist-bar{flex:1;height:5px;background:#FFF0F6;border-radius:3px;overflow:hidden;max-width:90px}
.pr-dist-bar-fill{height:100%;border-radius:3px;background:linear-gradient(90deg,var(--pk1),var(--pk3))}

.pr-empty{text-align:center;padding:28px 16px;color:var(--muted);font-size:11.5px}
.pr-export-btn{display:inline-flex;align-items:center;gap:5px;padding:5px 12px;background:var(--pk6);border:1px solid var(--border);border-radius:8px;font-size:10.5px;font-weight:700;color:var(--pk1);text-decoration:none;cursor:pointer;transition:all .15s}
.pr-export-btn:hover{background:var(--pk5)}

.pr-vs-tbl{width:100%;border-collapse:collapse;font-size:12px}
.pr-vs-tbl th{text-align:left;color:var(--muted);font-size:9.5px;font-weight:700;padding:0 10px 9px;border-bottom:1px solid var(--border);background:var(--pk6);text-transform:uppercase;letter-spacing:.3px;white-space:nowrap}
.pr-vs-tbl td{padding:8px 10px;border-bottom:1px solid #FFF0F6;color:#4A2A3A;white-space:nowrap}
.pr-vs-tbl tr:last-child td{border-bottom:none}
.pr-vs-tbl tbody tr:hover td{background:var(--pk6)}

/* ══════════════════════════════════════════
   HAPUS SEMUA MEDIA QUERY YANG BIKIN COLLAPSE
   Layout selalu tetap — scroll horizontal jika layar kecil
   ══════════════════════════════════════════ */
@media(max-width:1100px){
    .pr-evalrow{ grid-template-columns:repeat(5, minmax(0,1fr)) }
    .pr-main{ grid-template-columns: minmax(580px,1.7fr) minmax(280px,1fr) }
    .pr-bottom{ grid-template-columns: minmax(380px,1fr) minmax(240px,0.65fr) }
}
</style>

{{-- ══ WRAPPER UTAMA — min-width 1080px, layout tidak berubah ══ --}}
<div class="pr-wrapper">

    {{-- Header --}}
    <div class="pr-header">
        <div class="pr-eyebrow">FloraPredict · Machine Learning</div>
        <div class="pr-title">Prediksi</div>
        <div class="pr-subtitle">Hasil estimasi penjualan dan stok untuk periode selanjutnya</div>
    </div>

    {{-- Session alerts --}}
    @if(session('success'))
        <div class="pr-alert success">✔ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="pr-alert error">⚠ {{ session('error') }}</div>
    @endif

    {{-- Filter bar --}}
    <div class="pr-filterbar">
        <div class="pr-filter-group">
            <div class="pr-filter-label">Pilih Periode Prediksi</div>
            <select class="pr-filter-select" name="periode"
                onchange="window.location.href='{{ route('prediksi') }}?periode=' + this.value">
                @php
                    $activePeriod = $selectedPeriod ?? null;
                    try {
                        $basePeriod = $activePeriod
                            ? \Carbon\Carbon::createFromFormat('Y-m-d', $activePeriod . '-01')->startOfMonth()
                            : now()->startOfMonth();
                    } catch (\Exception $e) {
                        $basePeriod = now()->startOfMonth();
                    }
                    $months = [];
                    for ($i = 0; $i < 12; $i++) {
                        $m = $basePeriod->copy()->addMonths($i);
                        $months[] = [
                            'value' => $m->format('Y-m'),
                            'label' => $m->translatedFormat('F Y'),
                        ];
                    }
                @endphp
                @foreach($months as $m)
                    <option value="{{ $m['value'] }}" {{ $m['value'] === $basePeriod->format('Y-m') ? 'selected' : '' }}>
                        {{ $m['label'] }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="pr-filter-group">
            <div class="pr-filter-label">Model Aktif</div>
            <div style="display:inline-flex;align-items:center;gap:8px;padding:7px 14px;background:var(--pk5);border:1px solid var(--border);border-radius:10px;flex-shrink:0">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--pk1)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/>
                </svg>
                <span style="font-size:12px;font-weight:700;color:var(--pk1)">Multioutput Regression</span>
            </div>
        </div>

        @if(isset($predictionReady) && $predictionReady)
            <div style="align-self:flex-end;flex-shrink:0">
                <div class="pr-filter-label">Status</div>
                <div class="pr-model-tag">
                    <div class="pr-model-dot"></div>
                    Model Aktif
                </div>
            </div>
            <div style="align-self:flex-end;font-size:10px;color:var(--muted);flex-shrink:0">
                Terakhir Diperbarui<br>
                <strong style="color:var(--dark)">{{ $lastRunAt ?? now()->format('d M Y, H:i') }} WIB</strong>
            </div>
        @endif

        <div style="align-self:flex-end;flex-shrink:0">
            @if(isset($predictionReady) && $predictionReady)
                <a href="{{ route('predictions.generate', ['periode' => $selectedPeriod]) }}"
                   class="pr-btn"
                   style="background:#B45309;box-shadow:0 4px 16px rgba(180,83,9,.25)"
                   onclick="return confirm('⚠️ Prediksi {{ $nextMonthLabel }} sudah tersedia.\n\nGenerate ulang akan mengganti data prediksi yang ada dengan hasil terbaru.\n\nYakin ingin melanjutkan?')">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="23 4 23 10 17 10"/>
                        <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
                    </svg>
                    Generate Ulang
                </a>
            @else
                <a href="{{ route('predictions.generate', ['periode' => $selectedPeriod]) }}"
                   class="pr-btn"
                   onclick="return confirm('Generate prediksi akan menjalankan model Machine Learning berdasarkan data terbaru.\n\nLanjutkan?')">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="5 3 19 12 5 21 5 3"/>
                    </svg>
                    Generate Prediksi Baru
                </a>
            @endif
        </div>
    </div>

    {{-- 5 Kartu Evaluasi Model --}}
    @if(isset($predictionReady) && $predictionReady)
    <div class="pr-evalrow">
        <div class="pr-eval">
            <div class="pr-eval-lbl">Total Produk Diprediksi</div>
            <div class="pr-eval-val rose">{{ number_format($totalProducts ?? 0) }}</div>
            <div class="pr-eval-sub">jenis bunga</div>
        </div>
        <div class="pr-eval">
            <div class="pr-eval-lbl">Total Prediksi</div>
            <div class="pr-eval-val rose">{{ number_format($prediction ?? 0) }}</div>
            <div class="pr-eval-sub">tangkai</div>
        </div>
        <div class="pr-eval">
            <div class="pr-eval-lbl">Rata-rata MAE</div>
            <div class="pr-eval-val">{{ number_format($mae ?? 0, 2) }}</div>
            <div class="pr-eval-sub">mean absolute error</div>
            <div class="pr-eval-bar"><div class="pr-eval-bar-fill" style="width:{{ min(100, (($mae ?? 0)/500)*100) }}%"></div></div>
        </div>
        <div class="pr-eval">
            <div class="pr-eval-lbl">Rata-rata RMSE</div>
            <div class="pr-eval-val">{{ number_format($rmse ?? 0, 2) }}</div>
            <div class="pr-eval-sub">root mean square error</div>
            <div class="pr-eval-bar"><div class="pr-eval-bar-fill" style="width:{{ min(100, (($rmse ?? 0)/700)*100) }}%"></div></div>
        </div>
        <div class="pr-eval">
            <div class="pr-eval-lbl">Akurasi Model</div>
            @php $accuracy = $modelAccuracy ?? null; @endphp
            <div class="pr-eval-val rose">{{ $accuracy !== null ? number_format($accuracy, 1) . '%' : '-' }}</div>
            <div class="pr-eval-sub">rata-rata akurasi per produk</div>
            <div class="pr-eval-bar"><div class="pr-eval-bar-fill" style="width:{{ $accuracy !== null ? min(100, max(0, $accuracy)) : 0 }}%"></div></div>
        </div>
    </div>

    <div class="pr-alert ok">
        ✦ Model prediksi aktif — estimasi kebutuhan bunga untuk <strong style="color:var(--pk1)">{{ $nextMonthLabel }}</strong> tersedia
    </div>
    @else
    <div class="pr-alert warn">
        ⚠ Prediksi belum dijalankan — klik tombol <strong>Generate Prediksi Baru</strong> di atas untuk memulai
    </div>
    @endif

    {{-- Main: Tabel Detail + Top 10 --}}
    <div class="pr-main">
        {{-- Tabel Detail --}}
        <div class="pr-sec">
            <div class="pr-sec-head">
                <div>
                    <div class="pr-sec-title">Hasil Prediksi per Produk</div>
                    <div class="pr-sec-sub">Estimasi tangkai per jenis bunga — {{ $nextMonthLabel ?? 'bulan depan' }}</div>
                </div>
                <div style="display:flex;gap:7px;align-items:center;flex-wrap:wrap">
                    <div class="pr-search-wrap">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#CCA8BA" stroke-width="2.5" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" placeholder="Cari produk..." id="pr-search-input" oninput="filterTable(this.value)">
                    </div>
                    <a href="{{ route('predictions.export') }}" class="pr-export-btn">⬇ Export</a>
                    <span class="pr-badge">{{ number_format($totalProducts ?? 0) }} produk</span>
                </div>
            </div>
            <div class="pr-scroll pr-detail-scroll">
                <table class="pr-tbl" id="pr-detail-tbl">
                    <colgroup>
                        <col style="width:48px">
                        <col>
                        <col style="width:130px">
                        <col style="width:130px">
                        <col style="width:70px">
                        <col style="width:70px">
                        <col style="width:75px">
                        <col style="width:78px">
                    </colgroup>
                    <thead>
                        <tr>
                            <th style="padding-left:12px">#</th>
                            <th>Nama Bunga</th>
                            <th>Kategori</th>
                            <th>Prediksi (tangkai)</th>
                            <th>MAE</th>
                            <th>RMSE</th>
                            <th>Akurasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productPredictions ?? [] as $item)
                            @php
                                $accuracy = isset($item['mae']) && $item['prediction'] > 0
                                    ? max(0, 100 - (($item['mae'] / $item['prediction']) * 100))
                                    : null;
                                $accColor = $accuracy >= 80 ? '#065F46' : ($accuracy >= 60 ? '#B45309' : 'var(--pk1)');
                            @endphp
                            <tr data-detail-row data-row-index="{{ $loop->iteration }}">
                                <td class="pr-row-num" style="padding-left:12px;color:var(--muted);font-size:10.5px">{{ $loop->iteration }}</td>
                                <td style="font-weight:600;color:var(--dark)">{{ $item['product_name'] }}</td>
                                <td style="color:var(--muted);font-size:11px">{{ $item['category'] ?? 'Bunga Potong' }}</td>
                                <td><span class="pr-pill">✦ {{ number_format($item['prediction']) }}</span></td>
                                <td style="color:#7A4060;font-family:'DM Mono',monospace;font-size:11px">{{ number_format($item['mae'] ?? 0, 2) }}</td>
                                <td style="color:#7A4060;font-family:'DM Mono',monospace;font-size:11px">{{ number_format($item['rmse'] ?? 0, 2) }}</td>
                                <td>
                                    @if($accuracy !== null)
                                        <span style="font-size:11px;font-weight:700;color:{{ $accColor }}">{{ number_format($accuracy, 0) }}%</span>
                                    @else
                                        <span style="color:var(--muted);font-size:11px">—</span>
                                    @endif
                                </td>
                                <td>
                                    <button style="min-width:54px;background:var(--pk5);border:1px solid var(--border);border-radius:6px;padding:3px 8px;font-size:10px;font-weight:700;color:var(--pk1);cursor:pointer">Detail</button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8"><div class="pr-empty">Belum ada data prediksi — jalankan Generate Prediksi terlebih dahulu</div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 14px;border-top:1px solid var(--border)">
                <span id="pr-page-info" style="font-size:10.5px;color:var(--muted)">
                    Menampilkan <strong>1 – {{ min(10, count($productPredictions ?? [])) }}</strong> dari <strong>{{ count($productPredictions ?? []) }}</strong>
                </span>
                <div style="display:flex;gap:4px">
                    @for($p = 1; $p <= max(1, ceil(count($productPredictions ?? []) / 10)); $p++)
                        <button type="button" onclick="gotoPage({{ $p }})" id="page-btn-{{ $p }}" class="pr-page-btn" data-page="{{ $p }}"
                            style="width:26px;height:26px;border-radius:6px;border:1px solid var(--border);background:{{ $p === 1 ? 'var(--pk1)' : 'var(--pk6)' }};color:{{ $p === 1 ? '#fff' : 'var(--pk1)' }};font-size:10.5px;font-weight:700;cursor:pointer">
                            {{ $p }}
                        </button>
                    @endfor
                    @if(ceil(count($productPredictions ?? []) / 10) > 5)
                        <button style="width:26px;height:26px;border-radius:6px;border:1px solid var(--border);background:var(--pk6);color:var(--muted);font-size:10.5px;cursor:pointer">…</button>
                        <button onclick="gotoPage({{ ceil(count($productPredictions ?? []) / 10) }})"
                            style="width:26px;height:26px;border-radius:6px;border:1px solid var(--border);background:var(--pk6);color:var(--pk1);font-size:10.5px;font-weight:700;cursor:pointer">
                            {{ ceil(count($productPredictions ?? []) / 10) }}
                        </button>
                    @endif
                </div>
            </div>
        </div>

        {{-- Top 10 --}}
        <div class="pr-sec">
            <div class="pr-sec-head">
                <div>
                    <div class="pr-sec-title">Top 10 Kebutuhan Tertinggi</div>
                    <div class="pr-sec-sub">Prioritas pengadaan stok</div>
                </div>
                @if(isset($nextMonthLabel))
                    <span class="pr-badge">{{ $nextMonthLabel }}</span>
                @endif
            </div>
            @if(isset($topBars) && count($topBars) > 0)
                <table style="width:100%;border-collapse:collapse;font-size:12px" id="pr-top10-tbl"></table>
            @else
                <div class="pr-empty">Belum ada data<br>Jalankan Generate Prediksi dulu</div>
            @endif
        </div>
    </div>

    {{-- Bottom: Prediksi vs Real + Distribusi --}}
    <div class="pr-bottom">
        <div class="pr-sec">
            <div class="pr-sec-head">
                <div>
                    <div class="pr-sec-title">Prediksi vs Penjualan Real</div>
                    <div class="pr-sec-sub">Perbandingan nilai prediksi dengan aktual historis</div>
                </div>
            </div>
            <div class="pr-scroll" style="max-height:300px">
                <table class="pr-vs-tbl">
                    <thead>
                        <tr>
                            <th style="padding-left:12px">Tanggal</th>
                            <th>Prediksi</th>
                            <th>Real</th>
                            <th>Error (±)</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($predictionComparison ?? [] as $row)
                            @php $isHigh = ($row->error ?? 0) > 1000; @endphp
                            <tr>
                                <td style="padding-left:12px;font-size:10.5px;color:var(--muted)">{{ $row->tanggal }}</td>
                                <td style="font-family:'DM Mono',monospace;font-size:11px">{{ number_format($row->predicted_sales) }}</td>
                                <td style="font-family:'DM Mono',monospace;font-size:11px">{{ number_format($row->actual_sales ?? 0) }}</td>
                                <td style="color:{{ $isHigh ? 'var(--pk1)' : '#065F46' }};font-weight:700;font-family:'DM Mono',monospace;font-size:11px">{{ number_format($row->error ?? 0) }}</td>
                                <td>
                                    <span style="font-size:10px;padding:2px 7px;border-radius:5px;font-weight:700;background:{{ $isHigh ? 'var(--pk5)' : '#ECFDF5' }};color:{{ $isHigh ? 'var(--pk1)' : '#065F46' }}">
                                        {{ $isHigh ? 'Tinggi' : 'Normal' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5"><div class="pr-empty" style="padding:16px">Belum ada data perbandingan</div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="pr-sec">
            <div class="pr-sec-head">
                <div>
                    <div class="pr-sec-title">Distribusi Kebutuhan</div>
                    <div class="pr-sec-sub">Proporsi stok tiap produk dari total</div>
                </div>
            </div>
            <div style="padding:12px 16px">
                @if(isset($topBars) && $topBars->count() > 0)
                    @php $totalPred = $topBars->sum('prediction') ?: 1; @endphp
                    @foreach($topBars->take(8) as $item)
                        @php $pct = round(($item['prediction'] / $totalPred) * 100, 1); @endphp
                        <div class="pr-dist-row">
                            <span class="pr-dist-name">{{ $item['product_name'] ?? ('Produk #' . $item['product_id']) }}</span>
                            <div class="pr-dist-bar"><div class="pr-dist-bar-fill" style="width:{{ min(100, $pct * 3) }}%"></div></div>
                            <span class="pr-dist-pct">{{ $pct }}%</span>
                        </div>
                    @endforeach
                    <div style="margin-top:12px;padding:10px;background:var(--pk6);border:1px solid var(--border);border-radius:9px;text-align:center">
                        <div style="font-size:9.5px;color:var(--muted);text-transform:uppercase;letter-spacing:.3px;margin-bottom:3px">Total Estimasi</div>
                        <div style="font-size:20px;font-weight:800;color:var(--pk1);font-family:'DM Mono',monospace">{{ number_format($prediction ?? 0) }}</div>
                        <div style="font-size:10px;color:var(--muted);margin-top:2px">tangkai semua produk</div>
                    </div>
                @else
                    <div class="pr-empty">Belum ada data distribusi</div>
                @endif
            </div>
        </div>
    </div>

</div>{{-- end .pr-wrapper --}}

<script>
const topBars = @json($topBars ?? []);
const tblEl = document.getElementById('pr-top10-tbl');

if (tblEl && topBars.length > 0) {
    const maxVal = Math.max(...topBars.map(i => i.prediction || 0));
    let html = `<thead><tr style="background:var(--pk6)">
        <th style="width:34px;padding:0 10px 8px 12px;text-align:left;font-size:9.5px;font-weight:700;color:var(--muted);text-transform:uppercase;border-bottom:1px solid var(--border)">#</th>
        <th style="padding:0 10px 8px;text-align:left;font-size:9.5px;font-weight:700;color:var(--muted);text-transform:uppercase;border-bottom:1px solid var(--border)">Produk</th>
        <th style="width:110px;padding:0 10px 8px;text-align:left;font-size:9.5px;font-weight:700;color:var(--muted);text-transform:uppercase;border-bottom:1px solid var(--border)">Prediksi</th>
        <th style="width:100px;padding:0 10px 8px;text-align:left;font-size:9.5px;font-weight:700;color:var(--muted);text-transform:uppercase;border-bottom:1px solid var(--border)">Proporsi</th>
    </tr></thead><tbody>`;

    topBars.forEach((item, idx) => {
        const rank = idx + 1;
        const name = item.product_name ?? ('Produk #' + item.product_id);
        const val  = item.prediction ?? 0;
        const pct  = maxVal > 0 ? Math.round((val / maxVal) * 100) : 0;
        const rc   = rank === 1 ? 'r1' : rank === 2 ? 'r2' : rank === 3 ? 'r3' : 'rx';

        html += `<tr style="border-bottom:1px solid #FFF0F6">
            <td style="padding:8px 10px 8px 12px"><span class="pr-rank ${rc}">${rank}</span></td>
            <td style="padding:8px 10px;font-weight:600;color:var(--dark);font-size:12px;max-width:130px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">${name}</td>
            <td style="padding:8px 10px"><span class="pr-pill">✦ ${val.toLocaleString('id-ID')}</span></td>
            <td style="padding:8px 10px">
                <div style="display:flex;align-items:center;gap:5px">
                    <div class="pr-bar-wrap"><div class="pr-bar-fill" style="width:${pct}%"></div></div>
                    <span style="font-size:10px;color:var(--muted);font-family:'DM Mono',monospace">${pct}%</span>
                </div>
            </td>
        </tr>`;
    });
    html += '</tbody>';
    tblEl.innerHTML = html;
}

const detailPageSize = 10;
let detailSearchQuery = '';
let detailCurrentPage = 1;

function getDetailRows() {
    return Array.from(document.querySelectorAll('#pr-detail-tbl tbody tr[data-detail-row]'));
}

function getFilteredDetailRows() {
    const query = detailSearchQuery.trim().toLowerCase();
    return getDetailRows().filter(row => !query || row.textContent.toLowerCase().includes(query));
}

function updateDetailPagination(filteredCount, totalPages, startIndex, endIndex) {
    const info = document.getElementById('pr-page-info');
    if (info) {
        const shownStart = filteredCount === 0 ? 0 : startIndex + 1;
        const shownEnd = Math.min(endIndex, filteredCount);
        info.innerHTML = `Menampilkan <strong>${shownStart} – ${shownEnd}</strong> dari <strong>${filteredCount}</strong>`;
    }

    document.querySelectorAll('.pr-page-btn').forEach(btn => {
        const page = Number(btn.dataset.page);
        const isActive = page === detailCurrentPage;
        btn.style.display = page <= totalPages ? '' : 'none';
        btn.style.background = isActive ? 'var(--pk1)' : 'var(--pk6)';
        btn.style.color = isActive ? '#fff' : 'var(--pk1)';
    });
}

function renderDetailPage(page = 1) {
    const rows = getDetailRows();
    const filteredRows = getFilteredDetailRows();
    const totalPages = Math.max(1, Math.ceil(filteredRows.length / detailPageSize));
    detailCurrentPage = Math.min(Math.max(1, page), totalPages);

    const startIndex = (detailCurrentPage - 1) * detailPageSize;
    const endIndex = startIndex + detailPageSize;

    rows.forEach(row => {
        row.style.display = 'none';
    });

    filteredRows.forEach((row, filteredIndex) => {
        if (filteredIndex >= startIndex && filteredIndex < endIndex) {
            row.style.display = '';
        }
    });

    updateDetailPagination(filteredRows.length, totalPages, startIndex, endIndex);
    document.querySelector('#pr-detail-tbl')?.closest('.pr-scroll')?.scrollTo({ top: 0, left: 0 });
}

function filterTable(q) {
    detailSearchQuery = q;
    renderDetailPage(1);
}

function gotoPage(p) {
    renderDetailPage(Number(p));
}

renderDetailPage(1);
</script>

</x-app-layout>
