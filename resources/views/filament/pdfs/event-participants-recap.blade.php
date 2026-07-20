@php
    $accent       = '#8B1A1A';
    $statusLabels = ['pending'=>'Pending','confirmed'=>'Confirmed','attended'=>'Attended','cancelled'=>'Cancelled'];
    $payLabels    = ['paid'=>'LUNAS','free'=>'GRATIS','refunded'=>'REFUNDED','pending'=>'BELUM BAYAR'];
    $statusColor  = ['pending'=>'#854d0e','confirmed'=>'#166534','attended'=>'#1e40af','cancelled'=>'#991b1b'];
    $payColor     = ['paid'=>'#166534','free'=>'#1e40af','refunded'=>'#6b21a8','pending'=>'#854d0e'];
    $statusBg     = ['pending'=>'#fef9c3','confirmed'=>'#dcfce7','attended'=>'#dbeafe','cancelled'=>'#fee2e2'];
    $payBg        = ['paid'=>'#dcfce7','free'=>'#dbeafe','refunded'=>'#f3e8ff','pending'=>'#fef9c3'];
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family:'DejaVu Sans', sans-serif; font-size:9px; color:#1a1a1a; background:#fff; }

/* HEADER */
.header { background:{{ $accent }}; padding:14px 32px; color:#fff; }
.header-inner { display:table; width:100%; }
.header-left  { display:table-cell; vertical-align:middle; width:60%; }
.header-right { display:table-cell; vertical-align:middle; text-align:right; }
.header h1    { font-size:16px; font-weight:bold; letter-spacing:1px; margin-bottom:2px; }
.header .sub  { font-size:8px; opacity:0.8; }
.header .date { font-size:9px; opacity:0.9; }

/* STATS */
.stats-wrap { padding:12px 32px; border-bottom:1px solid #e5e7eb; background:#fafafa; }
.stats-inner { display:table; width:100%; }
.stat-cell { display:table-cell; text-align:center; padding:6px 8px; border-right:1px solid #e5e7eb; }
.stat-cell:last-child { border-right:none; }
.stat-val  { font-size:16px; font-weight:bold; color:{{ $accent }}; display:block; }
.stat-lbl  { font-size:7.5px; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; margin-top:2px; }

/* TABLE */
.table-wrap { padding:12px 32px 16px; }
table.recap { width:100%; border-collapse:collapse; }
table.recap thead tr { background:{{ $accent }}; }
table.recap thead th {
    padding:7px 6px;
    font-size:8px;
    font-weight:bold;
    color:#fff;
    text-align:left;
    text-transform:uppercase;
    letter-spacing:0.5px;
}
table.recap thead th.r { text-align:right; }
table.recap thead th.c { text-align:center; }
table.recap tbody tr { border-bottom:1px solid #e5e7eb; }
table.recap tbody tr:nth-child(even) { background:#f9fafb; }
table.recap tbody td { padding:6px 6px; font-size:8.5px; color:#374151; vertical-align:top; }
table.recap tbody td.r { text-align:right; font-weight:600; white-space:nowrap; }
table.recap tbody td.c { text-align:center; }
table.recap tbody td .sub { font-size:7.5px; color:#9ca3af; margin-top:1px; }
table.recap tfoot tr { background:#f3f4f6; border-top:1.5px solid #1a1a1a; }
table.recap tfoot td { padding:7px 6px; font-size:9px; font-weight:bold; color:#1a1a1a; }
table.recap tfoot td.r { text-align:right; color:{{ $accent }}; font-size:10px; white-space:nowrap; }

/* BADGE */
.badge {
    display:inline-block;
    padding:2px 6px;
    border-radius:20px;
    font-size:7.5px;
    font-weight:bold;
    text-transform:uppercase;
    white-space:nowrap;
}

/* FOOTER */
.footer { background:{{ $accent }}; padding:8px 32px; color:#fff; }
.footer-inner { display:table; width:100%; }
.footer-left  { display:table-cell; vertical-align:middle; font-size:8px; opacity:0.85; }
.footer-right { display:table-cell; vertical-align:middle; text-align:right; font-size:8px; opacity:0.85; }
</style>
</head>
<body>

{{-- HEADER --}}
<div class="header">
    <div class="header-inner">
        <div class="header-left">
            <h1>REKAPAN PESERTA EVENT</h1>
            <div class="sub">{{ $company?->company_name ?? 'HASTANA INDONESIA' }}</div>
        </div>
        <div class="header-right">
            <div class="date">Dicetak: {{ now()->format('d M Y, H:i') }} WIB</div>
            <div class="sub" style="margin-top:3px;">Total {{ $stats['total'] }} peserta</div>
        </div>
    </div>
</div>

{{-- STATS --}}
<div class="stats-wrap">
    <div class="stats-inner">
        <div class="stat-cell">
            <span class="stat-val">{{ $stats['total'] }}</span>
            <span class="stat-lbl">Total Peserta</span>
        </div>
        <div class="stat-cell">
            <span class="stat-val" style="color:#166534">{{ $stats['confirmed'] }}</span>
            <span class="stat-lbl">Confirmed</span>
        </div>
        <div class="stat-cell">
            <span class="stat-val" style="color:#854d0e">{{ $stats['pending'] }}</span>
            <span class="stat-lbl">Pending</span>
        </div>
        <div class="stat-cell">
            <span class="stat-val" style="color:#991b1b">{{ $stats['cancelled'] }}</span>
            <span class="stat-lbl">Cancelled</span>
        </div>
        <div class="stat-cell" style="border-left:2px solid #d1d5db;">
            <span class="stat-val" style="color:#166534">{{ $stats['paid'] }}</span>
            <span class="stat-lbl">Sudah Bayar</span>
        </div>
        <div class="stat-cell">
            <span class="stat-val" style="color:#854d0e">{{ $stats['unpaid'] }}</span>
            <span class="stat-lbl">Belum Bayar</span>
        </div>
        <div class="stat-cell">
            <span class="stat-val" style="color:#1e40af">{{ $stats['free'] }}</span>
            <span class="stat-lbl">Gratis</span>
        </div>
        <div class="stat-cell" style="border-left:2px solid #d1d5db;">
            <span class="stat-val">Rp {{ number_format($stats['revenue'], 0, ',', '.') }}</span>
            <span class="stat-lbl">Total Pendapatan</span>
        </div>
    </div>
</div>

{{-- TABLE --}}
<div class="table-wrap">
    <table class="recap">
        <thead>
            <tr>
                <th style="width:28px" class="c">No</th>
                <th style="width:20%">Nama Peserta</th>
                <th style="width:18%">Email</th>
                <th style="width:20%">Event</th>
                <th style="width:10%" class="c">Pembayaran</th>
                <th style="width:16%">Add-on</th>
                <th style="width:10%" class="r">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($participants as $i => $p)
            @php
                $addons      = $p->participantAddons;
                $addonsTotal = $addons->sum(fn($a) => $a->quantity * $a->price_at_time);
            @endphp
            <tr>
                <td class="c" style="color:#9ca3af">{{ $i + 1 }}</td>
                <td>
                    {{ $p->name }}
                    <div class="sub">{{ $p->phone }}</div>
                    @if($p->company)
                        <div class="sub">{{ $p->company }}{{ $p->position ? ', ' . $p->position : '' }}</div>
                    @endif
                </td>
                <td>
                    {{ $p->email }}
                    <div class="sub">
                        Asal Region: {{ $p->user?->weddingOrganizer?->region?->region_name ?? '—' }}
                    </div>
                    <div class="sub" style="font-family:monospace;">{{ strtoupper($p->registration_code) }}</div>
                </td>
                <td>
                    {{ $p->eventHastana?->title ?? '—' }}
                    @if($p->eventHastana?->start_date)
                        <div class="sub">{{ $p->eventHastana->start_date->format('d M Y') }}</div>
                    @endif
                </td>
                <td class="c">
                    <span class="badge"
                          style="background:{{ $payBg[$p->payment_status] ?? '#f3f4f6' }}; color:{{ $payColor[$p->payment_status] ?? '#374151' }}">
                        {{ $payLabels[$p->payment_status] ?? strtoupper($p->payment_status) }}
                    </span>
                    @if(filled($p->payment_proof))
                        <div class="sub" style="margin-top:3px;">
                            {{ $p->created_at?->format('d M Y') ?? '—' }}
                        </div>
                    @endif
                </td>
                <td>
                    @if($addons->isNotEmpty())
                        @foreach($addons as $addon)
                            <div style="margin-bottom:4px;">
                                {{ $addon->eventAddon?->name ?? 'Add-on' }}
                                <span style="color:#9ca3af"> ×{{ $addon->quantity }}</span>
                                <div style="color:#374151; font-weight:600; margin-top:1px;">
                                    Rp {{ number_format($addon->quantity * $addon->price_at_time, 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                        @if($addons->count() > 1)
                            <div style="border-top:1px solid #e5e7eb; margin-top:2px; padding-top:2px; font-size:7.5px; color:#6b7280; text-align:right;">
                                Subtotal: Rp {{ number_format($addonsTotal, 0, ',', '.') }}
                            </div>
                        @endif
                    @else
                        <span style="color:#d1d5db;">—</span>
                    @endif
                </td>
                <td class="r">
                    @if($p->payment_status === 'free')
                        <span style="color:#1e40af">GRATIS</span>
                    @elseif($p->total_amount > 0)
                        Rp {{ number_format($p->total_amount, 0, ',', '.') }}
                    @else
                        —
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center; padding:20px; color:#9ca3af;">Belum ada data peserta</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6">Total Pendapatan (status: LUNAS)</td>
                <td class="r">Rp {{ number_format($stats['revenue'], 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</div>

{{-- FOOTER --}}
<div class="footer">
    <div class="footer-inner">
        <div class="footer-left">
            {{ $company?->company_name ?? 'Hastana Indonesia' }}
            @if($company?->phone) &nbsp;|&nbsp; {{ $company->phone }} @endif
            @if($company?->email) &nbsp;|&nbsp; {{ $company->email }} @endif
        </div>
        <div class="footer-right">
            Halaman <span style="font-weight:bold">1</span>
        </div>
    </div>
</div>

</body>
</html>
