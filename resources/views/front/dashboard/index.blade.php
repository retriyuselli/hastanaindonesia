@extends('layouts.app')

@section('title', 'Dashboard - HASTANA Indonesia')

@section('content')
<section class="py-10 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col lg:flex-row gap-8">
                <aside class="lg:w-80">
                    <div class="lg:sticky lg:top-24 space-y-6">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <div class="flex items-center gap-4">
                                @if(auth()->user()->avatar_url)
                                    <img src="{{ auth()->user()->avatar_url }}"
                                        alt="{{ auth()->user()->name }}"
                                        referrerpolicy="no-referrer"
                                        onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                        class="w-14 h-14 rounded-full object-cover border-2 border-red-100">
                                    <div class="w-14 h-14 bg-gradient-to-r from-gray-900 to-red-600 rounded-full flex items-center justify-center text-white text-xl font-bold" style="display: none;">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                @else
                                    <div class="w-14 h-14 bg-gradient-to-r from-gray-900 to-red-600 rounded-full flex items-center justify-center text-white text-xl font-bold">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                @endif

                                <div class="min-w-0">
                                    <h1 class="text-lg font-bold text-gray-900 leading-tight">Dashboard</h1>
                                    <p class="text-sm text-gray-600 truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow-md p-4">
                            <nav class="grid grid-cols-2 lg:grid-cols-1 gap-2 text-sm">
                                <a href="#ringkasan" class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-700 hover:bg-red-50 transition">
                                    <i class="fas fa-chart-pie text-red-600 w-4"></i>
                                    Ringkasan
                                </a>
                                <a href="#event-terdaftar" class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-700 hover:bg-red-50 transition">
                                    <i class="fas fa-ticket-alt text-red-600 w-4"></i>
                                    Event Terdaftar
                                </a>
                                <a href="#event-rekomendasi" class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-700 hover:bg-red-50 transition">
                                    <i class="fas fa-star text-yellow-500 w-4"></i>
                                    Event Rekomendasi
                                </a>
                                <a href="#iuran" class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-700 hover:bg-red-50 transition">
                                    <i class="fas fa-wallet text-red-600 w-4"></i>
                                    Iuran
                                    <span class="ml-auto bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-full px-2 py-0.5 leading-none">Coming Soon</span>
                                </a>
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-700 hover:bg-red-50 transition">
                                    <i class="fas fa-user-circle text-red-600 w-4"></i>
                                    Edit Profil
                                </a>
                                @if($myWeddingOrganizer && $myWeddingOrganizer->slug)
                                    <a href="{{ route('members.show', $myWeddingOrganizer->slug) }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-700 hover:bg-red-50 transition">
                                        <i class="fas fa-building text-red-600 w-4"></i>
                                        Wedding Organizer
                                    </a>
                                @else
                                    <a href="{{ route('join') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-700 hover:bg-green-50 transition">
                                        <i class="fas fa-plus-circle text-green-600 w-4"></i>
                                        Daftarkan WO
                                    </a>
                                @endif
                            </nav>
                        </div>

                        @if($myWeddingOrganizer)
                            <div class="bg-white rounded-lg shadow-md p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="font-bold text-gray-900">Wedding Organizer Saya</h3>
                                    @if($myWeddingOrganizer->slug)
                                        @if($myWeddingOrganizer->verification_status === 'verified')
                                            <a href="{{ route('members.show', $myWeddingOrganizer->slug) }}" class="text-sm text-red-600 hover:text-red-700 font-medium">
                                                Detail
                                            </a>
                                        @else
                                            <button onclick="document.getElementById('wo-pending-modal').style.display='flex'" class="text-sm text-red-600 hover:text-red-700 font-medium">
                                                Detail
                                            </button>
                                        @endif
                                    @endif
                                </div>

                                <div class="flex items-center gap-4">
                                    @if($myWeddingOrganizer->logo)
                                        <img src="{{ Storage::url($myWeddingOrganizer->logo) }}"
                                            alt="{{ $myWeddingOrganizer->organizer_name }}"
                                            class="w-12 h-12 rounded-full object-cover border-2 border-red-100">
                                    @else
                                        <div class="w-12 h-12 bg-gradient-to-r from-gray-900 to-red-600 rounded-full flex items-center justify-center text-white text-lg font-bold">
                                            {{ strtoupper(substr($myWeddingOrganizer->organizer_name, 0, 1)) }}
                                        </div>
                                    @endif

                                    <div class="min-w-0">
                                        <div class="font-semibold text-gray-900 truncate">{{ $myWeddingOrganizer->organizer_name }}</div>
                                        <div class="text-sm text-gray-600 truncate">{{ $myWeddingOrganizer->city }}</div>
                                    </div>
                                </div>

                                <div class="mt-4 flex items-center justify-between text-sm border-t border-gray-100 pt-3">
                                    <span class="text-gray-600">Status</span>
                                    @if($myWeddingOrganizer->verification_status == 'verified')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Terverifikasi
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i>
                                            Menunggu
                                        </span>
                                    @endif
                                </div>

                            </div>
                        @else
                            <div class="bg-gradient-to-r from-red-50 to-red-100 rounded-lg shadow-md p-6 border border-red-200">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center shrink-0">
                                        <i class="fas fa-building text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900">Daftarkan Wedding Organizer</h3>
                                        <p class="text-sm text-gray-600 mt-1">Lengkapi data WO untuk mempermudah pemantauan dan akses fitur.</p>
                                        <a href="{{ route('join') }}" class="inline-flex items-center mt-4 px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition">
                                            <i class="fas fa-plus-circle mr-2"></i>
                                            Daftar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h3 class="font-bold text-gray-900 mb-4">Quick Links</h3>
                            <div class="space-y-2 text-sm">
                                <a href="{{ route('events') }}" class="flex items-center py-2 px-3 text-gray-700 hover:bg-red-50 rounded-lg transition">
                                    <i class="fas fa-calendar mr-3 text-red-600"></i>
                                    Semua Event
                                </a>
                                <a href="{{ route('events.free') }}" class="flex items-center py-2 px-3 text-gray-700 hover:bg-red-50 rounded-lg transition">
                                    <i class="fas fa-gift mr-3 text-green-600"></i>
                                    Event Gratis
                                </a>
                                <a href="{{ route('events.trending') }}" class="flex items-center py-2 px-3 text-gray-700 hover:bg-red-50 rounded-lg transition">
                                    <i class="fas fa-fire mr-3 text-red-600"></i>
                                    Event Trending
                                </a>
                                <a href="{{ route('blog') }}" class="flex items-center py-2 px-3 text-gray-700 hover:bg-red-50 rounded-lg transition">
                                    <i class="fas fa-newspaper mr-3 text-purple-600"></i>
                                    Blog
                                </a>
                            </div>
                        </div>
                    </div>
                </aside>

                <main class="flex-1 space-y-6">
                    @if(session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-2">
                            <i class="fas fa-check-circle text-green-600"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center gap-2">
                            <i class="fas fa-exclamation-circle text-red-600"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    <div id="ringkasan" class="scroll-mt-24 bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">Ringkasan</h2>
                                <p class="text-sm text-gray-600 mt-1">Pantau aktivitas dan event Anda dari satu tempat.</p>
                            </div>
                            <a href="{{ route('events') }}" class="text-red-600 hover:text-red-700 text-sm font-medium">
                                Lihat Semua Event <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="rounded-lg border border-gray-200 p-4">
                                <div class="flex items-center justify-between">
                                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-ticket-alt text-red-600"></i>
                                    </div>
                                    <span class="text-2xl font-bold text-red-600">{{ $totalRegistered }}</span>
                                </div>
                                <div class="mt-3 text-sm text-gray-600 font-medium">Event Terdaftar</div>
                                <div class="text-xs text-gray-500">Total event yang Anda ikuti</div>
                            </div>

                            <div class="rounded-lg border border-gray-200 p-4">
                                <div class="flex items-center justify-between">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-calendar-check text-green-600"></i>
                                    </div>
                                    <span class="text-2xl font-bold text-green-600">{{ $upcomingEvents }}</span>
                                </div>
                                <div class="mt-3 text-sm text-gray-600 font-medium">Event Akan Datang</div>
                                <div class="text-xs text-gray-500">Event yang akan Anda hadiri</div>
                            </div>

                            <div class="rounded-lg border border-gray-200 p-4">
                                <div class="flex items-center justify-between">
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-check-circle text-gray-600"></i>
                                    </div>
                                    <span class="text-2xl font-bold text-gray-700">{{ $completedEvents }}</span>
                                </div>
                                <div class="mt-3 text-sm text-gray-600 font-medium">Event Selesai</div>
                                <div class="text-xs text-gray-500">Event yang sudah Anda ikuti</div>
                            </div>
                        </div>
                    </div>

                    <div id="event-terdaftar" class="scroll-mt-24 bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-900">Event Terdaftar</h2>
                            <a href="{{ route('events') }}" class="text-red-600 hover:text-red-700 text-sm font-medium">
                                Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>

                        @forelse($myEvents as $participant)
                            @php
                                $event = $participant->eventHastana;
                                $onlineUrl = \App\Support\SafeUrl::http($event->online_link, httpsOnly: true);
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'confirmed' => 'bg-green-100 text-green-800',
                                    'attended' => 'bg-gray-100 text-gray-700',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                ];
                                $statusLabels = [
                                    'pending' => 'Menunggu',
                                    'confirmed' => 'Terkonfirmasi',
                                    'attended' => 'Hadir',
                                    'cancelled' => 'Dibatalkan',
                                ];
                            @endphp

                            <div class="border border-gray-200 rounded-lg p-4 hover:border-red-300 transition duration-200 mb-4">
                                <div class="flex flex-col md:flex-row md:items-center gap-4">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $event->image_url ?? asset('images/default-event.svg') }}"
                                            alt="{{ $event->title }}"
                                            onerror="this.onerror=null; this.src='{{ asset('images/default-event.svg') }}'"
                                            class="w-full md:w-32 h-32 object-cover rounded-lg">
                                    </div>

                                    <div class="flex-grow">
                                        <div class="flex items-start justify-between mb-2">
                                            <div>
                                                <h3 class="font-bold text-lg text-gray-900 hover:text-red-600 mb-1">
                                                    <a href="{{ route('events.show', $event->slug) }}">{{ $event->title }}</a>
                                                </h3>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$participant->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                    {{ $statusLabels[$participant->status] ?? ucfirst($participant->status) }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="space-y-2 text-sm text-gray-600">
                                            <div class="flex items-center">
                                                <i class="fas fa-calendar text-gray-400 w-5"></i>
                                                <span>{{ $event->formatted_date }}</span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-clock text-gray-400 w-5"></i>
                                                <span>{{ $event->formatted_time }}</span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-map-marker-alt text-gray-400 w-5"></i>
                                                <span>{{ $event->location }}</span>
                                            </div>
                                        </div>

                                        <div class="mt-3 flex flex-wrap gap-2">
                                            <a href="{{ route('events.show', $event->slug) }}"
                                                class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition duration-200">
                                                <i class="fas fa-eye mr-2"></i>
                                                Detail Event
                                            </a>

                                            @if($participant->status === 'confirmed' && $event->start_date >= now())
                                                @if($event->location_type === 'offline' || $event->location_type === 'hybrid')
                                                    <button type="button"
                                                        data-ticket-trigger
                                                        data-registration-code="{{ $participant->registration_code }}"
                                                        data-event-title="{{ $event->title }}"
                                                        data-event-date="{{ $event->formatted_date }}"
                                                        data-event-location="{{ $event->location }}"
                                                        data-participant-name="{{ $participant->name }}"
                                                        data-participant-email="{{ $participant->email }}"
                                                        class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition duration-200">
                                                        <i class="fas fa-ticket-alt mr-2"></i>
                                                        E-Ticket
                                                    </button>
                                                @endif

                                                @if($event->location_type === 'online' || $event->location_type === 'hybrid')
                                                    @if($onlineUrl)
                                                        <a href="{{ $onlineUrl }}" target="_blank" rel="noopener noreferrer"
                                                            class="inline-flex items-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition duration-200">
                                                            <i class="fas fa-video mr-2"></i>
                                                            Join Online
                                                        </a>
                                                    @else
                                                        <button onclick="showComingSoonModal()"
                                                            class="inline-flex items-center px-4 py-2 bg-gray-400 text-white text-sm font-medium rounded-lg cursor-not-allowed opacity-75">
                                                            <i class="fas fa-video mr-2"></i>
                                                            Join Online
                                                            <span class="ml-2 text-xs bg-yellow-500 px-2 py-0.5 rounded-full">Coming Soon</span>
                                                        </button>
                                                    @endif
                                                @endif
                                            @endif

                                            @if($participant->status === 'attended')
                                                <span class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg">
                                                    <i class="fas fa-check-circle mr-2"></i>
                                                    Sudah Hadir
                                                </span>
                                            @endif

                                            @if($participant->status === 'pending')
                                                <form action="{{ route('registrations.cancel', $participant->registration_code) }}" method="POST"
                                                    onsubmit="return confirm('Yakin ingin membatalkan pendaftaran event ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition duration-200">
                                                        <i class="fas fa-times mr-2"></i>
                                                        Batalkan
                                                    </button>
                                                </form>
                                            @endif

                                            @if($participant->payment_proof)
                                                <button type="button"
                                                    data-payment-proof-trigger
                                                    data-payment-proof-url="{{ route('files.event-participants.payment-proof', $participant) }}"
                                                    class="inline-flex items-center px-4 py-2 bg-gray-700 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition duration-200">
                                                    <i class="fas fa-receipt mr-2"></i>
                                                    Lihat Bukti Pembayaran
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-calendar-times text-gray-400 text-4xl"></i>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Event</h3>
                                <p class="text-gray-600 mb-6">Anda belum mendaftar event apapun. Yuk, cari event menarik!</p>
                                <a href="{{ route('events') }}" class="inline-flex items-center px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition duration-200">
                                    <i class="fas fa-search mr-2"></i>
                                    Cari Event
                                </a>
                            </div>
                        @endforelse
                    </div>

                    <div id="event-rekomendasi" class="scroll-mt-24 bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Event Rekomendasi</h2>

                        <div class="space-y-4">
                            @forelse($recommendedEvents as $event)
                                <div class="flex gap-4 p-4 border border-gray-200 rounded-lg hover:border-red-300 hover:shadow-md transition">
                                    @if($event->image_url)
                                        <img src="{{ $event->image_url }}"
                                            alt="{{ $event->title }}"
                                            onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-24 h-24 bg-gradient-to-br from-gray-800 to-red-700 rounded-lg flex items-center justify-center\'><i class=\'fas fa-calendar-alt text-white text-2xl\'></i></div>'"
                                            class="w-24 h-24 object-cover rounded-lg">
                                    @else
                                        <div class="w-24 h-24 bg-gradient-to-br from-gray-800 to-red-700 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-calendar-alt text-white text-2xl"></i>
                                        </div>
                                    @endif

                                    <div class="flex-1">
                                        <h3 class="font-bold text-gray-900 mb-1 line-clamp-1">{{ $event->title }}</h3>
                                        <p class="text-sm text-gray-600 mb-2">
                                            <i class="fas fa-calendar text-red-600 mr-1"></i>
                                            {{ $event->formatted_date }}
                                        </p>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm font-semibold text-red-600">
                                                @if($event->is_free)
                                                    GRATIS
                                                @else
                                                    {{ $event->formatted_price }}
                                                @endif
                                            </span>
                                            <a href="{{ route('events.show', $event->slug) }}" class="text-sm text-red-600 hover:text-red-700 font-medium">
                                                Lihat Detail <i class="fas fa-arrow-right ml-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-gray-500 py-8">Tidak ada event rekomendasi saat ini.</p>
                            @endforelse
                        </div>

                        <div class="mt-6 text-center">
                            <a href="{{ route('events.featured') }}" class="text-red-600 hover:text-red-700 font-medium">
                                Lihat Semua Event Featured <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                    <!-- Iuran Section -->
                    <div id="iuran" class="scroll-mt-24 bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <i class="fas fa-wallet text-red-600"></i> Iuran Saya
                        </h2>

                        @if(session('success'))
                            <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-4 flex items-center gap-2 text-green-800 text-sm">
                                <i class="fas fa-check-circle"></i>
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Summary Cards -->
                        <div class="grid grid-cols-3 gap-3 mb-5">
                            <div class="bg-green-50 rounded-lg p-3 text-center">
                                <div class="text-2xl font-bold text-green-700">{{ $iuranLunas }}</div>
                                <div class="text-xs text-green-600 mt-0.5">Lunas</div>
                            </div>
                            <div class="bg-yellow-50 rounded-lg p-3 text-center">
                                <div class="text-2xl font-bold text-yellow-700">{{ $iuranMenunggu }}</div>
                                <div class="text-xs text-yellow-600 mt-0.5">Menunggu</div>
                            </div>
                            <div class="bg-red-50 rounded-lg p-3 text-center">
                                <div class="text-2xl font-bold text-red-700">{{ $iuranBelumBayar }}</div>
                                <div class="text-xs text-red-600 mt-0.5">Belum Bayar</div>
                            </div>
                        </div>

                        @if($myIurans->isEmpty())
                            <div class="text-center py-8 text-gray-400">
                                <i class="fas fa-wallet text-4xl mb-2"></i>
                                <p class="text-sm">Belum ada tagihan iuran.</p>
                            </div>
                        @else
                            <div class="space-y-3">
                                @foreach($myIurans as $iuran)
                                    @php
                                        $statusColor = match($iuran->status) {
                                            'paid'    => ['bg' => 'bg-green-100',  'text' => 'text-green-800',  'label' => 'Lunas'],
                                            'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'label' => 'Menunggu Konfirmasi'],
                                            'overdue' => ['bg' => 'bg-red-100',    'text' => 'text-red-800',    'label' => 'Terlambat'],
                                            default   => ['bg' => 'bg-gray-100',   'text' => 'text-gray-800',   'label' => 'Belum Bayar'],
                                        };
                                    @endphp
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <div class="flex items-start justify-between gap-3">
                                            <div class="flex-1 min-w-0">
                                                <p class="font-semibold text-gray-900 text-sm truncate">
                                                    {{ $iuran->iuranSetting->name ?? '-' }}
                                                </p>
                                                <p class="text-xs text-gray-500 mt-0.5">
                                                    Periode: {{ $iuran->period_label }} &bull;
                                                    Jatuh tempo: {{ $iuran->due_date->format('d M Y') }}
                                                </p>
                                                <p class="text-sm font-bold text-gray-900 mt-1">
                                                    Rp {{ number_format($iuran->amount, 0, ',', '.') }}
                                                </p>
                                            </div>
                                            <span class="shrink-0 px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusColor['bg'] }} {{ $statusColor['text'] }}">
                                                {{ $statusColor['label'] }}
                                            </span>
                                        </div>

                                        @if(in_array($iuran->status, ['unpaid', 'overdue']))
                                            <div class="mt-3 border-t border-gray-100 pt-3">
                                                <form action="{{ route('iuran.bayar', $iuran->id) }}" method="POST" enctype="multipart/form-data" class="space-y-2">
                                                    @csrf
                                                    <div class="grid grid-cols-2 gap-2">
                                                        <select name="payment_method" required
                                                            class="text-xs border border-gray-300 rounded-lg px-2 py-1.5 focus:ring-1 focus:ring-red-500 focus:border-red-500">
                                                            <option value="">Pilih Metode</option>
                                                            <option value="bca">Transfer BCA</option>
                                                            <option value="mandiri">Transfer Mandiri</option>
                                                            <option value="bni">Transfer BNI</option>
                                                            <option value="bri">Transfer BRI</option>
                                                            <option value="gopay">GoPay</option>
                                                            <option value="ovo">OVO</option>
                                                            <option value="dana">DANA</option>
                                                            <option value="cash">Tunai</option>
                                                        </select>
                                                        <input type="file" name="payment_proof" required accept=".jpg,.jpeg,.png,.pdf"
                                                            class="text-xs border border-gray-300 rounded-lg px-2 py-1.5 file:mr-2 file:text-xs file:border-0 file:bg-red-50 file:text-red-700 file:rounded file:px-2 file:py-1">
                                                    </div>
                                                    <button type="submit"
                                                        class="w-full bg-hastana-red text-white text-xs font-semibold py-2 rounded-lg hover:bg-red-700 transition">
                                                        <i class="fas fa-upload mr-1"></i> Upload Bukti Bayar
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif($iuran->status === 'pending')
                                            <p class="mt-2 text-xs text-yellow-700">
                                                <i class="fas fa-clock mr-1"></i> Bukti bayar sudah dikirim, menunggu konfirmasi admin.
                                            </p>
                                        @elseif($iuran->status === 'paid')
                                            <p class="mt-2 text-xs text-green-700">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Dikonfirmasi {{ $iuran->confirmed_at?->format('d M Y') ?? '-' }}
                                            </p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </main>
            </div>
        </div>
    </div>
</section>

<!-- Include Modals -->
@include('partials.payment-proof-modal')

@if($myWeddingOrganizer && $myWeddingOrganizer->verification_status !== 'verified')
<!-- WO Pending Modal -->
<div id="wo-pending-modal" class="fixed inset-0 z-9999 items-center justify-center p-4" style="display:none;background:rgba(0,0,0,0.45);">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-8 text-center" style="animation:woPendingIn .3s cubic-bezier(.34,1.56,.64,1) both">

        <!-- Icon -->
        <div class="flex items-center justify-center mx-auto mb-5 w-20 h-20 rounded-full bg-yellow-100">
            <svg class="w-10 h-10 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/>
            </svg>
        </div>

        <!-- Title & Message -->
        <h3 class="text-xl font-bold text-gray-900 mb-2">Sedang Diproses</h3>
        <p class="text-gray-600 text-sm leading-relaxed mb-2">
            Pendaftaran <strong>{{ $myWeddingOrganizer->organizer_name }}</strong> sedang dalam proses verifikasi oleh tim HASTANA Indonesia.
        </p>
        <p class="text-gray-500 text-sm leading-relaxed mb-6">
            Proses verifikasi membutuhkan waktu <strong>3–5 hari kerja</strong>. Kami akan menghubungi Anda melalui email setelah verifikasi selesai.
        </p>

        <!-- Info box -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl px-4 py-3 mb-6 text-left">
            <p class="text-xs text-yellow-800 flex items-start gap-2">
                <svg class="w-4 h-4 shrink-0 mt-0.5 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20A10 10 0 0012 2z"/>
                </svg>
                Jika sudah lebih dari 5 hari kerja dan belum ada kabar, silakan hubungi admin HASTANA melalui kontak resmi.
            </p>
        </div>

        <!-- Close button -->
        <button onclick="document.getElementById('wo-pending-modal').style.display='none'" class="w-full py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-xl transition">
            Mengerti
        </button>
    </div>
</div>

<style>
@keyframes woPendingIn {
    from { opacity:0; transform:scale(.85) translateY(20px); }
    to   { opacity:1; transform:scale(1) translateY(0); }
}
</style>

<script>
document.getElementById('wo-pending-modal')?.addEventListener('click', function(e) {
    if (e.target === this) this.style.display = 'none';
});
</script>
@endif
@include('partials.ticket-modal')

<!-- Coming Soon Modal -->
<div id="comingSoonModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 items-center justify-center p-4" style="display: none;">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 relative animate-fade-in">
        <!-- Close Button -->
        <button onclick="closeComingSoonModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">
            <i class="fas fa-times text-2xl"></i>
        </button>

        <!-- Icon -->
        <div class="text-center mb-6">
            <div class="w-20 h-20 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                <i class="fas fa-clock text-white text-3xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Coming Soon</h3>
            <div class="w-16 h-1 bg-gradient-to-r from-yellow-400 to-orange-500 mx-auto rounded-full"></div>
        </div>

        <!-- Content -->
        <div class="text-center mb-6">
            <p class="text-gray-600 leading-relaxed mb-4">
                Link meeting online untuk event ini belum tersedia saat ini.
            </p>
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-red-600 mt-1 mr-3"></i>
                    <div class="text-left text-sm text-red-800">
                        <p class="font-semibold mb-1">Informasi:</p>
                        <p>Link akan diupdate oleh panitia pada <strong>hari pelaksanaan event</strong> untuk keamanan.</p>
                    </div>
                </div>
            </div>
            <p class="text-sm text-gray-500">
                <i class="fas fa-bell text-yellow-500 mr-1"></i>
                Selalu pantau Dashboard untuk melihat status event.
            </p>
        </div>

        <!-- Action Button -->
        <button onclick="closeComingSoonModal()"
                class="w-full px-6 py-3 bg-gradient-to-r from-gray-900 to-red-600 text-white font-semibold rounded-lg hover:from-black hover:to-red-700 transition duration-200 shadow-md">
            <i class="fas fa-check mr-2"></i>
            Mengerti
        </button>
    </div>
</div>

@push('scripts')
<script>
function showComingSoonModal() {
    const modal = document.getElementById('comingSoonModal');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeComingSoonModal() {
    const modal = document.getElementById('comingSoonModal');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

document.getElementById('comingSoonModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeComingSoonModal();
    }
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeComingSoonModal();
    }
});
</script>
@endpush

@endsection
