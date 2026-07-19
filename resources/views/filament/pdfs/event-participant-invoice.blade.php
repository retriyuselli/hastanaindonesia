@php
    $basePrice   = $participant->base_price ?? 0;
    $addonsTotal = $participant->participantAddons->sum(fn($a) => $a->quantity * $a->price_at_time);
    $total       = $participant->total_amount ?? ($basePrice + $addonsTotal);
    $isFree      = $event->is_free && $addonsTotal == 0;
    $methods     = ['bca'=>'Transfer Bank BCA','mandiri'=>'Transfer Bank Mandiri','bni'=>'Transfer Bank BNI','bri'=>'Transfer Bank BRI','gopay'=>'GoPay','ovo'=>'OVO','dana'=>'DANA','cash'=>'Tunai','e_wallet'=>'E-Wallet','bank_transfer'=>'Bank Transfer'];
    $payLabels   = ['paid'=>'LUNAS','free'=>'GRATIS','refunded'=>'REFUNDED','pending'=>'BELUM BAYAR'];
    $payColors   = ['paid'=>'#166534','free'=>'#1e40af','refunded'=>'#6b21a8','pending'=>'#854d0e'];
    $payBg       = ['paid'=>'#dcfce7','free'=>'#dbeafe','refunded'=>'#f3e8ff','pending'=>'#fef9c3'];
    $accent      = '#8B1A1A';
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family:'DejaVu Sans', sans-serif; font-size:10px; color:#1a1a1a; background:#fff; }

/* TABLE HELPERS */
.row  { display:table; width:100%; }
.col  { display:table-cell; vertical-align:top; }
.col-r{ display:table-cell; vertical-align:top; text-align:right; }

/* TOP DECORATION */
.deco-bar {
    position:relative;
    height: 68px;
    background:#fff;
    overflow:hidden;
    margin-bottom: 4px;
}
.deco-pill {
    position:absolute;
    top:-20px; right:-30px;
    width:320px; height:100px;
    background: {{ $accent }};
    border-radius:60px;
}
.deco-dot {
    position:absolute;
    top:-28px; left:-24px;
    width:90px; height:90px;
    background: {{ $accent }};
    border-radius:50%;
}

/* BRAND */
.brand-wrap  { padding: 0 52px 16px; border-bottom: 1px solid #e5e7eb; }
.brand-name  { font-size:13px; font-weight:bold; color:#1a1a1a; letter-spacing:0.5px; }
.brand-tagline { font-size:8px; color:#6b7280; margin-top:2px; }

/* INVOICE TITLE */
.invoice-title {
    font-size:44px;
    font-weight:bold;
    color:#1a1a1a;
    letter-spacing:1px;
    padding: 20px 52px 0;
}

/* BILL TO & META */
.bill-section { padding: 18px 52px 0; }
.label-sm  { font-size:9px; color:#9ca3af; margin-bottom:3px; }
.name-lg   { font-size:13px; font-weight:bold; color:#1a1a1a; margin-bottom:3px; }
.text-muted { font-size:9.5px; color:#6b7280; line-height:1.7; }

.meta-table { border-collapse:collapse; width:100%; }
.meta-table td { padding: 4px 0; font-size:10px; vertical-align:top; }
.meta-table td.ml { color:#6b7280; white-space:nowrap; width:1px; }
.meta-table td.mc { color:#6b7280; padding:4px 8px 0; width:1px; white-space:nowrap; }
.meta-table td.mv { font-weight:bold; color:#1a1a1a; text-align:right; }

/* STATUS BADGE */
.badge {
    display:inline-block;
    padding: 2px 9px;
    border-radius:20px;
    font-size:8px;
    font-weight:bold;
    text-transform:uppercase;
    letter-spacing:0.5px;
}

/* LINE ITEMS */
.items-wrap { padding: 22px 52px 0; }
table.items { width:100%; border-collapse:collapse; }
table.items thead tr { border-bottom: 1.5px solid #1a1a1a; }
table.items thead th {
    padding: 7px 0;
    font-size:9px;
    font-weight:bold;
    text-transform:uppercase;
    letter-spacing:0.6px;
    color:#1a1a1a;
    text-align:left;
}
table.items thead th.r { text-align:right; }
table.items tbody tr { border-bottom:1px solid #e5e7eb; }
table.items tbody td { padding:10px 0; font-size:10px; color:#374151; vertical-align:top; }
table.items tbody td.r { text-align:right; }
table.items tbody td.c { text-align:center; }
table.items tbody td .sub { font-size:8.5px; color:#9ca3af; margin-top:2px; }

/* BOTTOM SECTION */
.bottom-wrap { padding: 20px 52px 0; }
.pay-method-title { font-size:9px; font-weight:bold; text-transform:uppercase; letter-spacing:0.8px; color:#1a1a1a; margin-bottom:6px; }
.pay-method-val   { font-size:10px; color:#374151; line-height:1.8; }

/* TOTALS */
table.totals { border-collapse:collapse; width:200px; }
table.totals td { padding:4px 0; font-size:10px; }
table.totals td:last-child { text-align:right; }
table.totals .sub-row td { color:#6b7280; }
table.totals .line-row td { border-top:2px solid #1a1a1a; padding-top:8px; margin-top:6px; }
table.totals .total-row td { font-size:15px; font-weight:bold; color:#1a1a1a; }
table.totals .total-row td:last-child { color: {{ $accent }}; }

/* THANK YOU */
.thankyou-wrap { padding: 24px 52px 20px; }
.thankyou-text { font-size:16px; color:#1a1a1a; font-style:normal; }
.signed-block { width:160px; margin-left:auto; padding-top:80px; }
.signed-line  { border-top:1.5px solid #1a1a1a; margin-bottom:5px; }
.signed-label { font-size:9px; color:#6b7280; text-align:center; }

/* FOOTER BAR */
.footer-bar {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: {{ $accent }};
    padding: 11px 52px;
    color:#fff;
}
.footer-bar .row-inner { display:table; width:100%; }
.footer-bar .fi {
    display:table-cell;
    vertical-align:top;
    font-size:9px;
    padding-right:28px;
}
.footer-bar .fi-label {
    font-size:7.5px;
    font-weight:bold;
    text-transform:uppercase;
    letter-spacing:0.6px;
    opacity:0.65;
    display:block;
    margin-bottom:1px;
}
.footer-bar .fi-val {
    font-size:9px;
    opacity:1;
}
</style>
</head>
<body>

{{-- ══ TOP DECORATION ══ --}}
<div class="deco-bar">
    <div class="deco-dot"></div>
    <div class="deco-pill"></div>
</div>

{{-- ══ BRAND ══ --}}
<div class="brand-wrap">
    <div class="row">
        <div class="col">
            @if($logoBase64)
                <img src="{{ $logoBase64 }}"
                     alt="{{ $company?->company_name ?? 'Logo' }}"
                     style="height:60px; width:auto; display:block;">
            @else
                <div class="brand-name">{{ strtoupper($company?->company_name ?? 'HASTANA INDONESIA') }}</div>
                <div class="brand-tagline">{{ $company?->company_name ?? 'Himpunan Perusahaan Penata Acara Seluruh Indonesia' }}</div>
            @endif
        </div>
    </div>
</div>

{{-- ══ INVOICE TITLE ══ --}}
<div class="invoice-title">INVOICE</div>

{{-- ══ BILL TO + META ══ --}}
<div class="bill-section">
    <div class="row">
        <div class="col" style="width:50%">
            <div class="label-sm">Invoice to:</div>
            <div class="name-lg">{{ $participant->name }}</div>
            <div class="text-muted">
                {{ $participant->email }}<br>
                {{ $participant->phone }}
                @if($participant->company)
                    <br>{{ $participant->company }}{{ $participant->position ? ', ' . $participant->position : '' }}
                @endif
            </div>
        </div>
        <div class="col-r" style="width:50%">
            <table class="meta-table">
                <tr>
                    <td class="ml">Invoice#</td>
                    <td class="mc">:</td>
                    <td class="mv">{{ strtoupper($participant->registration_code) }}</td>
                </tr>
                <tr>
                    <td class="ml">Tanggal</td>
                    <td class="mc">:</td>
                    <td class="mv">{{ $participant->created_at->format('d / m / Y') }}</td>
                </tr>
                <tr>
                    <td class="ml">Event</td>
                    <td class="mc">:</td>
                    <td class="mv">{{ $event->title }}</td>
                </tr>
                <tr>
                    <td class="ml">Tgl Event</td>
                    <td class="mc">:</td>
                    <td class="mv">{{ $event->start_date->format('d M Y') }}</td>
                </tr>
                <tr>
                    <td class="ml">Status</td>
                    <td class="mc">:</td>
                    <td class="mv">
                        <span class="badge" style="background:{{ $payBg[$participant->payment_status] ?? '#f3f4f6' }}; color:{{ $payColors[$participant->payment_status] ?? '#374151' }}">
                            {{ $payLabels[$participant->payment_status] ?? strtoupper($participant->payment_status) }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

{{-- ══ LINE ITEMS ══ --}}
<div class="items-wrap">
    <table class="items">
        <thead>
            <tr>
                <th style="width:48%">Item</th>
                <th style="width:12%" class="c">Qty</th>
                <th style="width:20%" class="r">Harga Satuan</th>
                <th style="width:20%" class="r">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    Tiket Event
                    <div class="sub">{{ $event->title }}</div>
                </td>
                <td class="c">1</td>
                <td class="r">
                    @if($isFree || $basePrice == 0) GRATIS
                    @else Rp {{ number_format($basePrice, 0, ',', '.') }}
                    @endif
                </td>
                <td class="r">
                    @if($isFree || $basePrice == 0) <span style="color:#16a34a">GRATIS</span>
                    @else Rp {{ number_format($basePrice, 0, ',', '.') }}
                    @endif
                </td>
            </tr>
            @foreach($participant->participantAddons as $addon)
            <tr>
                <td>
                    {{ $addon->eventAddon?->name ?? 'Add-on' }}
                    <div class="sub">{{ $addon->eventAddon?->description ?? 'Item tambahan' }}</div>
                </td>
                <td class="c">{{ $addon->quantity }}</td>
                <td class="r">Rp {{ number_format($addon->price_at_time, 0, ',', '.') }}</td>
                <td class="r">Rp {{ number_format($addon->quantity * $addon->price_at_time, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- ══ BOTTOM: PAYMENT METHOD + TOTALS ══ --}}
<div class="bottom-wrap">
    <div class="row">
        {{-- Payment Method --}}
        <div class="col" style="width:50%; padding-top:6px;">
            <div class="pay-method-title">Metode Pembayaran</div>
            <div class="pay-method-val">
                @if($participant->payment_method)
                    {{ $methods[$participant->payment_method] ?? strtoupper($participant->payment_method) }}
                @else
                    —
                @endif
                @if($participant->confirmed_at)
                    <br><span style="color:#9ca3af; font-size:8.5px;">Dikonfirmasi: {{ $participant->confirmed_at->format('d M Y, H:i') }} WIB</span>
                @endif
            </div>
        </div>

        {{-- Totals --}}
        <div class="col-r" style="width:50%">
            <table class="totals" style="margin-left:auto;">
                @if(!$isFree && $addonsTotal > 0)
                <tr class="sub-row">
                    <td>Harga Tiket</td>
                    <td>Rp {{ number_format($basePrice, 0, ',', '.') }}</td>
                </tr>
                <tr class="sub-row">
                    <td>Total Add-on</td>
                    <td>Rp {{ number_format($addonsTotal, 0, ',', '.') }}</td>
                </tr>
                @endif
                <tr class="line-row"><td colspan="2" style="padding:0; border-top:1.5px solid #e5e7eb;"></td></tr>
                <tr class="total-row">
                    <td>Total</td>
                    <td>
                        @if($isFree) <span style="color:#16a34a">GRATIS</span>
                        @else Rp {{ number_format($total, 0, ',', '.') }}
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

{{-- ══ THANK YOU ══ --}}
<div class="thankyou-wrap">
    <div class="row">
        <div class="col" style="width:55%; padding-top:8px;">
            <div class="thankyou-text">Terima kasih atas kepercayaan Anda!</div>
        </div>
        <div class="col-r" style="width:45%">
            <div class="signed-block">
                <div class="signed-line"></div>
                <div class="signed-label">Authorized Signed</div>
            </div>
        </div>
    </div>
</div>

{{-- ══ FOOTER BAR ══ --}}
<div class="footer-bar">
    <div class="row-inner">
        @if($company?->phone)
        <div class="fi">
            <span class="fi-label">Telepon</span>
            <span class="fi-val">{{ $company->phone }}</span>
        </div>
        @endif
        @if($company?->email)
        <div class="fi">
            <span class="fi-label">Email</span>
            <span class="fi-val">{{ $company->email }}</span>
        </div>
        @endif
        @if($company?->website)
        <div class="fi">
            <span class="fi-label">Website</span>
            <span class="fi-val">{{ $company->website }}</span>
        </div>
        @endif
        @if($company?->address ?? $company?->city ?? null)
        <div class="fi">
            <span class="fi-label">Alamat</span>
            <span class="fi-val">{{ $company?->address ?? $company?->city }}</span>
        </div>
        @endif
    </div>
</div>

</body>
</html>
