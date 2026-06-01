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
.pr-period-locked{display:inline-flex;align-items:center;min-width:145px;cursor:default}
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

/* Generate confirmation modal */
.pr-generate-modal{display:none;position:fixed;inset:0;z-index:9998;align-items:center;justify-content:center;background:rgba(26,10,18,.46);backdrop-filter:blur(6px);padding:18px}
.pr-generate-modal.is-open{display:flex}
.pr-generate-box{width:100%;max-width:460px;background:#fff;border:1px solid var(--border);border-radius:18px;box-shadow:0 26px 72px rgba(122,26,58,.22);overflow:hidden;animation:prModalIn .18s ease}
.pr-generate-head{display:flex;align-items:center;gap:12px;padding:18px 20px;background:linear-gradient(135deg,#FFF2F8,#FFF8FC);border-bottom:1px solid var(--border)}
.pr-generate-icon{width:42px;height:42px;border-radius:13px;background:linear-gradient(135deg,var(--pk1),var(--pk3));color:#fff;display:flex;align-items:center;justify-content:center;font-size:19px;box-shadow:0 10px 24px rgba(232,24,90,.22);flex-shrink:0}
.pr-generate-title{font-size:15px;font-weight:800;color:var(--dark)}
.pr-generate-sub{font-size:11px;color:var(--muted);margin-top:2px}
.pr-generate-body{padding:18px 20px;color:#6F4056;font-size:12.5px;line-height:1.65}
.pr-generate-note{margin-top:12px;padding:11px 12px;background:var(--pk6);border:1px solid var(--border);border-radius:10px;color:#7A4060;font-size:12px}
.pr-generate-actions{display:flex;justify-content:flex-end;gap:8px;padding:0 20px 18px}
.pr-generate-cancel,.pr-generate-confirm{border:0;border-radius:10px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:800;padding:9px 16px;cursor:pointer;transition:transform .12s ease,box-shadow .12s ease,filter .12s ease}
.pr-generate-cancel{background:#FFF5FA;color:#7A4060;border:1px solid var(--border)}
.pr-generate-cancel:hover{background:var(--pk6);transform:translateY(-1px)}
.pr-generate-confirm{background:linear-gradient(135deg,var(--pk1),var(--pk2));color:#fff;box-shadow:0 8px 18px rgba(232,24,90,.2)}
.pr-generate-confirm:hover{transform:translateY(-1px);filter:brightness(1.03);box-shadow:0 10px 22px rgba(232,24,90,.24)}
.pr-generate-confirm:disabled{opacity:.72;cursor:wait;transform:none}
@keyframes prModalIn{from{opacity:0;transform:translateY(12px) scale(.97)}to{opacity:1;transform:translateY(0) scale(1)}}

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
.pr-detail-head{align-items:flex-start}
.pr-detail-title{padding-top:4px;min-width:260px}
.pr-sec-title{font-size:12.5px;font-weight:700;color:var(--dark)}
.pr-sec-sub{font-size:10.5px;color:var(--muted);margin-top:2px}
.pr-badge{display:inline-flex;align-items:center;gap:5px;background:var(--pk5);color:var(--pk1);font-size:10px;font-weight:700;border-radius:7px;padding:3px 9px;border:1px solid var(--border)}
.pr-table-tools{display:flex;flex-direction:column;align-items:flex-end;gap:7px;min-width:0}
.pr-table-actions{display:flex;gap:7px;align-items:center;justify-content:flex-end;flex-wrap:wrap}
.pr-count-note{display:inline-flex;align-items:center;gap:5px;color:var(--muted);font-size:10.5px;font-weight:700;cursor:default;white-space:nowrap}
.pr-count-note::before{content:"";width:6px;height:6px;border-radius:999px;background:var(--pk3)}
.pr-export-help{display:flex;align-items:center;gap:8px;max-width:560px;padding:6px 9px;background:#FFF8FC;border:1px solid var(--border);border-radius:9px;color:#8E5B73;font-size:10.2px;line-height:1.35;text-align:left}
.pr-export-help-title{font-weight:800;color:var(--pk1);white-space:nowrap}
.pr-export-help-chip{display:inline-flex;align-items:center;gap:4px;background:#fff;border:1px solid #F8C9DA;border-radius:7px;padding:2px 7px;white-space:nowrap}
.pr-export-help-chip strong{color:var(--pk1);font-weight:800}
.pr-export-help-note{display:flex;gap:5px;align-items:center;flex-wrap:wrap}

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
.pr-export-btn{display:inline-flex;align-items:center;gap:6px;padding:8px 14px;background:linear-gradient(135deg,#0EA765,#16C784);border:1px solid #0C9A5D;border-radius:9px;font-size:11px;font-weight:800;color:#fff;text-decoration:none;cursor:pointer;box-shadow:0 8px 16px rgba(14,167,101,.22);transition:all .15s}
.pr-export-btn:hover{transform:translateY(-1px);filter:brightness(1.03);box-shadow:0 10px 20px rgba(14,167,101,.28)}
.pr-export-btn:active{transform:translateY(1px);box-shadow:0 5px 12px rgba(14,167,101,.2)}
.pr-export-btn.is-loading{opacity:.78;pointer-events:none;transform:none;box-shadow:0 6px 14px rgba(14,167,101,.16)}
.pr-export-toast{position:fixed;right:24px;bottom:24px;z-index:9999;display:flex;align-items:flex-start;gap:.7rem;max-width:360px;padding:.85rem 1rem;border-radius:14px;background:#fff;border:1px solid #A7F3D0;box-shadow:0 16px 40px rgba(6,95,70,.16);color:#065F46;opacity:0;pointer-events:none;transform:translateY(14px);transition:opacity .18s ease,transform .18s ease}
.pr-export-toast.is-visible{opacity:1;transform:translateY(0)}
.pr-export-toast.is-error{border-color:#FCA5A5;box-shadow:0 16px 40px rgba(153,27,27,.14);color:#991B1B}
.pr-export-toast-icon{width:30px;height:30px;border-radius:10px;background:#ECFDF5;color:#16A34A;display:inline-flex;align-items:center;justify-content:center;font-weight:900;flex-shrink:0}
.pr-export-toast.is-error .pr-export-toast-icon{background:#FEF2F2;color:#DC2626}
.pr-export-toast-title{font-size:.86rem;font-weight:800;color:#064E3B;margin-bottom:2px}
.pr-export-toast-text{font-size:.78rem;line-height:1.4;color:#047857}
.pr-export-toast.is-error .pr-export-toast-title{color:#991B1B}
.pr-export-toast.is-error .pr-export-toast-text{color:#B91C1C}
.pr-detail-btn{min-width:54px;background:var(--pk5);border:1px solid var(--border);border-radius:6px;padding:3px 8px;font-size:10px;font-weight:700;color:var(--pk1);cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;transition:all .15s}
.pr-detail-btn:hover{background:var(--pk1);border-color:var(--pk1);color:#fff;transform:translateY(-1px);box-shadow:0 7px 14px rgba(232,24,90,.16)}
.pr-detail-popup{border-radius:18px!important;border:1px solid var(--border)!important;padding:0!important;overflow:hidden!important}
.pr-detail-popup .swal2-html-container{margin:0!important;padding:0!important}
.pr-detail-popup .swal2-title{padding:18px 22px 8px!important;font-size:17px!important;color:var(--dark)!important;text-align:left!important}
.pr-detail-content{padding:0 22px 20px;text-align:left;color:#6F4056;font-family:'Plus Jakarta Sans',sans-serif}
.pr-detail-meta{font-size:11px;color:var(--muted);margin-bottom:12px}
.pr-detail-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:9px;margin-bottom:12px}
.pr-detail-card{background:#FFF8FC;border:1px solid var(--border);border-radius:11px;padding:10px 11px}
.pr-detail-label{font-size:9.5px;text-transform:uppercase;letter-spacing:.05em;color:var(--muted);font-weight:800;margin-bottom:4px}
.pr-detail-value{font-size:17px;color:var(--pk1);font-weight:800;font-family:'DM Mono',monospace;line-height:1.1}
.pr-detail-desc{font-size:11px;line-height:1.55;background:var(--pk6);border:1px solid var(--border);border-radius:11px;padding:11px 12px}
.pr-detail-desc strong{color:var(--pk1)}
.pr-detail-confirm{background:var(--pk5)!important;border:1px solid var(--border)!important;border-radius:10px!important;color:var(--pk1)!important;font-family:'Plus Jakarta Sans',sans-serif!important;font-size:12px!important;font-weight:800!important;padding:9px 18px!important;box-shadow:none!important;transition:all .15s!important}
.pr-detail-confirm:hover{background:var(--pk1)!important;border-color:var(--pk1)!important;color:#fff!important;transform:translateY(-1px)!important;box-shadow:0 8px 18px rgba(232,24,90,.2)!important}

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
    <div class="fp-content-header">
        <div>
            <div class="fp-content-eyebrow">FloraPredict · Machine Learning</div>
            <div class="fp-content-title">Prediksi</div>
            <div class="fp-content-subtitle">Hasil estimasi penjualan dan stok untuk periode selanjutnya</div>
        </div>
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
            @php
                $periodOptions = collect($availablePredictionPeriods ?? []);
                if (!empty($nextPredictionPeriod['value']) && ! $periodOptions->contains('value', $nextPredictionPeriod['value'])) {
                    $periodOptions = $periodOptions->push($nextPredictionPeriod);
                }
                $activePeriod = $selectedPeriod ?? null;
                $activeOption = $periodOptions->firstWhere('value', $activePeriod);

                try {
                    $activePeriodLabel = $activeOption['label']
                        ?? ($activePeriod
                            ? \Carbon\Carbon::createFromFormat('Y-m-d', $activePeriod . '-01')->translatedFormat('F Y')
                            : 'Periode aktif');
                } catch (\Exception $e) {
                    $activePeriodLabel = 'Periode aktif';
                }
            @endphp

            @if($periodOptions->count() > 1)
                <select class="pr-filter-select" name="periode"
                    onchange="window.location.href='{{ route('prediksi') }}?periode=' + this.value">
                    @foreach($periodOptions as $period)
                        <option value="{{ $period['value'] }}" {{ $period['value'] === $activePeriod ? 'selected' : '' }}>
                            {{ $period['label'] }}
                        </option>
                    @endforeach
                </select>
            @else
                <div class="pr-filter-select pr-period-locked">{{ $activePeriodLabel }}</div>
            @endif
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

        <div style="align-self:flex-end;display:flex;gap:8px;flex-shrink:0">
            @if(isset($predictionReady) && $predictionReady)
                <a href="{{ route('predictions.generate', ['periode' => $selectedPeriod]) }}"
                   class="pr-btn"
                   style="background:#B45309;box-shadow:0 4px 16px rgba(180,83,9,.25)"
                   data-generate-title="Generate ulang dengan model aktif?"
                   data-generate-subtitle="Prediksi {{ $nextMonthLabel }} sudah tersedia"
                   data-generate-message="Generate prediksi menggunakan model aktif untuk memperbarui hasil periode {{ $nextMonthLabel }}. Dataset historis digunakan pada tahap pelatihan dan evaluasi model."
                   data-generate-confirm="Ya, Generate Ulang"
                   onclick="openGenerateModal(this); return false;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="23 4 23 10 17 10"/>
                        <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
                    </svg>
                    Generate Ulang
                </a>
            @else
                <a href="{{ route('predictions.generate', ['periode' => $selectedPeriod]) }}"
                   class="pr-btn"
                   data-generate-title="Generate prediksi dengan model aktif?"
                   data-generate-subtitle="Prediksi akan dibuat untuk {{ $nextMonthLabel }}"
                   data-generate-message="Generate prediksi menggunakan model aktif untuk membuat hasil periode {{ $nextMonthLabel }}. Dataset historis digunakan pada tahap pelatihan dan evaluasi model."
                   data-generate-confirm="Ya, Generate Prediksi"
                   onclick="openGenerateModal(this); return false;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="5 3 19 12 5 21 5 3"/>
                    </svg>
                    Generate Prediksi Baru
                </a>
            @endif
        </div>
    </div>

    <div class="pr-generate-modal" id="pr-generate-modal" aria-hidden="true">
        <div class="pr-generate-box" role="dialog" aria-modal="true" aria-labelledby="pr-generate-title">
            <div class="pr-generate-head">
                <div class="pr-generate-icon">↻</div>
                <div>
                    <div class="pr-generate-title" id="pr-generate-title">Generate prediksi?</div>
                    <div class="pr-generate-sub" id="pr-generate-subtitle">Konfirmasi proses prediksi</div>
                </div>
            </div>
            <div class="pr-generate-body">
                <div id="pr-generate-message">Generate prediksi menggunakan model aktif.</div>
                <div class="pr-generate-note">
                    Dataset historis digunakan pada tahap pelatihan dan evaluasi model. Proses ini membaca fitur input dari MongoDB lalu memanggil Flask API.
                </div>
            </div>
            <div class="pr-generate-actions">
                <button type="button" class="pr-generate-cancel" onclick="closeGenerateModal()">Batal</button>
                <button type="button" class="pr-generate-confirm" id="pr-generate-confirm" onclick="confirmGenerate()">Ya, Generate</button>
            </div>
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
            <div class="pr-eval-lbl">Total Estimasi Kebutuhan</div>
            <div class="pr-eval-val rose">{{ number_format($prediction ?? 0) }}</div>
            <div class="pr-eval-sub">tangkai untuk {{ $nextMonthLabel ?? 'periode aktif' }}</div>
        </div>
        <div class="pr-eval">
            <div class="pr-eval-lbl">MAE Validasi</div>
            <div class="pr-eval-val">{{ $mae !== null ? number_format($mae, 2) : '-' }}</div>
            <div class="pr-eval-sub">{{ $mae !== null ? 'selisih rata-rata validasi' : 'validasi belum tersedia' }}</div>
            <div class="pr-eval-bar"><div class="pr-eval-bar-fill" style="width:{{ $mae !== null ? min(100, ($mae/500)*100) : 0 }}%"></div></div>
        </div>
        <div class="pr-eval">
            <div class="pr-eval-lbl">RMSE Validasi</div>
            <div class="pr-eval-val">{{ $rmse !== null ? number_format($rmse, 2) : '-' }}</div>
            <div class="pr-eval-sub">{{ $rmse !== null ? 'selisih besar validasi' : 'validasi belum tersedia' }}</div>
            <div class="pr-eval-bar"><div class="pr-eval-bar-fill" style="width:{{ $rmse !== null ? min(100, ($rmse/700)*100) : 0 }}%"></div></div>
        </div>
        <div class="pr-eval">
            <div class="pr-eval-lbl">Akurasi Validasi Model</div>
            @php $accuracy = $modelAccuracy ?? null; @endphp
            <div class="pr-eval-val rose">{{ $accuracy !== null ? number_format($accuracy, 1) . '%' : '-' }}</div>
            <div class="pr-eval-sub">{{ $accuracy !== null ? 'performa model pada data validasi' : 'validasi belum tersedia' }}</div>
            <div class="pr-eval-bar"><div class="pr-eval-bar-fill" style="width:{{ $accuracy !== null ? min(100, max(0, $accuracy)) : 0 }}%"></div></div>
        </div>
    </div>

    @if(isset($evaluationReady) && $evaluationReady)
    <div class="pr-alert ok">
        Model prediksi aktif: estimasi kebutuhan bunga untuk <strong style="color:var(--pk1)">{{ $nextMonthLabel }}</strong> tersedia. MAE, RMSE, dan akurasi di atas adalah hasil validasi model.
    </div>
    @else
    <div class="pr-alert ok">
        Prediksi <strong style="color:var(--pk1)">{{ $nextMonthLabel }}</strong> berhasil dibuat. Evaluasi aktual menunggu data penjualan real periode ini tersedia.
    </div>
    @endif
    @else
    <div class="pr-alert warn">
        ⚠ Prediksi belum dijalankan — klik tombol <strong>Generate Prediksi Baru</strong> di atas untuk memulai
    </div>
    @endif

    {{-- Main: Tabel Detail + Top 10 --}}
    <div class="pr-main">
        {{-- Tabel Detail --}}
        <div class="pr-sec">
            <div class="pr-sec-head pr-detail-head">
                <div class="pr-detail-title">
                    <div class="pr-sec-title">Estimasi Kebutuhan per Produk</div>
                    <div class="pr-sec-sub">Perkiraan jumlah tangkai yang perlu disiapkan untuk {{ $nextMonthLabel ?? 'periode aktif' }}</div>
                </div>
                <div class="pr-table-tools">
                    <div class="pr-table-actions">
                        <div class="pr-search-wrap">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#CCA8BA" stroke-width="2.5" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            <input type="text" placeholder="Cari produk..." id="pr-search-input" oninput="filterTable(this.value)">
                        </div>
                        <a href="{{ route('predictions.export', ['periode' => $selectedPeriod]) }}"
                           class="pr-export-btn pr-export-report-btn"
                           data-loading-label="Menyiapkan file...">⬇ Export Laporan Prediksi (.xlsx)</a>
                        <span class="pr-count-note">{{ number_format($totalProducts ?? 0) }} produk diprediksi</span>
                    </div>
                    <div class="pr-export-help">
                        <span class="pr-export-help-title">Keterangan Excel</span>
                        <span class="pr-export-help-note">
                            <span class="pr-export-help-chip"><strong>MAE Validasi</strong> selisih rata-rata model</span>
                            <span class="pr-export-help-chip"><strong>RMSE Validasi</strong> selisih besar model</span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="pr-scroll pr-detail-scroll">
                <table class="pr-tbl" id="pr-detail-tbl">
                    <colgroup>
                        <col style="width:48px">
                        <col>
                        <col style="width:130px">
                        <col style="width:130px">
                        <col style="width:88px">
                        <col style="width:88px">
                        <col style="width:96px">
                        <col style="width:78px">
                    </colgroup>
                    <thead>
                        <tr>
                            <th style="padding-left:12px">#</th>
                            <th>Nama Bunga</th>
                            <th>Kategori</th>
                            <th>Kebutuhan (tgk)</th>
                            <th>MAE Validasi</th>
                            <th>RMSE Validasi</th>
                            <th>Akurasi Validasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productPredictions ?? [] as $item)
                            @php
                                $accuracy = $item['accuracy'] ?? (
                                    $item['mae'] !== null && $item['prediction'] > 0
                                        ? max(0, 100 - (($item['mae'] / $item['prediction']) * 100))
                                        : null
                                );
                                $accColor = $accuracy !== null
                                    ? ($accuracy >= 80 ? '#065F46' : ($accuracy >= 60 ? '#B45309' : 'var(--pk1)'))
                                    : 'var(--muted)';
                            @endphp
                            <tr data-detail-row data-row-index="{{ $loop->iteration }}" data-search="{{ strtolower(($item['product_name'] ?? '') . ' ' . ($item['category'] ?? 'Bunga Potong')) }}">
                                <td class="pr-row-num" style="padding-left:12px;color:var(--muted);font-size:10.5px">{{ $loop->iteration }}</td>
                                <td style="font-weight:600;color:var(--dark)">{{ $item['product_name'] }}</td>
                                <td style="color:var(--muted);font-size:11px">{{ $item['category'] ?? 'Bunga Potong' }}</td>
                                <td><span class="pr-pill">✦ {{ number_format($item['prediction']) }}</span></td>
                                <td style="color:#7A4060;font-family:'DM Mono',monospace;font-size:11px">{{ $item['mae'] !== null ? number_format($item['mae'], 2) : '-' }}</td>
                                <td style="color:#7A4060;font-family:'DM Mono',monospace;font-size:11px">{{ $item['rmse'] !== null ? number_format($item['rmse'], 2) : '-' }}</td>
                                <td>
                                    @if($accuracy !== null)
                                        <span style="font-size:11px;font-weight:700;color:{{ $accColor }}">{{ number_format($accuracy, 0) }}%</span>
                                    @else
                                        <span style="color:var(--muted);font-size:11px">—</span>
                                    @endif
                                </td>
                                <td>
                                    <button
                                        type="button"
                                        class="pr-detail-btn"
                                        data-name="{{ e($item['product_name']) }}"
                                        data-category="{{ e($item['category'] ?? 'Bunga Potong') }}"
                                        data-period="{{ e($nextMonthLabel ?? 'periode aktif') }}"
                                        data-prediction="{{ number_format($item['prediction']) }}"
                                        data-mae="{{ $item['mae'] !== null ? number_format($item['mae'], 2) : '-' }}"
                                        data-rmse="{{ $item['rmse'] !== null ? number_format($item['rmse'], 2) : '-' }}"
                                        data-accuracy="{{ $accuracy !== null ? number_format($accuracy, 1) . '%' : '-' }}"
                                        onclick="openPredictionDetail(this)"
                                    >Detail</button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8"><div class="pr-empty">Belum ada data prediksi — jalankan Generate Prediksi terlebih dahulu</div></td></tr>
                        @endforelse
                        <tr id="pr-search-empty" style="display:none">
                            <td colspan="8"><div class="pr-empty" style="padding:18px">Produk tidak ditemukan</div></td>
                        </tr>
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
                        <button type="button" style="width:26px;height:26px;border-radius:6px;border:1px solid var(--border);background:var(--pk6);color:var(--muted);font-size:10.5px;cursor:pointer">…</button>
                        <button type="button" onclick="gotoPage({{ ceil(count($productPredictions ?? []) / 10) }})"
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
                    <div class="pr-sec-sub">Error dihitung jika data real periode tersebut sudah tersedia</div>
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
                            @php
                                $hasActual = (bool) ($row->has_actual ?? false);
                                $isHigh = $hasActual && (($row->error ?? 0) > 1000);
                                $statusLabel = $hasActual ? ($isHigh ? 'Tinggi' : 'Normal') : 'Belum ada real';
                                $statusBg = $hasActual ? ($isHigh ? 'var(--pk5)' : '#ECFDF5') : '#F8FAFC';
                                $statusColor = $hasActual ? ($isHigh ? 'var(--pk1)' : '#065F46') : '#64748B';
                            @endphp
                            <tr>
                                <td style="padding-left:12px;font-size:10.5px;color:var(--muted)">{{ $row->tanggal }}</td>
                                <td style="font-family:'DM Mono',monospace;font-size:11px">{{ number_format($row->predicted_sales) }}</td>
                                <td style="font-family:'DM Mono',monospace;font-size:11px">{{ $hasActual ? number_format($row->actual_sales ?? 0) : '-' }}</td>
                                <td style="color:{{ $statusColor }};font-weight:700;font-family:'DM Mono',monospace;font-size:11px">{{ $hasActual ? number_format($row->error ?? 0) : '-' }}</td>
                                <td>
                                    <span style="font-size:10px;padding:2px 7px;border-radius:5px;font-weight:700;background:{{ $statusBg }};color:{{ $statusColor }}">
                                        {{ $statusLabel }}
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
                    <div class="pr-sec-sub">Proporsi estimasi kebutuhan dari total prediksi</div>
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

<div class="pr-export-toast" id="prediction-export-toast" role="status" aria-live="polite">
    <span class="pr-export-toast-icon">✓</span>
    <div>
        <div class="pr-export-toast-title">File sedang disiapkan</div>
        <div class="pr-export-toast-text">Export laporan prediksi sedang dibuat. Mohon tunggu sampai download dimulai.</div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success') || session('error'))
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        toast: {{ session('success') ? 'true' : 'false' }},
        position: '{{ session('success') ? 'top-end' : 'center' }}',
        icon: '{{ session('success') ? 'success' : 'error' }}',
        title: '{{ session('success') ? 'Prediksi Berhasil!' : 'Generate Prediksi Gagal' }}',
        text: @json(session('success') ?? session('error')),
        showConfirmButton: {{ session('success') ? 'false' : 'true' }},
        confirmButtonText: 'Oke',
        timer: {{ session('success') ? '3800' : 'null' }},
        timerProgressBar: {{ session('success') ? 'true' : 'false' }},
        backdrop: {{ session('success') ? 'false' : 'true' }},
        background: '#FFF8FC',
        color: '#1A0A12',
        iconColor: '{{ session('success') ? '#E8185A' : '#DC2626' }}',
        customClass: {
            popup: 'swal-flora-popup',
            title: 'swal-flora-title',
            timerProgressBar: 'swal-flora-bar'
        }
    });
});
@endif

const predictionExportButton = document.querySelector('.pr-export-report-btn');
const predictionExportToast = document.getElementById('prediction-export-toast');
let predictionExportToastTimer = null;

function showPredictionExportToast(type, title, text) {
    if (! predictionExportToast) return;

    const toastIcon = predictionExportToast.querySelector('.pr-export-toast-icon');
    const toastTitle = predictionExportToast.querySelector('.pr-export-toast-title');
    const toastText = predictionExportToast.querySelector('.pr-export-toast-text');
    const isError = type === 'error';

    predictionExportToast.classList.toggle('is-error', isError);
    if (toastIcon) toastIcon.textContent = isError ? '!' : '✓';
    if (toastTitle) toastTitle.textContent = title;
    if (toastText) toastText.textContent = text;

    predictionExportToast.classList.add('is-visible');
    window.clearTimeout(predictionExportToastTimer);

    predictionExportToastTimer = window.setTimeout(function() {
        predictionExportToast.classList.remove('is-visible');
    }, 4200);
}

function predictionExportFilename(response) {
    const disposition = response.headers.get('content-disposition') || '';
    const utf8Match = disposition.match(/filename\*=UTF-8''([^;]+)/i);
    const plainMatch = disposition.match(/filename="?([^"]+)"?/i);

    if (utf8Match) return decodeURIComponent(utf8Match[1]);
    if (plainMatch) return plainMatch[1];

    return 'laporan-prediksi.xlsx';
}

if (predictionExportButton) {
    const originalPredictionExportLabel = predictionExportButton.textContent.trim();

    function resetPredictionExportButton() {
        predictionExportButton.classList.remove('is-loading');
        predictionExportButton.removeAttribute('aria-disabled');
        predictionExportButton.textContent = originalPredictionExportLabel;
    }

    predictionExportButton.addEventListener('click', async function(e) {
        if (predictionExportButton.classList.contains('is-loading')) {
            e.preventDefault();
            return;
        }

        if (! window.fetch || ! window.URL) {
            return;
        }

        e.preventDefault();
        showPredictionExportToast(
            'success',
            'File sedang disiapkan',
            'Export laporan prediksi sedang dibuat. Mohon tunggu sampai download dimulai.'
        );

        predictionExportButton.classList.add('is-loading');
        predictionExportButton.setAttribute('aria-disabled', 'true');
        predictionExportButton.textContent = predictionExportButton.dataset.loadingLabel || 'Menyiapkan file...';

        try {
            const response = await fetch(predictionExportButton.href, {
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
            downloadLink.download = predictionExportFilename(response);
            document.body.appendChild(downloadLink);
            downloadLink.click();
            downloadLink.remove();

            window.setTimeout(function() {
                window.URL.revokeObjectURL(downloadUrl);
            }, 1000);

            showPredictionExportToast(
                'success',
                'File siap diunduh',
                'Download Excel laporan prediksi sudah dimulai. Tombol export sudah bisa dipakai lagi.'
            );
        } catch (error) {
            showPredictionExportToast(
                'error',
                'Export belum berhasil',
                'File laporan prediksi belum bisa disiapkan. Coba ulangi atau periksa koneksi MongoDB.'
            );
        } finally {
            resetPredictionExportButton();
        }
    });
}

let pendingGenerateUrl = null;

function openGenerateModal(trigger) {
    pendingGenerateUrl = trigger.getAttribute('href');

    document.getElementById('pr-generate-title').textContent = trigger.dataset.generateTitle || 'Generate prediksi?';
    document.getElementById('pr-generate-subtitle').textContent = trigger.dataset.generateSubtitle || 'Konfirmasi proses prediksi';
    document.getElementById('pr-generate-message').textContent = trigger.dataset.generateMessage || 'Sistem akan menjalankan model prediksi.';

    const confirmBtn = document.getElementById('pr-generate-confirm');
    confirmBtn.textContent = trigger.dataset.generateConfirm || 'Ya, Generate';
    confirmBtn.disabled = false;

    const modal = document.getElementById('pr-generate-modal');
    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden', 'false');
}

function closeGenerateModal() {
    const modal = document.getElementById('pr-generate-modal');
    modal.classList.remove('is-open');
    modal.setAttribute('aria-hidden', 'true');
    pendingGenerateUrl = null;
}

function confirmGenerate() {
    if (!pendingGenerateUrl) {
        closeGenerateModal();
        return;
    }

    const confirmBtn = document.getElementById('pr-generate-confirm');
    confirmBtn.disabled = true;
    confirmBtn.textContent = 'Memproses...';
    window.location.href = pendingGenerateUrl;
}

document.getElementById('pr-generate-modal')?.addEventListener('click', function (event) {
    if (event.target === this) {
        closeGenerateModal();
    }
});

document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
        closeGenerateModal();
    }
});

function escapeHtml(value) {
    return String(value ?? '').replace(/[&<>"']/g, function (char) {
        return {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        }[char];
    });
}

function openPredictionDetail(button) {
    const data = button.dataset;
    const name = escapeHtml(data.name || 'Produk');
    const category = escapeHtml(data.category || 'Bunga Potong');
    const period = escapeHtml(data.period || 'periode aktif');
    const prediction = escapeHtml(data.prediction || '0');
    const mae = escapeHtml(data.mae || '0.00');
    const rmse = escapeHtml(data.rmse || '0.00');
    const accuracy = escapeHtml(data.accuracy || '-');

    const html = `
        <div class="pr-detail-content">
            <div class="pr-detail-meta">${category} · Periode ${period}</div>
            <div class="pr-detail-grid">
                <div class="pr-detail-card">
                    <div class="pr-detail-label">Estimasi Kebutuhan</div>
                    <div class="pr-detail-value">${prediction}</div>
                </div>
                <div class="pr-detail-card">
                    <div class="pr-detail-label">Akurasi Validasi</div>
                    <div class="pr-detail-value">${accuracy}</div>
                </div>
                <div class="pr-detail-card">
                    <div class="pr-detail-label">MAE Validasi</div>
                    <div class="pr-detail-value">${mae}</div>
                </div>
                <div class="pr-detail-card">
                    <div class="pr-detail-label">RMSE Validasi</div>
                    <div class="pr-detail-value">${rmse}</div>
                </div>
            </div>
            <div class="pr-detail-desc">
                <strong>MAE Validasi</strong>, <strong>RMSE Validasi</strong>, dan akurasi validasi membaca performa model pada data uji. Evaluasi aktual periode ini dilihat di bagian Prediksi vs Penjualan Real.
            </div>
        </div>
    `;

    if (window.Swal) {
        Swal.fire({
            title: `Detail ${name}`,
            html,
            width: 520,
            showCloseButton: true,
            confirmButtonText: 'Saya Mengerti',
            background: '#FFFFFF',
            customClass: {
                popup: 'pr-detail-popup',
                confirmButton: 'pr-detail-confirm'
            }
        });
        return;
    }

    alert(`Detail ${data.name || 'Produk'}\nEstimasi: ${data.prediction || 0} tangkai\nMAE Validasi: ${data.mae || 0}\nRMSE Validasi: ${data.rmse || 0}\nAkurasi Validasi: ${data.accuracy || '-'}`);
}

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
    return getDetailRows().filter(row => !query || (row.dataset.search || '').includes(query));
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
    const emptyRow = document.getElementById('pr-search-empty');
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

    if (emptyRow) {
        emptyRow.style.display = filteredRows.length === 0 ? '' : 'none';
    }

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
