@extends('layouts.app')

@section('title', 'Dashboard - HASTANA Indonesia')

@section('content')
<section class="py-10 bg-gray-50 mt-20">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col lg:flex-row gap-8">
                <aside class="lg:w-80">
                    <div class="lg:sticky lg:top-24 space-y-6">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <div class="flex items-center gap-4">
                                @if(auth()->user()->avatar)
                                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}"
                                        alt="{{ auth()->user()->name }}"
                                        onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                        class="w-14 h-14 rounded-full object-cover border-2 border-blue-100">
                                    <div class="w-14 h-14 bg-gradient-to-r from-blue-600 to-red-600 rounded-full flex items-center justify-center text-white text-xl font-bold" style="display: none;">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                @else
                                    <div class="w-14 h-14 bg-gradient-to-r from-blue-600 to-red-600 rounded-full flex items-center justify-center text-white text-xl font-bold">
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
                                <a href="#ringkasan" class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-700 hover:bg-blue-50 transition">
                                    <i class="fas fa-chart-pie text-blue-600 w-4"></i>
                                    Ringkasan
                                </a>
                                <a href="#event-terdaftar" class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-700 hover:bg-blue-50 transition">
                                    <i class="fas fa-ticket-alt text-blue-600 w-4"></i>
                                    Event Terdaftar
                                </a>
                                <a href="#event-rekomendasi" class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-700 hover:bg-blue-50 transition">
                                    <i class="fas fa-star text-yellow-500 w-4"></i>
                                    Event Rekomendasi
                                </a>
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-700 hover:bg-blue-50 transition">
                                    <i class="fas fa-user-circle text-blue-600 w-4"></i>
                                    Edit Profil
                                </a>
                                @if($myWeddingOrganizer && $myWeddingOrganizer->slug)
                                    <a href="{{ route('members.show', $myWeddingOrganizer->slug) }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-700 hover:bg-blue-50 transition">
                                        <i class="fas fa-building text-blue-600 w-4"></i>
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
                                        <a href="{{ route('members.show', $myWeddingOrganizer->slug) }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                                            Detail
                                        </a>
                                    @endif
                                </div>

                                <div class="flex items-center gap-4">
                                    @if($myWeddingOrganizer->logo)
                                        <img src="{{ Storage::url($myWeddingOrganizer->logo) }}"
                                            alt="{{ $myWeddingOrganizer->organizer_name }}"
                                            class="w-12 h-12 rounded-full object-cover border-2 border-blue-100">
                                    @else
                                        <div class="w-12 h-12 bg-gradient-to-r from-blue-600 to-red-600 rounded-full flex items-center justify-center text-white text-lg font-bold">
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
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
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

                                <div class="mt-2 flex items-center justify-between text-sm">
                                    <span class="text-gray-600">Rating</span>
                                    <span class="font-semibold text-gray-900">
                                        <i class="fas fa-star text-yellow-400"></i>
                                        {{ number_format($myWeddingOrganizer->rating ?? 0, 1) }}/5
                                    </span>
                                </div>
                            </div>
                        @else
                            <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg shadow-md p-6 border border-blue-200">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-building text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900">Daftarkan Wedding Organizer</h3>
                                        <p class="text-sm text-gray-600 mt-1">Lengkapi data WO untuk mempermudah pemantauan dan akses fitur.</p>
                                        <a href="{{ route('join') }}" class="inline-flex items-center mt-4 px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
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
                                <a href="{{ route('events') }}" class="flex items-center py-2 px-3 text-gray-700 hover:bg-blue-50 rounded-lg transition">
                                    <i class="fas fa-calendar mr-3 text-blue-600"></i>
                                    Semua Event
                                </a>
                                <a href="{{ route('events.free') }}" class="flex items-center py-2 px-3 text-gray-700 hover:bg-blue-50 rounded-lg transition">
                                    <i class="fas fa-gift mr-3 text-green-600"></i>
                                    Event Gratis
                                </a>
                                <a href="{{ route('events.trending') }}" class="flex items-center py-2 px-3 text-gray-700 hover:bg-blue-50 rounded-lg transition">
                                    <i class="fas fa-fire mr-3 text-red-600"></i>
                                    Event Trending
                                </a>
                                <a href="{{ route('blog') }}" class="flex items-center py-2 px-3 text-gray-700 hover:bg-blue-50 rounded-lg transition">
                                    <i class="fas fa-newspaper mr-3 text-purple-600"></i>
                                    Blog
                                </a>
                            </div>
                        </div>
                    </div>
                </aside>

                <main class="flex-1 space-y-6">
                    <div id="ringkasan" class="scroll-mt-24 bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">Ringkasan</h2>
                                <p class="text-sm text-gray-600 mt-1">Pantau aktivitas dan event Anda dari satu tempat.</p>
                            </div>
                            <a href="{{ route('events') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                Lihat Semua Event <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="rounded-lg border border-gray-200 p-4">
                                <div class="flex items-center justify-between">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-ticket-alt text-blue-600"></i>
                                    </div>
                                    <span class="text-2xl font-bold text-blue-600">{{ $totalRegistered }}</span>
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
                                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-check-circle text-purple-600"></i>
                                    </div>
                                    <span class="text-2xl font-bold text-purple-600">{{ $completedEvents }}</span>
                                </div>
                                <div class="mt-3 text-sm text-gray-600 font-medium">Event Selesai</div>
                                <div class="text-xs text-gray-500">Event yang sudah Anda ikuti</div>
                            </div>
                        </div>
                    </div>

                    <div id="event-terdaftar" class="scroll-mt-24 bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-900">Event Terdaftar</h2>
                            <a href="{{ route('events') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>

                        @forelse($myEvents as $participant)
                            @php
                                $event = $participant->eventHastana;
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'confirmed' => 'bg-green-100 text-green-800',
                                    'attended' => 'bg-blue-100 text-blue-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                ];
                                $statusLabels = [
                                    'pending' => 'Menunggu',
                                    'confirmed' => 'Terkonfirmasi',
                                    'attended' => 'Hadir',
                                    'cancelled' => 'Dibatalkan',
                                ];
                            @endphp

                            <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition duration-200 mb-4">
                                <div class="flex flex-col md:flex-row md:items-center gap-4">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $event->image_url ?? asset('images/default-event.png') }}"
                                            alt="{{ $event->title }}"
                                            onerror="this.src='https://via.placeholder.com/300x200?text=No+Image'"
                                            class="w-full md:w-32 h-32 object-cover rounded-lg">
                                    </div>

                                    <div class="flex-grow">
                                        <div class="flex items-start justify-between mb-2">
                                            <div>
                                                <h3 class="font-bold text-lg text-gray-900 hover:text-blue-600 mb-1">
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
                                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition duration-200">
                                                <i class="fas fa-eye mr-2"></i>
                                                Detail Event
                                            </a>

                                            @if($participant->status === 'confirmed' && $event->start_date >= now())
                                                @if($event->location_type === 'offline' || $event->location_type === 'hybrid')
                                                    <button onclick="openTicketModal('{{ $participant->registration_code }}', '{{ $event->title }}', '{{ $event->formatted_date }}', '{{ $event->location }}', '{{ $participant->name }}', '{{ $participant->email }}')"
                                                        class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition duration-200">
                                                        <i class="fas fa-ticket-alt mr-2"></i>
                                                        E-Ticket
                                                    </button>
                                                @endif

                                                @if($event->location_type === 'online' || ($event->location_type === 'hybrid' && $event->online_link))
                                                    @if($event->online_link && $event->online_link !== '' && $event->online_link !== 'coming soon')
                                                        <a href="{{ $event->online_link }}" target="_blank"
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
                                                <span class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 text-sm font-medium rounded-lg">
                                                    <i class="fas fa-check-circle mr-2"></i>
                                                    Sudah Hadir
                                                </span>
                                            @endif

                                            @if($participant->status === 'pending')
                                                <button class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition duration-200">
                                                    <i class="fas fa-times mr-2"></i>
                                                    Batalkan
                                                </button>
                                            @endif

                                            @if($participant->payment_proof)
                                                <button class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition duration-200"
                                                    onclick="openPaymentProofModal('{{ route('files.event-participants.payment-proof', $participant) }}')">
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
                                <a href="{{ route('events') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-200">
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
                                <div class="flex gap-4 p-4 border border-gray-200 rounded-lg hover:border-blue-300 hover:shadow-md transition">
                                    @if($event->image_url)
                                        <img src="{{ $event->image_url }}"
                                            alt="{{ $event->title }}"
                                            onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\\'w-24 h-24 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center\\'><i class=\\'fas fa-calendar-alt text-white text-2xl\\'></i></div>'"
                                            class="w-24 h-24 object-cover rounded-lg">
                                    @else
                                        <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-calendar-alt text-white text-2xl"></i>
                                        </div>
                                    @endif

                                    <div class="flex-1">
                                        <h3 class="font-bold text-gray-900 mb-1 line-clamp-1">{{ $event->title }}</h3>
                                        <p class="text-sm text-gray-600 mb-2">
                                            <i class="fas fa-calendar text-blue-600 mr-1"></i>
                                            {{ $event->formatted_date }}
                                        </p>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm font-semibold text-blue-600">
                                                @if($event->is_free)
                                                    GRATIS
                                                @else
                                                    {{ $event->formatted_price }}
                                                @endif
                                            </span>
                                            <a href="{{ route('events.show', $event->slug) }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
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
                            <a href="{{ route('events.featured') }}" class="text-blue-600 hover:text-blue-700 font-medium">
                                Lihat Semua Event Featured <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</section>

<!-- Include Modals -->
@include('partials.payment-proof-modal')
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
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-600 mt-1 mr-3"></i>
                    <div class="text-left text-sm text-blue-800">
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
                class="w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-blue-800 transition duration-200 shadow-md">
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

// Close modal when clicking outside
document.getElementById('comingSoonModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeComingSoonModal();
    }
});

// Close modal with ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeComingSoonModal();
    }
});
</script>
@endpush

@endsection
