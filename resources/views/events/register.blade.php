@extends('layouts.app')

@section('title', 'Daftar Event: ' . $event->title)

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-gray-900 to-black text-white py-12 mt-20">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-3xl md:text-4xl font-bold mb-2">Daftar Event</h1>
            <p class="text-xl text-gray-300">{{ $event->title }}</p>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Registration Form -->
                <div class="lg:w-2/3">
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Form Pendaftaran</h2>

                        @if(session('error'))
                            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ session('error') }}</span>
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('events.register.store', $event->slug) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            @php
                                // Cek apakah user sudah terdaftar di event ini (di awal form)
                                $isAlreadyRegistered = false;
                                $registeredData = null;
                                if (auth()->check()) {
                                    $registeredData = \App\Models\EventParticipant::where('event_hastana_id', $event->id)
                                        ->where(function($query) {
                                            $query->where('user_id', auth()->id())
                                                  ->orWhere('email', auth()->user()->email);
                                        })
                                        ->whereIn('status', ['pending', 'confirmed', 'attended'])
                                        ->first();
                                    $isAlreadyRegistered = $registeredData !== null;
                                }
                            @endphp

                            @if($isAlreadyRegistered)
                                <div class="bg-gray-50 border border-gray-200 text-gray-800 px-4 py-3 rounded-lg mb-6">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-info-circle"></i>
                                        <span class="font-semibold">Anda sudah terdaftar di event ini. Data pendaftaran tidak dapat diubah.</span>
                                    </div>
                                </div>
                            @endif

                            <!-- Personal Information -->
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                    <i class="fas fa-user text-hastana-red"></i>
                                    Data Pribadi
                                </h3>

                                <!-- Name -->
                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           name="name" 
                                           id="name"
                                           value="{{ $isAlreadyRegistered ? $registeredData->name : old('name', auth()->user()->name ?? '') }}"
                                           {{ $isAlreadyRegistered ? 'readonly' : 'required' }}
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-hastana-red focus:border-transparent {{ $isAlreadyRegistered ? 'bg-gray-100 cursor-not-allowed' : '' }} @error('name') border-red-500 @enderror"
                                           placeholder="Masukkan nama lengkap Anda">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="mb-4">
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" 
                                           name="email" 
                                           id="email"
                                           value="{{ $isAlreadyRegistered ? $registeredData->email : old('email', auth()->user()->email ?? '') }}"
                                           {{ $isAlreadyRegistered ? 'readonly' : 'required' }}
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-hastana-red focus:border-transparent {{ $isAlreadyRegistered ? 'bg-gray-100 cursor-not-allowed' : '' }} @error('email') border-red-500 @enderror"
                                           placeholder="nama@email.com">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div class="mb-4">
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nomor Telepon/WhatsApp <span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel" 
                                           name="phone" 
                                           id="phone"
                                           value="{{ $isAlreadyRegistered ? $registeredData->phone : old('phone', auth()->user()->phone ?? '') }}"
                                           {{ $isAlreadyRegistered ? 'readonly' : 'required' }}
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-hastana-red focus:border-transparent {{ $isAlreadyRegistered ? 'bg-gray-100 cursor-not-allowed' : '' }} @error('phone') border-red-500 @enderror"
                                           placeholder="08xxxxxxxxxx">
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Professional Information (Optional) -->
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                    <i class="fas fa-briefcase text-hastana-red"></i>
                                    Data Pekerjaan (Opsional)
                                </h3>

                                @php
                                    // Ambil data profesional dari pendaftaran event terakhir user
                                    $lastParticipant = null;
                                    $defaultCompany = '';
                                    $defaultPosition = '';
                                    
                                    if (auth()->check()) {
                                        if ($isAlreadyRegistered && $registeredData) {
                                            // Jika sudah terdaftar, gunakan data dari registrasi ini
                                            $defaultCompany = $registeredData->company;
                                            $defaultPosition = $registeredData->position;
                                        } else {
                                            // Jika belum terdaftar, cari dari pendaftaran event lain
                                            $lastParticipant = \App\Models\EventParticipant::where(function($query) {
                                                    $query->where('user_id', auth()->id())
                                                          ->orWhere('email', auth()->user()->email);
                                                })
                                                ->where(function($query) {
                                                    $query->whereNotNull('company')
                                                          ->orWhereNotNull('position');
                                                })
                                                ->orderBy('created_at', 'desc')
                                                ->first();
                                            
                                            if ($lastParticipant) {
                                                $defaultCompany = $lastParticipant->company;
                                                $defaultPosition = $lastParticipant->position;
                                            }
                                        }
                                    }
                                @endphp

                                <!-- Company -->
                                <div class="mb-4">
                                    <label for="company" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Perusahaan/Instansi
                                    </label>
                                    <input type="text" 
                                           name="company" 
                                           id="company"
                                           value="{{ old('company', $defaultCompany) }}"
                                           {{ $isAlreadyRegistered ? 'readonly' : '' }}
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-hastana-red focus:border-transparent {{ $isAlreadyRegistered ? 'bg-gray-100 cursor-not-allowed' : '' }} @error('company') border-red-500 @enderror"
                                           placeholder="PT. Nama Perusahaan">
                                    @error('company')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Position -->
                                <div class="mb-4">
                                    <label for="position" class="block text-sm font-medium text-gray-700 mb-2">
                                        Jabatan/Posisi
                                    </label>
                                    <input type="text" 
                                           name="position" 
                                           id="position"
                                           value="{{ old('position', $defaultPosition) }}"
                                           {{ $isAlreadyRegistered ? 'readonly' : '' }}
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-hastana-red focus:border-transparent {{ $isAlreadyRegistered ? 'bg-gray-100 cursor-not-allowed' : '' }} @error('position') border-red-500 @enderror"
                                           placeholder="Manajer, Staff, dll">
                                    @error('position')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Additional Notes -->
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                    <i class="fas fa-comment text-hastana-red"></i>
                                    Catatan Tambahan
                                </h3>

                                @php
                                    // Ambil notes dari pendaftaran
                                    $defaultNotes = '';
                                    if (auth()->check()) {
                                        if ($isAlreadyRegistered && $registeredData) {
                                            // Jika sudah terdaftar, gunakan notes dari registrasi ini
                                            $defaultNotes = $registeredData->notes ?? '';
                                        } elseif (isset($lastParticipant) && $lastParticipant) {
                                            // Jika belum terdaftar, gunakan notes dari pendaftaran terakhir
                                            $defaultNotes = $lastParticipant->notes ?? '';
                                        }
                                    }
                                @endphp

                                <div class="mb-4">
                                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                        Pesan/Pertanyaan (Opsional)
                                    </label>
                                    <textarea name="notes" 
                                              id="notes" 
                                              rows="4"
                                              {{ $isAlreadyRegistered ? 'readonly' : '' }}
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-hastana-red focus:border-transparent {{ $isAlreadyRegistered ? 'bg-gray-100 cursor-not-allowed' : '' }} @error('notes') border-red-500 @enderror"
                                              placeholder="Sampaikan pertanyaan atau informasi tambahan...">{{ old('notes', $defaultNotes) }}</textarea>
                                    @error('notes')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Addon Section -->
                            @if($event->activeAddons->count() > 0 && !$isAlreadyRegistered)
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                        <i class="fas fa-plus-circle text-hastana-red"></i>
                                        Pilihan Addon <span class="text-sm font-normal text-gray-500">(Opsional)</span>
                                    </h3>
                                    <div class="space-y-3">
                                        @foreach($event->activeAddons as $addon)
                                            @php $remaining = $addon->remaining_quota; @endphp
                                            <div class="border border-gray-200 rounded-lg p-4 {{ $remaining !== null && $remaining <= 0 ? 'opacity-50' : '' }}">
                                                <div class="flex items-start justify-between gap-4">
                                                    <div class="flex-1">
                                                        <div class="flex items-center gap-2 mb-1">
                                                            <span class="font-semibold text-gray-900">{{ $addon->name }}</span>
                                                            @if($remaining !== null)
                                                                <span class="text-xs px-2 py-0.5 rounded-full {{ $remaining <= 0 ? 'bg-red-100 text-red-600' : ($remaining <= 5 ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') }}">
                                                                    {{ $remaining <= 0 ? 'Habis' : "Sisa {$remaining}" }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                        @if($addon->description)
                                                            <p class="text-sm text-gray-500 mb-2">{{ $addon->description }}</p>
                                                        @endif
                                                        <span class="text-hastana-red font-bold">{{ $addon->formatted_price }}</span>
                                                        <span class="text-gray-400 text-sm"> / item</span>
                                                    </div>
                                                    <div class="flex items-center gap-2 shrink-0">
                                                        <input type="hidden" name="addons[{{ $loop->index }}][id]" value="{{ $addon->id }}">
                                                        <button type="button"
                                                                onclick="changeAddonQty({{ $loop->index }}, -1)"
                                                                class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center font-bold text-gray-600 transition">−</button>
                                                        <input type="number"
                                                               id="addon_qty_{{ $loop->index }}"
                                                               name="addons[{{ $loop->index }}][qty]"
                                                               value="0"
                                                               min="0"
                                                               max="{{ $remaining !== null ? $remaining : 99 }}"
                                                               data-price="{{ $addon->price }}"
                                                               data-index="{{ $loop->index }}"
                                                               {{ $remaining !== null && $remaining <= 0 ? 'disabled' : '' }}
                                                               onchange="recalcTotal()"
                                                               class="w-14 text-center border border-gray-300 rounded-lg py-1 font-semibold text-gray-900 focus:ring-2 focus:ring-hastana-red">
                                                        <button type="button"
                                                                onclick="changeAddonQty({{ $loop->index }}, 1, {{ $remaining !== null ? $remaining : 99 }})"
                                                                {{ $remaining !== null && $remaining <= 0 ? 'disabled' : '' }}
                                                                class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center font-bold text-gray-600 transition">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Payment Section (paid event OR addon berbayar dipilih) -->
                            @if(!$isAlreadyRegistered)
                            <div id="payment-section" class="{{ $event->is_free ? 'hidden' : '' }}">
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                        <i class="fas fa-credit-card text-hastana-red"></i>
                                        Informasi Pembayaran
                                    </h3>

                                    <!-- Price Breakdown -->
                                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-4 space-y-2 text-sm">
                                        <div class="flex justify-between text-gray-600">
                                            <span>Harga Tiket</span>
                                            <span id="breakdown-base">{{ $event->is_free ? 'GRATIS' : 'Rp ' . number_format($event->price, 0, ',', '.') }}</span>
                                        </div>
                                        <div id="breakdown-addons"></div>
                                        <div class="border-t border-gray-300 pt-2 flex justify-between items-center">
                                            <span class="font-semibold text-gray-900">Total Pembayaran</span>
                                            <span id="breakdown-total" class="text-xl font-bold text-hastana-red">
                                                {{ $event->is_free ? 'GRATIS' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Bank Transfer Information -->
                                    <div class="bg-white border border-gray-300 rounded-lg p-4 mb-4">
                                        <h4 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                                            <i class="fas fa-university text-hastana-red"></i>
                                            Informasi Rekening Bank
                                        </h4>
                                        <div class="space-y-3 text-sm">
                                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                                <div>
                                                    <p class="text-xs text-gray-500">Bank BCA</p>
                                                    <p class="font-semibold text-gray-900">2910777800</p>
                                                    <p class="text-xs text-gray-600">an/ Perk Hastana Indonesia</p>
                                                </div>
                                                <button type="button" onclick="copyToClipboard('2910777800')" class="text-hastana-red hover:text-red-700">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="mt-3 p-3 bg-gray-50 border border-gray-200 rounded-lg">
                                            <p class="text-xs text-gray-800">
                                                <i class="fas fa-info-circle mr-1"></i>
                                                Silakan transfer sesuai jumlah yang tertera dan upload bukti pembayaran di bawah ini.
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Payment Method -->
                                    <div class="mb-4">
                                        <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">
                                            Metode Pembayaran <span class="text-red-500">*</span>
                                        </label>
                                        <select name="payment_method" id="payment_method"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-hastana-red focus:border-transparent @error('payment_method') border-red-500 @enderror">
                                            <option value="">Pilih Metode Pembayaran</option>
                                            <option value="bca" {{ old('payment_method') == 'bca' ? 'selected' : '' }}>Transfer Bank BCA</option>
                                        </select>
                                        @error('payment_method')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Payment Proof Upload -->
                                    <div class="mb-4">
                                        <label for="payment_proof" class="block text-sm font-medium text-gray-700 mb-2">
                                            Bukti Pembayaran <span class="text-red-500">*</span>
                                        </label>
                                        <div class="flex items-center justify-center w-full">
                                            <label for="payment_proof" class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                    <i class="fas fa-cloud-upload-alt text-gray-400 text-4xl mb-3"></i>
                                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span> atau drag & drop</p>
                                                    <p class="text-xs text-gray-500">PNG, JPG, JPEG (MAX. 2MB)</p>
                                                    <p id="file-name" class="mt-2 text-sm text-hastana-red font-semibold"></p>
                                                </div>
                                                <input id="payment_proof" name="payment_proof" type="file"
                                                       accept="image/png,image/jpeg,image/jpg"
                                                       class="hidden" onchange="displayFileName(this)">
                                            </label>
                                        </div>
                                        @error('payment_proof')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-2 text-xs text-gray-500">
                                            <i class="fas fa-info-circle mr-1"></i>
                                            Upload screenshot atau foto bukti transfer Anda
                                        </p>
                                    </div>

                                    <!-- Preview Image -->
                                    <div id="preview-container" class="mb-4 hidden">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Preview Bukti Pembayaran:</label>
                                        <div class="relative inline-block">
                                            <img id="preview-image" src="" alt="Preview" class="max-w-full h-auto rounded-lg border border-gray-300 max-h-64">
                                            <button type="button" onclick="removeImage()" class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-8 h-8 flex items-center justify-center hover:bg-red-600">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if(!$event->is_free && $isAlreadyRegistered && $registeredData && $registeredData->payment_proof)
                                <!-- Display Payment Proof for Already Registered Users -->
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                        <i class="fas fa-receipt text-hastana-red"></i>
                                        Bukti Pembayaran Anda
                                    </h3>
                                    <div class="bg-gray-50 border border-gray-300 rounded-lg p-4">
                                        <div class="mb-2">
                                            <span class="text-sm text-gray-600">Metode Pembayaran: </span>
                                            <span class="font-semibold">{{ strtoupper($registeredData->payment_method ?? '-') }}</span>
                                        </div>
                                        <img src="{{ Storage::url($registeredData->payment_proof) }}"
                                             alt="Bukti Pembayaran"
                                             class="max-w-full h-auto rounded-lg border border-gray-300 max-h-64">
                                    </div>
                                </div>
                            @endif

                            <!-- Terms & Conditions -->
                            <div class="mb-6">
                                <label class="flex items-start gap-3 {{ $isAlreadyRegistered ? 'cursor-not-allowed' : 'cursor-pointer' }}">
                                    <input type="checkbox" 
                                           name="agree_terms" 
                                           id="agree_terms"
                                           {{ $isAlreadyRegistered ? 'checked disabled' : 'required' }}
                                           class="mt-1 w-5 h-5 text-hastana-red border-gray-300 rounded focus:ring-2 focus:ring-hastana-red">
                                    <span class="text-sm text-gray-700">
                                        Saya menyetujui <a href="{{ route('terms') }}" target="_blank" class="text-hastana-red hover:underline">syarat dan ketentuan</a> 
                                        serta <a href="{{ route('privacy') }}" target="_blank" class="text-hastana-red hover:underline">kebijakan privasi</a> 
                                        yang berlaku. <span class="text-red-500">*</span>
                                    </span>
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex gap-4">
                                @if($isAlreadyRegistered)
                                    <button type="button" 
                                            disabled
                                            class="flex-1 bg-gray-400 text-white py-4 px-6 rounded-lg font-bold cursor-not-allowed">
                                        <i class="fas fa-check-circle mr-2"></i> Anda Sudah Terdaftar
                                    </button>
                                @else
                                    <button type="submit" 
                                            class="flex-1 bg-hastana-red text-white py-4 px-6 rounded-lg font-bold hover:bg-red-700 transition duration-200 shadow-lg hover:shadow-xl">
                                        <i class="fas fa-check-circle mr-2"></i> Daftar Sekarang
                                    </button>
                                @endif
                                <a href="{{ route('events.show', $event->slug) }}" 
                                   class="px-6 py-4 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition duration-200">
                                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Event Summary Sidebar -->
                <div class="lg:w-1/3">
                    <div class="bg-white rounded-lg shadow-lg p-6 sticky top-24">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Ringkasan Event</h3>

                        <!-- Event Image -->
                        @if($event->image)
                            <img src="{{ Storage::url($event->image) }}"
                                 alt="{{ $event->title }}"
                                 class="w-full h-auto object-contain rounded-lg mb-4">
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-gray-700 to-gray-900 rounded-lg flex items-center justify-center mb-4">
                                <i class="fas fa-calendar-alt text-white text-6xl"></i>
                            </div>
                        @endif

                        <!-- Event Title -->
                        <h4 class="font-bold text-gray-900 mb-4 text-lg">{{ $event->title }}</h4>

                        <!-- Event Details -->
                        <div class="space-y-3 text-sm">
                            <!-- Category -->
                            <div class="flex items-center gap-2">
                                <i class="fas fa-tag text-hastana-red w-5"></i>
                                <span>{{ $event->eventCategory->name ?? 'Umum' }}</span>
                            </div>

                            <!-- Date -->
                            <div class="flex items-center gap-2">
                                <i class="fas fa-calendar-alt text-hastana-red w-5"></i>
                                <span>{{ $event->start_date->format('d M Y') }}</span>
                            </div>

                            <!-- Time -->
                            <div class="flex items-center gap-2">
                                <i class="fas fa-clock text-hastana-red w-5"></i>
                                <span>{{ $event->start_time ? $event->start_time->format('H:i') . ' WIB' : '-' }}</span>
                            </div>

                            <!-- Location -->
                            <div class="flex items-start gap-2">
                                <i class="fas fa-map-marker-alt text-hastana-red w-5 mt-1"></i>
                                <span>{{ $event->venue }}, {{ $event->city }}</span>
                            </div>

                            <!-- Type -->
                            <div class="flex items-center gap-2">
                                <i class="fas fa-info-circle text-hastana-red w-5"></i>
                                <span>{{ ucfirst($event->event_type) }}</span>
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="mt-6 pt-6 border-t border-gray-200 space-y-1 text-sm">
                            <div class="flex justify-between text-gray-500">
                                <span>Harga Tiket</span>
                                <span>{{ $event->is_free ? 'GRATIS' : 'Rp ' . number_format($event->price, 0, ',', '.') }}</span>
                            </div>
                            <div id="sidebar-addon-lines"></div>
                            <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                                <span class="font-semibold text-gray-700">Total</span>
                                <span id="sidebar-total" class="text-xl font-bold text-hastana-red">
                                    {{ $event->is_free ? 'GRATIS' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <!-- Remaining Quota -->
                        @if($event->capacity)
                            <div class="mt-4 bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-semibold text-gray-800">Sisa Kuota</span>
                                    <span class="text-lg font-bold text-hastana-red">{{ $event->remaining_quota }} slot</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-hastana-red h-2 rounded-full transition-all duration-300" 
                                         style="width: {{ min($event->capacity_percentage, 100) }}%"></div>
                                </div>
                                <p class="text-xs text-gray-700 mt-2">
                                    {{ $event->current_participants }} dari {{ $event->capacity }} peserta terdaftar
                                </p>
                            </div>
                        @endif

                        <!-- Security Note -->
                        <div class="mt-6 bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <div class="flex items-start gap-2 text-sm text-gray-800">
                                <i class="fas fa-shield-alt mt-0.5"></i>
                                <div>
                                    <div class="font-semibold mb-1">Data Anda Aman</div>
                                    <div class="text-xs">Informasi pribadi Anda dilindungi dan tidak akan disebarkan.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Display file name when selected
    function displayFileName(input) {
        const fileName = input.files[0]?.name;
        const fileNameElement = document.getElementById('file-name');
        const previewContainer = document.getElementById('preview-container');
        const previewImage = document.getElementById('preview-image');
        
        if (fileName) {
            fileNameElement.textContent = '📎 ' + fileName;
            
            // Show preview if it's an image
            const file = input.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }
    }
    
    // Remove selected image
    function removeImage() {
        const input = document.getElementById('payment_proof');
        const fileNameElement = document.getElementById('file-name');
        const previewContainer = document.getElementById('preview-container');
        
        input.value = '';
        fileNameElement.textContent = '';
        previewContainer.classList.add('hidden');
    }
    
    // ── Addon kalkulasi harga ──────────────────────────────────────
    const BASE_PRICE = {{ (float) $event->price }};

    function changeAddonQty(index, delta, max) {
        const input = document.getElementById('addon_qty_' + index);
        if (!input) return;
        let val = parseInt(input.value || '0') + delta;
        val = Math.max(0, val);
        if (max !== undefined) val = Math.min(max, val);
        input.value = val;
        recalcTotal();
    }

    function recalcTotal() {
        const addonInputs = document.querySelectorAll('input[id^="addon_qty_"]');
        let addonsTotal = 0;
        let breakdownHtml = '';

        addonInputs.forEach(input => {
            const qty = parseInt(input.value || '0');
            if (qty <= 0) return;
            const price = parseFloat(input.dataset.price || '0');
            const subtotal = qty * price;
            addonsTotal += subtotal;

            // Ambil nama addon dari label saudara terdekat
            const card  = input.closest('.border');
            const name  = card ? card.querySelector('.font-semibold')?.textContent?.trim() : 'Addon';
            breakdownHtml += `<div class="flex justify-between text-gray-600">
                <span>${name} × ${qty}</span>
                <span>Rp ${subtotal.toLocaleString('id-ID')}</span>
            </div>`;
        });

        const total = BASE_PRICE + addonsTotal;

        const elAddons      = document.getElementById('breakdown-addons');
        const elTotal       = document.getElementById('breakdown-total');
        const sidebarLines  = document.getElementById('sidebar-addon-lines');
        const sidebarTotal  = document.getElementById('sidebar-total');
        const section       = document.getElementById('payment-section');
        const pmMethod      = document.getElementById('payment_method');
        const pmProof       = document.getElementById('payment_proof');

        const totalStr = total > 0 ? 'Rp ' + total.toLocaleString('id-ID') : 'GRATIS';

        if (elAddons)     elAddons.innerHTML    = breakdownHtml;
        if (elTotal)      elTotal.textContent   = totalStr;
        if (sidebarLines) sidebarLines.innerHTML = breakdownHtml;
        if (sidebarTotal) sidebarTotal.textContent = totalStr;

        // Tampilkan / sembunyikan payment section
        if (section) {
            const needsPayment = total > 0;
            section.classList.toggle('hidden', !needsPayment);
            if (pmMethod) pmMethod.required = needsPayment;
            if (pmProof)  pmProof.required  = needsPayment;
        }
    }

    // Inisialisasi saat halaman load
    document.addEventListener('DOMContentLoaded', recalcTotal);
    // ──────────────────────────────────────────────────────────────

    // Copy to clipboard function
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            // Show success message
            const toast = document.createElement('div');
            toast.className = 'fixed bottom-4 right-4 bg-hastana-red text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in';
            toast.innerHTML = '<i class="fas fa-check-circle mr-2"></i>Nomor rekening berhasil disalin!';
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.remove();
            }, 3000);
        }).catch(function(err) {
            console.error('Failed to copy: ', err);
        });
    }
</script>

<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in {
        animation: fade-in 0.3s ease-out;
    }
</style>
@endpush

@endsection
