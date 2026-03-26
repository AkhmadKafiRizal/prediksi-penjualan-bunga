<x-app-layout>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
    
    </h2>
</x-slot>

{{-- ══════════════════════════════════════════
     INLINE STYLES — paste into flora.css jika mau
═══════════════════════════════════════════ --}}
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap');

    .fp-page * { font-family: 'Plus Jakarta Sans', sans-serif; }

    /* ── layout ── */
    .fp-page {
        padding: 2.5rem 1rem 4rem;
        background: #faf7f5;
        min-height: calc(100vh - 64px);
    }

    .fp-inner {
        max-width: 1100px;
        margin: 0 auto;
    }

    /* ── page header ── */
    .fp-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.75rem;
    }

    .fp-eyebrow {
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: #e85d75;
        margin-bottom: 0.25rem;
    }

    .fp-title {
        font-size: 1.7rem;
        font-weight: 700;
        color: #1a1a2e;
        line-height: 1.15;
    }

    /* ── alert ── */
    .fp-alert-success {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.75rem 1.1rem;
        background: #ecfdf5;
        border: 1px solid #6ee7b7;
        border-radius: 10px;
        color: #065f46;
        font-size: 0.85rem;
        font-weight: 500;
        margin-bottom: 1.5rem;
    }

    .fp-last-update {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.8rem;
        color: #9090aa;
        margin-bottom: 1.5rem;
    }

    .fp-last-update strong { color: #4a4a6a; }

    /* ── upload form card ── */
    .fp-upload-card {
        background: #fff;
        border: 1.5px dashed #f0b8c3;
        border-radius: 14px;
        padding: 1.2rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 2rem;
    }

    .fp-file-label {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.55rem 1rem;
        border: 1px solid #ece8f0;
        border-radius: 8px;
        background: #faf7f5;
        font-size: 0.84rem;
        color: #4a4a6a;
        cursor: pointer;
        transition: border-color 0.2s;
    }

    .fp-file-label:hover { border-color: #e85d75; }
    .fp-file-label input[type="file"] { display: none; }
    #file-name-display { font-style: italic; color: #9090aa; font-size: 0.8rem; }

    .fp-btn-upload {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.6rem 1.3rem;
        background: #e85d75;
        color: #fff;
        border: none;
        border-radius: 9px;
        font-family: inherit;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
        box-shadow: 0 4px 14px rgba(232,93,117,0.3);
    }

    .fp-btn-upload:hover {
        background: #c94060;
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(232,93,117,0.4);
    }

    /* ── table card ── */
    .fp-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #ece8f0;
        box-shadow: 0 4px 24px rgba(232,93,117,0.07);
        overflow: hidden;
    }

    /* toolbar */
    .fp-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #ece8f0;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .fp-toolbar-title {
        font-size: 0.9rem;
        font-weight: 600;
        color: #4a4a6a;
    }

    .fp-badge-count {
        display: inline-block;
        background: #fde8ec;
        color: #c94060;
        border-radius: 20px;
        padding: 0.15rem 0.65rem;
        font-size: 0.72rem;
        font-weight: 700;
        margin-left: 0.5rem;
    }

    /* table */
    .fp-table-wrap { overflow-x: auto; }

    .fp-table {
        width: 100%;
        border-collapse: collapse;
    }

    .fp-table thead tr {
        background: #fdf5f7;
    }

    .fp-table th {
        padding: 0.8rem 1.25rem;
        text-align: left;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #9090aa;
        border-bottom: 1px solid #ece8f0;
        white-space: nowrap;
    }

    .fp-table th.right,
    .fp-table td.right { text-align: right; }

    .fp-table tbody tr {
        border-bottom: 1px solid #f3eff6;
        transition: background 0.12s;
    }

    .fp-table tbody tr:last-child { border-bottom: none; }
    .fp-table tbody tr:hover { background: #fff5f7; }

    .fp-table td {
        padding: 0.8rem 1.25rem;
        font-size: 0.875rem;
        color: #4a4a6a;
        vertical-align: middle;
    }

    /* first column: row number */
    .fp-table td.row-num {
        font-size: 0.75rem;
        color: #c0bbd0;
        font-family: 'DM Mono', monospace;
        width: 48px;
    }

    /* YEAR_MONTH badge */
    .badge-period {
        display: inline-block;
        background: #fde8ec;
        color: #c94060;
        border-radius: 6px;
        padding: 0.22rem 0.6rem;
        font-size: 0.78rem;
        font-weight: 600;
        font-family: 'DM Mono', monospace;
        letter-spacing: 0.04em;
    }

    /* numeric cells */
    .num-cell {
        font-family: 'DM Mono', monospace;
        font-size: 0.84rem;
        color: #1a1a2e;
    }

    .sales-cell {
        font-family: 'DM Mono', monospace;
        font-size: 0.84rem;
        font-weight: 600;
        color: #c94060;
    }

    /* generic cell for other columns */
    .fp-table td.generic {
        font-size: 0.84rem;
    }

    /* empty state */
    .fp-empty {
        text-align: center;
        padding: 3.5rem 2rem;
        color: #c0bbd0;
    }

    .fp-empty svg { width: 44px; height: 44px; margin-bottom: 0.75rem; opacity: 0.4; }
    .fp-empty p { font-size: 0.875rem; }
</style>

<div class="fp-page">
<div class="fp-inner">

    {{-- ── Page header ── --}}
    <div class="fp-header">
        <div>
            <div class="fp-eyebrow">FloraPredict</div>
            <h1 class="fp-title">Data Penjualan Bunga</h1>
        </div>
    </div>

    {{-- ── Last upload info ── --}}
    @if($lastUpload)
    <div class="fp-last-update">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z"/>
        </svg>
        Dataset terakhir diperbarui: <strong>{{ $lastUpload }}</strong>
    </div>
    @endif

    {{-- ── Success alert ── --}}
    @if(session('success'))
    <div class="fp-alert-success">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- ── Upload card ── --}}
    <form action="{{ route('upload.dataset') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="fp-upload-card">
            {{-- Custom file input --}}
            <label class="fp-file-label">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13"/>
                </svg>
                <input type="file" name="dataset" required id="dataset-input" accept=".csv,.xlsx,.xls">
                <span id="file-name-display">Pilih file CSV / Excel…</span>
            </label>

            <button type="submit" class="fp-btn-upload">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                </svg>
                Upload Dataset
            </button>
        </div>
    </form>

    {{-- ── Table card ── --}}
    <div class="fp-card">

        {{-- Toolbar --}}
        <div class="fp-toolbar">
            <span class="fp-toolbar-title">
                Dataset Penjualan
                @if(!empty($rows))
                <span class="fp-badge-count">{{ count($rows) }} baris</span>
                @endif
            </span>
        </div>

        {{-- Table --}}
        <div class="fp-table-wrap">
            <table class="fp-table">
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        @foreach($header as $head)
                            <th class="{{ in_array(strtolower($head), ['sales','quantityordered','quantity_ordered']) ? 'right' : '' }}">
                                {{ $head }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($rows as $i => $row)
                    <tr>
                        <td class="row-num">{{ $i + 1 }}</td>
                        @foreach($row as $colIndex => $cell)
                            @php
                                $colName = strtolower($header[$colIndex] ?? '');
                                $isYearMonth = str_contains($colName, 'year') || str_contains($colName, 'month') || str_contains($colName, 'periode');
                                $isSales = str_contains($colName, 'sales');
                                $isQty = str_contains($colName, 'quantity') || str_contains($colName, 'qty');
                            @endphp

                            @if($isYearMonth)
                                <td><span class="badge-period">{{ $cell }}</span></td>
                            @elseif($isSales)
                                <td class="right sales-cell">{{ is_numeric($cell) ? number_format($cell, 2, ',', '.') : $cell }}</td>
                            @elseif($isQty)
                                <td class="right num-cell">{{ is_numeric($cell) ? number_format($cell) : $cell }}</td>
                            @else
                                <td class="generic">{{ $cell }}</td>
                            @endif
                        @endforeach
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ count($header) + 1 }}">
                            <div class="fp-empty">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/>
                                </svg>
                                <p>Belum ada data. Upload dataset terlebih dahulu.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>{{-- /fp-card --}}

</div>
</div>

<script>
    // Update label nama file saat dipilih
    document.getElementById('dataset-input').addEventListener('change', function () {
        const name = this.files[0] ? this.files[0].name : 'Pilih file CSV / Excel…';
        document.getElementById('file-name-display').textContent = name;
    });
</script>

</x-app-layout>