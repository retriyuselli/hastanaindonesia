<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: sans-serif; font-size: 9px; color: #1a1a1a; }

    .header { background: #dc2626; color: #fff; padding: 12px 16px; margin-bottom: 12px; }
    .header h1 { font-size: 16px; font-weight: bold; margin-bottom: 2px; }
    .header p { font-size: 9px; opacity: 0.85; }
    .header .meta { float: right; text-align: right; font-size: 9px; }

    table { width: 100%; border-collapse: collapse; }
    thead tr { background: #1f2937; color: #fff; }
    thead th { padding: 5px 6px; text-align: left; font-size: 8.5px; white-space: nowrap; }
    tbody tr:nth-child(even) { background: #fef2f2; }
    tbody tr:nth-child(odd) { background: #ffffff; }
    tbody td { padding: 4px 6px; border-bottom: 1px solid #e5e7eb; vertical-align: top; }

    .badge { display: inline-block; padding: 1px 5px; border-radius: 3px; font-size: 8px; font-weight: bold; }
    .badge-green { background: #dcfce7; color: #166534; }
    .badge-yellow { background: #fef9c3; color: #854d0e; }
    .badge-red { background: #fee2e2; color: #991b1b; }
    .badge-gray { background: #f3f4f6; color: #374151; }

    .footer { margin-top: 10px; font-size: 8px; color: #6b7280; text-align: center; }
</style>
</head>
<body>

<div class="header">
    <div class="meta">
        Dicetak: {{ $generatedAt }}<br>
        Total: {{ $total }} data
    </div>
    <h1>Data Wedding Organizer</h1>
    <p>HASTANA Indonesia — Himpunan Perusahaan Penata Acara Seluruh Indonesia</p>
</div>

<table>
    <thead>
        <tr>
            <th style="width:25px">No</th>
            <th>No Anggota</th>
            <th>Nama Organizer</th>
            <th>Email</th>
            <th>Telepon</th>
            <th>Kota</th>
            <th>Provinsi</th>
            <th>Level Sertifikasi</th>
            <th>Status Verifikasi</th>
            <th>Status</th>
            <th>Terdaftar</th>
        </tr>
    </thead>
    <tbody>
        @foreach($records as $i => $wo)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $wo->user->no_anggota ?? '-' }}</td>
            <td><strong>{{ $wo->organizer_name }}</strong>
                @if($wo->brand_name && $wo->brand_name !== $wo->organizer_name)
                    <br><span style="color:#6b7280">{{ $wo->brand_name }}</span>
                @endif
            </td>
            <td>{{ $wo->email ?? '-' }}</td>
            <td>{{ $wo->phone ?? '-' }}</td>
            <td>{{ $wo->city ?? '-' }}</td>
            <td>{{ $wo->province ?? '-' }}</td>
            <td>{{ $wo->certification_level ?? '-' }}</td>
            <td>
                @if($wo->verification_status === 'verified')
                    <span class="badge badge-green">Terverifikasi</span>
                @elseif($wo->verification_status === 'pending')
                    <span class="badge badge-yellow">Menunggu</span>
                @elseif($wo->verification_status === 'rejected')
                    <span class="badge badge-red">Ditolak</span>
                @else
                    <span class="badge badge-gray">{{ $wo->verification_status ?? '-' }}</span>
                @endif
            </td>
            <td>
                @if($wo->is_active)
                    <span class="badge badge-green">Aktif</span>
                @else
                    <span class="badge badge-gray">Nonaktif</span>
                @endif
            </td>
            <td>{{ $wo->created_at?->format('d/m/Y') ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">
    Dokumen ini digenerate otomatis oleh sistem HASTANA Indonesia pada {{ $generatedAt }}
</div>

</body>
</html>
