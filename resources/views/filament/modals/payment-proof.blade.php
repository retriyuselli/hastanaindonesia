<div class="space-y-4">
    <!-- Info Peserta -->
    <div class="bg-gray-50 rounded-lg p-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">Nama Peserta</p>
                <p class="font-semibold">{{ $record->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Email</p>
                <p class="font-semibold">{{ $record->email }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Metode Pembayaran</p>
                <p class="font-semibold">
                    @if($record->payment_method)
                        {{ strtoupper($record->payment_method) }}
                        @switch($record->payment_method)
                            @case('bca')
                                <span class="text-xs text-gray-500">(Bank BCA)</span>
                                @break
                            @case('mandiri')
                                <span class="text-xs text-gray-500">(Bank Mandiri)</span>
                                @break
                            @case('bni')
                                <span class="text-xs text-gray-500">(Bank BNI)</span>
                                @break
                            @case('bri')
                                <span class="text-xs text-gray-500">(Bank BRI)</span>
                                @break
                        @endswitch
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Status Pembayaran</p>
                <p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        @if($record->payment_status === 'paid') bg-green-100 text-green-800
                        @elseif($record->payment_status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($record->payment_status === 'free') bg-blue-100 text-blue-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        @switch($record->payment_status)
                            @case('paid')
                                Sudah Dibayar
                                @break
                            @case('pending')
                                Menunggu Pembayaran
                                @break
                            @case('free')
                                Gratis
                                @break
                            @default
                                {{ $record->payment_status }}
                        @endswitch
                    </span>
                </p>
            </div>
        </div>
    </div>

    <!-- Bukti Pembayaran -->
    <div>
        <h3 class="text-lg font-semibold mb-3">Bukti Transfer11</h3>
        <div class="border border-gray-200 rounded-lg overflow-hidden bg-gray-50">
            <img src="{{ $imageUrl }}" 
                 alt="Bukti Pembayaran {{ $record->name }}" 
                 class="w-full h-auto max-h-[600px] object-contain">
        </div>
        
        <!-- Link Download -->
        <div class="mt-3 flex justify-between items-center">
            <a href="{{ $imageUrl }}" 
               target="_blank" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
                Buka di Tab Baru
            </a>
            
            <a href="{{ $imageUrl }}" 
               download 
               class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Download
            </a>
        </div>
    </div>

    <!-- Timestamp Info -->
    <div class="bg-gray-50 rounded-lg p-3 text-xs text-gray-600">
        <div class="grid grid-cols-2 gap-2">
            <div>
                <span class="font-medium">Diunggah:</span> 
                {{ $record->created_at ? $record->created_at->format('d M Y, H:i') : '-' }}
            </div>
            @if($record->confirmed_at)
            <div>
                <span class="font-medium">Dikonfirmasi:</span> 
                {{ $record->confirmed_at->format('d M Y, H:i') }}
            </div>
            @endif
        </div>
    </div>
</div>
