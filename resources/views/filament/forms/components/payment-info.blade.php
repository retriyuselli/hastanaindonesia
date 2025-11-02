@php
    use App\Models\EventHastana;
    
    $event = null;
    if (isset($eventId) && $eventId) {
        $event = EventHastana::find($eventId);
    }
@endphp

@if(!$eventId)
    <div class="text-sm text-gray-500">
        Pilih event terlebih dahulu
    </div>
@elseif(!$event)
    <div class="text-sm text-gray-500">
        Event tidak ditemukan
    </div>
@else
    <div class="bg-linear-to-r from-blue-50 to-indigo-50 p-4 rounded-lg border border-blue-200">
        <div class="space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="font-medium text-gray-700">Harga Event:</span>
                <span class="font-bold text-blue-900">
                    {{ $event->is_free ? 'GRATIS' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                </span>
            </div>
            <div class="flex justify-between">
                <span class="font-medium text-gray-700">Tipe Event:</span>
                <span class="font-semibold text-gray-900">
                    {{ $event->is_free ? '🎁 Gratis' : '💰 Berbayar' }}
                </span>
            </div>
            <div class="flex justify-between pt-2 border-t border-blue-300">
                <span class="font-bold text-gray-800">Total Pembayaran:</span>
                <span class="font-bold text-lg text-blue-700">
                    {{ $event->is_free ? 'GRATIS' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                </span>
            </div>
        </div>
    </div>
@endif
