@php
    use App\Models\EventHastana;

    $name          = $name ?? '-';
    $email         = $email ?? '-';
    $phone         = $phone ?? '-';
    $regCode       = $registrationCode ?? '-';
    $status        = $status ?? 'pending';
    $paymentStatus = $paymentStatus ?? 'free';

    $eventName     = null;
    $eventDate     = null;
    $eventEndDate  = null;
    $eventPrice    = null;
    $eventLocation = null;
    $eventCapacity = null;

    if (isset($eventId) && $eventId) {
        $event = EventHastana::find($eventId);
        if ($event) {
            $eventName     = $event->title;
            $eventDate     = $event->start_date->format('d M Y');
            $eventEndDate  = $event->end_date?->format('d M Y');
            $eventLocation = $event->location ?? null;
            $eventPrice    = $event->is_free ? 'GRATIS' : 'Rp ' . number_format($event->price, 0, ',', '.');
            $eventCapacity = ($event->current_participants ?? 0) . ' / ' . ($event->capacity ?? '∞') . ' peserta';
        }
    }

    // Avatar initials
    $initials = collect(explode(' ', $name))->take(2)->map(fn($w) => strtoupper(substr($w, 0, 1)))->join('');
    if ($initials === '-' || $initials === '') $initials = '?';

    $statusConfig = match($status) {
        'confirmed' => [
            'label'     => 'Confirmed',
            'sublabel'  => 'Sudah Dikonfirmasi',
            'emoji'     => '✅',
            'bg'        => 'bg-emerald-500',
            'light'     => 'bg-emerald-50',
            'text'      => 'text-emerald-700',
            'border'    => 'border-emerald-200',
            'dot'       => 'bg-emerald-400',
        ],
        'attended'  => [
            'label'     => 'Attended',
            'sublabel'  => 'Sudah Hadir',
            'emoji'     => '🎉',
            'bg'        => 'bg-sky-500',
            'light'     => 'bg-sky-50',
            'text'      => 'text-sky-700',
            'border'    => 'border-sky-200',
            'dot'       => 'bg-sky-400',
        ],
        'cancelled' => [
            'label'     => 'Cancelled',
            'sublabel'  => 'Pendaftaran Dibatalkan',
            'emoji'     => '❌',
            'bg'        => 'bg-rose-500',
            'light'     => 'bg-rose-50',
            'text'      => 'text-rose-700',
            'border'    => 'border-rose-200',
            'dot'       => 'bg-rose-400',
        ],
        default     => [
            'label'     => 'Pending',
            'sublabel'  => 'Menunggu Konfirmasi',
            'emoji'     => '⏳',
            'bg'        => 'bg-amber-400',
            'light'     => 'bg-amber-50',
            'text'      => 'text-amber-700',
            'border'    => 'border-amber-200',
            'dot'       => 'bg-amber-400',
        ],
    };

    $paymentConfig = match($paymentStatus) {
        'paid'     => ['label' => 'Lunas',    'sublabel' => 'Pembayaran Diterima', 'emoji' => '💳', 'light' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'dot' => 'bg-emerald-400'],
        'free'     => ['label' => 'Gratis',   'sublabel' => 'Tidak Ada Biaya',     'emoji' => '🎁', 'light' => 'bg-sky-50',     'text' => 'text-sky-700',     'border' => 'border-sky-200',     'dot' => 'bg-sky-400'],
        'refunded' => ['label' => 'Refunded', 'sublabel' => 'Dana Dikembalikan',   'emoji' => '↩️', 'light' => 'bg-purple-50',  'text' => 'text-purple-700',  'border' => 'border-purple-200',  'dot' => 'bg-purple-400'],
        default    => ['label' => 'Menunggu', 'sublabel' => 'Belum Dibayar',       'emoji' => '⏳', 'light' => 'bg-amber-50',   'text' => 'text-amber-700',   'border' => 'border-amber-200',   'dot' => 'bg-amber-400'],
    };

    $checklist = [
        ['label' => 'Data Peserta',  'desc' => $name !== '-' ? $name : 'Belum diisi',           'done' => $name !== '-',                               'pending' => false],
        ['label' => 'Event Dipilih', 'desc' => $eventName ?? 'Belum dipilih',                   'done' => !empty($eventId),                            'pending' => false],
        ['label' => 'Pembayaran',    'desc' => $paymentConfig['sublabel'],                       'done' => in_array($paymentStatus, ['paid', 'free']),  'pending' => $paymentStatus === 'pending'],
        ['label' => 'Konfirmasi',    'desc' => $statusConfig['sublabel'],                        'done' => in_array($status, ['confirmed', 'attended']), 'pending' => $status === 'pending'],
    ];

    $doneCount  = count(array_filter($checklist, fn($i) => $i['done']));
    $totalCount = count($checklist);
    $progress   = (int) round(($doneCount / $totalCount) * 100);
    $allDone    = $doneCount === $totalCount;

    // Avatar bg colors based on initials
    $avatarColors = ['bg-violet-500', 'bg-indigo-500', 'bg-sky-500', 'bg-teal-500', 'bg-emerald-500', 'bg-pink-500'];
    $avatarBg     = $avatarColors[ord($initials[0] ?? 'A') % count($avatarColors)];
@endphp

<div class="space-y-4 font-sans">

    {{-- ═══════════════════════════════════════════
         HERO BANNER — Event
    ═══════════════════════════════════════════ --}}
    <div class="relative overflow-hidden rounded-2xl bg-linear-to-br from-indigo-600 via-violet-600 to-purple-700 p-6 text-white shadow-lg">

        {{-- Decorative circles --}}
        <div class="pointer-events-none absolute -right-10 -top-10 h-44 w-44 rounded-full bg-white/10"></div>
        <div class="pointer-events-none absolute -bottom-6 right-20 h-24 w-24 rounded-full bg-white/5"></div>
        <div class="pointer-events-none absolute bottom-4 right-4 h-10 w-10 rounded-full bg-white/10"></div>
        <div class="pointer-events-none absolute left-1/2 top-0 h-px w-full bg-white/10"></div>

        <div class="relative">
            <div class="mb-1 flex items-center gap-2">
                <span class="inline-flex items-center gap-1 rounded-full bg-white/20 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-widest text-white/90">
                    🗓 Event
                </span>
            </div>

            <h2 class="mt-1 text-2xl font-extrabold leading-snug tracking-tight drop-shadow-sm">
                {{ $eventName ?? '—' }}
            </h2>

            <div class="mt-4 flex flex-wrap gap-2">
                @if($eventDate)
                    <span class="inline-flex items-center gap-1.5 rounded-xl bg-white/15 px-3 py-1.5 text-xs font-medium backdrop-blur-sm">
                        <svg class="h-3.5 w-3.5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ $eventDate }}{{ $eventEndDate && $eventEndDate !== $eventDate ? ' – ' . $eventEndDate : '' }}
                    </span>
                @endif
                @if($eventLocation)
                    <span class="inline-flex items-center gap-1.5 rounded-xl bg-white/15 px-3 py-1.5 text-xs font-medium backdrop-blur-sm">
                        <svg class="h-3.5 w-3.5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $eventLocation }}
                    </span>
                @endif
                @if($eventPrice)
                    <span class="inline-flex items-center gap-1.5 rounded-xl bg-white/15 px-3 py-1.5 text-xs font-medium backdrop-blur-sm">
                        <svg class="h-3.5 w-3.5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $eventPrice }}
                    </span>
                @endif
                @if($eventCapacity)
                    <span class="inline-flex items-center gap-1.5 rounded-xl bg-white/15 px-3 py-1.5 text-xs font-medium backdrop-blur-sm">
                        <svg class="h-3.5 w-3.5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $eventCapacity }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════
         BODY GRID
    ═══════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-5">

        {{-- ── LEFT COL (3/5): Peserta + Kode ── --}}
        <div class="space-y-4 lg:col-span-3">

            {{-- PROFILE CARD --}}
            <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
                {{-- Top color strip --}}
                <div class="h-2 bg-linear-to-r from-indigo-500 to-violet-500"></div>

                <div class="flex items-start gap-4 p-5">
                    {{-- Avatar --}}
                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl {{ $avatarBg }} text-xl font-extrabold text-white shadow-md">
                        {{ $initials }}
                    </div>

                    {{-- Info --}}
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-base font-bold text-gray-900">{{ $name }}</p>
                        <div class="mt-2 space-y-1.5">
                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                <svg class="h-4 w-4 shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <span class="truncate">{{ $email }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                <svg class="h-4 w-4 shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                <span>{{ $phone }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- REGISTRATION CODE --}}
            <div class="relative overflow-hidden rounded-2xl border border-indigo-100 bg-linear-to-br from-indigo-50 to-violet-50 p-5">
                {{-- Dashed separator (ticket style) --}}
                <div class="pointer-events-none absolute inset-y-0 right-20 flex flex-col justify-between py-3">
                    @for ($i = 0; $i < 8; $i++)
                        <div class="h-1.5 w-px bg-indigo-200"></div>
                    @endfor
                </div>

                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="mb-1 text-[10px] font-bold uppercase tracking-widest text-indigo-400">Kode Registrasi</p>
                        <p class="font-mono text-2xl font-extrabold tracking-widest text-indigo-700">{{ $regCode }}</p>
                    </div>
                    <div class="flex shrink-0 flex-col items-center gap-1 text-indigo-300">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                        <span class="text-[9px] font-bold uppercase tracking-wider">Scan</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── RIGHT COL (2/5): Status + Progress ── --}}
        <div class="space-y-4 lg:col-span-2">

            {{-- STATUS CARDS --}}
            <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                <p class="mb-4 text-[10px] font-bold uppercase tracking-widest text-gray-400">Status</p>

                {{-- Registration status --}}
                <div class="mb-3 overflow-hidden rounded-xl border {{ $statusConfig['border'] }} {{ $statusConfig['light'] }}">
                    <div class="flex items-center gap-3 p-3">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl {{ $statusConfig['bg'] }} text-lg shadow-sm">
                            {{ $statusConfig['emoji'] }}
                        </div>
                        <div>
                            <p class="text-[10px] font-semibold uppercase tracking-wide {{ $statusConfig['text'] }} opacity-70">Pendaftaran</p>
                            <p class="text-sm font-bold {{ $statusConfig['text'] }}">{{ $statusConfig['label'] }}</p>
                        </div>
                        <div class="ml-auto h-2 w-2 animate-pulse rounded-full {{ $statusConfig['dot'] }}"></div>
                    </div>
                </div>

                {{-- Payment status --}}
                <div class="overflow-hidden rounded-xl border {{ $paymentConfig['border'] }} {{ $paymentConfig['light'] }}">
                    <div class="flex items-center gap-3 p-3">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-lg shadow-sm border {{ $paymentConfig['border'] }}">
                            {{ $paymentConfig['emoji'] }}
                        </div>
                        <div>
                            <p class="text-[10px] font-semibold uppercase tracking-wide {{ $paymentConfig['text'] }} opacity-70">Pembayaran</p>
                            <p class="text-sm font-bold {{ $paymentConfig['text'] }}">{{ $paymentConfig['label'] }}</p>
                        </div>
                        <div class="ml-auto h-2 w-2 rounded-full {{ $paymentConfig['dot'] }}"></div>
                    </div>
                </div>
            </div>

            {{-- PROGRESS / CHECKLIST --}}
            <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                {{-- Header --}}
                <div class="mb-4 flex items-center justify-between">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Progress</p>
                    <span class="rounded-full {{ $allDone ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }} px-2 py-0.5 text-xs font-bold">
                        {{ $doneCount }}/{{ $totalCount }}
                    </span>
                </div>

                {{-- Bar --}}
                <div class="mb-5 h-2 w-full overflow-hidden rounded-full bg-gray-100">
                    <div class="h-2 rounded-full transition-all duration-500 {{ $allDone ? 'bg-linear-to-r from-emerald-400 to-teal-400' : 'bg-linear-to-r from-indigo-400 to-violet-400' }}"
                         style="width: {{ $progress }}%"></div>
                </div>

                {{-- Steps with connector lines --}}
                <div class="space-y-0">
                    @foreach($checklist as $i => $item)
                        <div class="flex gap-3">
                            {{-- Icon + line --}}
                            <div class="flex flex-col items-center">
                                @if($item['done'])
                                    <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-emerald-500 shadow-sm">
                                        <svg class="h-3.5 w-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                @elseif($item['pending'])
                                    <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-amber-400 shadow-sm">
                                        <svg class="h-3.5 w-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                @else
                                    <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 border-gray-200 bg-gray-50">
                                        <div class="h-1.5 w-1.5 rounded-full bg-gray-300"></div>
                                    </div>
                                @endif
                                @if(!$loop->last)
                                    <div class="my-0.5 w-px flex-1 {{ $item['done'] ? 'bg-emerald-200' : 'bg-gray-150' }}" style="min-height:16px; background-color: {{ $item['done'] ? '#a7f3d0' : '#f1f5f9' }}"></div>
                                @endif
                            </div>

                            {{-- Label --}}
                            <div class="pb-4 pt-0.5 min-w-0">
                                <p class="text-sm font-semibold {{ $item['done'] ? 'text-gray-800' : ($item['pending'] ? 'text-amber-700' : 'text-gray-400') }}">
                                    {{ $item['label'] }}
                                </p>
                                <p class="truncate text-xs {{ $item['done'] ? 'text-gray-400' : ($item['pending'] ? 'text-amber-500' : 'text-gray-300') }}">
                                    {{ $item['desc'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($allDone)
                    <div class="mt-1 flex items-center justify-center gap-2 rounded-xl bg-linear-to-r from-emerald-50 to-teal-50 border border-emerald-100 px-4 py-2.5">
                        <span class="text-emerald-500">🎉</span>
                        <span class="text-xs font-bold text-emerald-700">Semua proses selesai!</span>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
