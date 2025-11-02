@php
    use App\Models\EventHastana;
    
    $name = $name ?? '-';
    $email = $email ?? '-';
    $phone = $phone ?? '-';
    $regCode = $registrationCode ?? '-';
    $status = $status ?? 'pending';
    $paymentStatus = $paymentStatus ?? 'free';
    
    $eventName = '-';
    $eventDate = '-';
    $eventPrice = '-';
    
    if (isset($eventId) && $eventId) {
        $event = EventHastana::find($eventId);
        if ($event) {
            $eventName = $event->title;
            $eventDate = $event->start_date->format('d M Y');
            $eventPrice = $event->is_free ? 'GRATIS' : 'Rp ' . number_format($event->price, 0, ',', '.');
        }
    }
@endphp

<div class="bg-linear-to-br from-slate-50 to-gray-100 p-6 rounded-xl border-2 border-gray-200">
    <div class="grid grid-cols-2 gap-6">
        <!-- Left Column -->
        <div class="space-y-4">
            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase mb-1">Event</h3>
                <p class="text-lg font-bold text-gray-900">{{ $eventName }}</p>
                <p class="text-sm text-gray-600">📅 {{ $eventDate }} | 💰 {{ $eventPrice }}</p>
            </div>
            
            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase mb-1">Peserta</h3>
                <p class="text-base font-bold text-gray-900">{{ $name }}</p>
                <p class="text-sm text-gray-600">📧 {{ $email }}</p>
                <p class="text-sm text-gray-600">📱 {{ $phone }}</p>
            </div>
            
            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase mb-1">Kode Registrasi</h3>
                <p class="text-base font-mono font-bold text-blue-700 bg-blue-50 px-3 py-1 rounded inline-block">{{ $regCode }}</p>
            </div>
        </div>
        
        <!-- Right Column -->
        <div class="space-y-4">
            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase mb-2">Status</h3>
                <div class="space-y-2">
                    <div>
                        <span class="text-xs text-gray-600">Pendaftaran:</span><br>
                        @switch($status)
                            @case('confirmed')
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full font-semibold">✅ Confirmed</span>
                                @break
                            @case('attended')
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full font-semibold">🎉 Attended</span>
                                @break
                            @case('cancelled')
                                <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full font-semibold">❌ Cancelled</span>
                                @break
                            @default
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full font-semibold">⏳ Pending</span>
                        @endswitch
                    </div>
                    <div>
                        <span class="text-xs text-gray-600">Pembayaran:</span><br>
                        @switch($paymentStatus)
                            @case('paid')
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full font-semibold">✅ Paid</span>
                                @break
                            @case('free')
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full font-semibold">🎁 Free</span>
                                @break
                            @case('refunded')
                                <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full font-semibold">↩️ Refunded</span>
                                @break
                            @default
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full font-semibold">⏳ Pending</span>
                        @endswitch
                    </div>
                </div>
            </div>
            
            <div class="mt-6 p-4 bg-white rounded-lg border border-gray-300">
                <h4 class="text-sm font-bold text-gray-700 mb-2">📋 Checklist</h4>
                <div class="space-y-1 text-sm">
                    <div class="flex items-center gap-2">
                        @if($name && $name !== '-')
                            <span class="text-green-600">✓</span>
                            <span class="text-gray-700">Data Peserta</span>
                        @else
                            <span class="text-red-600">✗</span>
                            <span class="text-gray-400">Data Peserta</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2">
                        @if(isset($eventId) && $eventId)
                            <span class="text-green-600">✓</span>
                            <span class="text-gray-700">Event Dipilih</span>
                        @else
                            <span class="text-red-600">✗</span>
                            <span class="text-gray-400">Event Dipilih</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2">
                        @if(in_array($paymentStatus, ['paid', 'free']))
                            <span class="text-green-600">✓</span>
                            <span class="text-gray-700">Pembayaran</span>
                        @else
                            <span class="text-yellow-600">⏳</span>
                            <span class="text-gray-400">Pembayaran</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2">
                        @if(in_array($status, ['confirmed', 'attended']))
                            <span class="text-green-600">✓</span>
                            <span class="text-gray-700">Konfirmasi</span>
                        @else
                            <span class="text-yellow-600">⏳</span>
                            <span class="text-gray-400">Konfirmasi</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
