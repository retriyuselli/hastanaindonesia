@extends('layouts.app')

@section('title', ($member->organizer_name ?? 'Detail Anggota') . ' - HASTANA Indonesia')
@section('description', $member->description ?? 'Detail informasi wedding organizer ' . ($member->organizer_name ?? ''))

@section('content')
    <div class="pt-28 pb-16 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <a href="{{ route('members') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-hastana-blue">
                        <i class="fas fa-arrow-left mr-2 text-xs"></i>
                        Kembali ke daftar anggota
                    </a>
                    <h1 class="text-3xl font-bold text-gray-900 mt-3">{{ $member->organizer_name }}</h1>
                    <div class="mt-2 flex flex-wrap items-center gap-2 text-sm text-gray-600">
                        @if($member->city)
                            <span class="inline-flex items-center">
                                <i class="fas fa-map-marker-alt mr-2 text-xs text-gray-400"></i>{{ $member->city }}
                            </span>
                        @endif
                        @if($member->province)
                            <span class="inline-flex items-center">
                                <i class="fas fa-location-dot mr-2 text-xs text-gray-400"></i>{{ $member->province }}
                            </span>
                        @endif
                        @if($member->region?->region_name)
                            <span class="inline-flex items-center">
                                <i class="fas fa-sitemap mr-2 text-xs text-gray-400"></i>{{ $member->region->region_name }}
                            </span>
                        @endif
                        <span class="text-xs px-2 py-1 rounded-full {{ $member->verification_status === 'verified' ? 'bg-blue-50 text-blue-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ $member->verification_status === 'verified' ? 'Terverifikasi' : 'Belum Terverifikasi' }}
                        </span>
                        @if($member->certification_level)
                            <span class="text-xs px-2 py-1 rounded-full bg-yellow-50 text-yellow-700">
                                {{ $member->certification_level }}
                            </span>
                        @endif
                    </div>
                    @if($member->brand_name)
                        <div class="mt-2 text-sm text-gray-700">
                            {{ $member->brand_name }}
                        </div>
                    @endif
                </div>
                <div class="hidden sm:block w-20 h-20 rounded-2xl overflow-hidden bg-white border border-gray-100 shadow-sm">
                    @if($member->logo)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($member->logo) }}" alt="{{ $member->organizer_name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <i class="fas fa-store text-2xl"></i>
                        </div>
                    @endif
                </div>
            </div>

            @php
                $galleryImages = collect();

                if ($member->logo) {
                    $galleryImages->push(\Illuminate\Support\Facades\Storage::url($member->logo));
                }

                $galleryImages = $galleryImages
                    ->merge(
                        collect($member->activeProducts ?? [])
                            ->flatMap(function ($product) {
                                $images = is_array($product->images) ? $product->images : [];
                                if (!count($images)) {
                                    return [$product->main_image];
                                }

                                return collect($images)
                                    ->take(3)
                                    ->map(function ($path) {
                                        if (is_string($path) && str_starts_with($path, 'http')) {
                                            return $path;
                                        }

                                        return \Illuminate\Support\Facades\Storage::url($path);
                                    })
                                    ->values()
                                    ->all();
                            })
                    )
                    ->filter()
                    ->unique()
                    ->values();
            @endphp

            @if($galleryImages->isNotEmpty())
                <div class="mt-6 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="p-4 flex items-center justify-between">
                        <h2 class="text-base font-semibold text-gray-900">Galeri</h2>
                        <span class="text-xs text-gray-500">Geser untuk melihat foto lainnya</span>
                    </div>

                    <div class="relative">
                        <button id="member-gallery-prev" type="button" class="hidden sm:flex items-center justify-center absolute left-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/90 border border-gray-200 shadow-sm hover:bg-white">
                            <i class="fas fa-chevron-left text-gray-700 text-sm"></i>
                        </button>
                        <button id="member-gallery-next" type="button" class="hidden sm:flex items-center justify-center absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/90 border border-gray-200 shadow-sm hover:bg-white">
                            <i class="fas fa-chevron-right text-gray-700 text-sm"></i>
                        </button>

                        <div id="member-gallery-track" class="pb-4 overflow-x-auto scroll-smooth snap-x snap-mandatory select-none" style="cursor: grab; scrollbar-width: none; -ms-overflow-style: none;">
                            <div class="flex">
                                @foreach ($galleryImages as $src)
                                    <div data-slide class="snap-start shrink-0 w-full box-border px-4">
                                        <div class="w-full aspect-[4/3] lg:aspect-video rounded-2xl overflow-hidden bg-black">
                                            <img src="{{ $src }}" alt="Foto anggota" class="w-full h-full object-cover object-center">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="mt-8 grid grid-cols-1 lg:grid-cols-12 gap-6">
                <div class="lg:col-span-7 space-y-6">
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-gray-900">Informasi Wedding Organizer</h2>

                        <dl class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                            @if($member->address)
                                <div class="sm:col-span-2">
                                    <dt class="text-gray-500">Alamat</dt>
                                    <dd class="text-gray-900 mt-1">{{ $member->address }}</dd>
                                </div>
                            @endif

                            @if($member->phone)
                                <div>
                                    <dt class="text-gray-500">Telepon</dt>
                                    <dd class="text-gray-900 mt-1">
                                        <a href="tel:{{ $member->phone }}" class="text-hastana-blue hover:underline">{{ $member->phone }}</a>
                                    </dd>
                                </div>
                            @endif

                            @if($member->email)
                                <div>
                                    <dt class="text-gray-500">Email</dt>
                                    <dd class="text-gray-900 mt-1">
                                        <a href="mailto:{{ $member->email }}" class="text-hastana-blue hover:underline">{{ $member->email }}</a>
                                    </dd>
                                </div>
                            @endif

                            @if($member->website)
                                <div class="sm:col-span-2">
                                    <dt class="text-gray-500">Website</dt>
                                    <dd class="text-gray-900 mt-1">
                                        <a href="{{ $member->website }}" target="_blank" rel="noopener" class="text-hastana-blue hover:underline">{{ $member->website }}</a>
                                    </dd>
                                </div>
                            @endif

                            @if($member->instagram)
                                @php
                                    $instagramLabel = trim(preg_replace('#^https?://(www\.)?instagram\.com/#', '', $member->instagram), "/ \t\n\r\0\x0B");
                                    $instagramLabel = ltrim($instagramLabel, '@');
                                    $instagramHref = str_starts_with($member->instagram, 'http://') || str_starts_with($member->instagram, 'https://')
                                        ? $member->instagram
                                        : ('https://instagram.com/' . $instagramLabel);
                                @endphp
                                <div class="sm:col-span-2">
                                    <dt class="text-gray-500">Instagram</dt>
                                    <dd class="text-gray-900 mt-1">
                                        <a href="{{ $instagramHref }}" target="_blank" rel="noopener" class="text-hastana-blue hover:underline">{{ '@' . $instagramLabel }}</a>
                                    </dd>
                                </div>
                            @endif

                            @if($member->price_range_min && $member->price_range_max)
                                <div class="sm:col-span-2">
                                    <dt class="text-gray-500">Kisaran Harga</dt>
                                    <dd class="text-gray-900 mt-1">Rp {{ number_format($member->price_range_min) }} - Rp {{ number_format($member->price_range_max) }}</dd>
                                </div>
                            @endif

                            @if($member->established_year)
                                <div>
                                    <dt class="text-gray-500">Tahun Berdiri</dt>
                                    <dd class="text-gray-900 mt-1">{{ $member->established_year }}</dd>
                                </div>
                            @endif

                            @if($member->completed_events)
                                <div>
                                    <dt class="text-gray-500">Event Selesai</dt>
                                    <dd class="text-gray-900 mt-1">{{ number_format($member->completed_events) }}</dd>
                                </div>
                            @endif
                        </dl>

                        @if($member->description)
                            <div class="mt-6">
                                <h3 class="text-sm font-semibold text-gray-900">Deskripsi</h3>
                                <div class="mt-2 text-sm text-gray-700 whitespace-pre-line">{{ $member->description }}</div>
                            </div>
                        @endif

                        @if(is_array($member->specializations) && count($member->specializations))
                            <div class="mt-6">
                                <h3 class="text-sm font-semibold text-gray-900">Spesialisasi</h3>
                                <div class="mt-3 flex flex-wrap gap-2">
                                    @foreach($member->specializations as $item)
                                        <span class="text-xs px-3 py-1 rounded-full bg-gray-100 text-gray-700">{{ $item }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if(is_array($member->services) && count($member->services))
                            <div class="mt-6">
                                <h3 class="text-sm font-semibold text-gray-900">Layanan</h3>
                                <div class="mt-3 flex flex-wrap gap-2">
                                    @foreach($member->services as $item)
                                        <span class="text-xs px-3 py-1 rounded-full bg-blue-50 text-blue-700">{{ $item }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if(is_array($member->awards) && count($member->awards))
                            <div class="mt-6">
                                <h3 class="text-sm font-semibold text-gray-900">Penghargaan</h3>
                                <ul class="mt-2 space-y-2 text-sm text-gray-700">
                                    @foreach($member->awards as $item)
                                        <li class="flex items-start gap-2">
                                            <i class="fas fa-award text-yellow-500 mt-0.5"></i>
                                            <span>{{ $item }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-gray-900">Paket / Produk</h2>
                            <span class="text-sm text-gray-600">{{ $member->activeProducts?->count() ?? 0 }} item</span>
                        </div>

                        @if($member->activeProducts && $member->activeProducts->count() > 0)
                            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($member->activeProducts as $product)
                                    <a href="{{ route('members.product', ['slug' => $member->slug, 'productId' => $product->id]) }}" class="block rounded-xl border border-gray-100 hover:border-gray-200 hover:shadow-sm transition-all overflow-hidden bg-white">
                                        <div class="flex gap-4 p-4">
                                            <div class="w-20 h-20 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                                                <img src="{{ $product->main_image }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <div class="text-sm font-semibold text-gray-900 truncate">{{ $product->name }}</div>
                                                <div class="text-xs text-gray-500 mt-1 truncate">{{ $member->organizer_name }}</div>
                                                <div class="mt-2 flex items-center justify-between">
                                                    <div class="text-sm font-bold text-gray-900">Rp {{ number_format($product->price) }}</div>
                                                    @if($product->limited_offer)
                                                        <span class="text-xs px-2 py-1 rounded-full bg-red-50 text-red-700">Harga Terbatas</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="mt-4 text-sm text-gray-600 bg-gray-50 rounded-xl p-4">
                                Belum ada paket/produk yang ditampilkan.
                            </div>
                        @endif
                    </div>
                </div>

                <div class="lg:col-span-5 space-y-6">
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-gray-900">Kontak Cepat</h2>
                        <div class="mt-4 space-y-3 text-sm">
                            @if($member->email)
                                <a href="mailto:{{ $member->email }}" class="flex items-center gap-3 rounded-xl border border-gray-100 hover:border-gray-200 hover:shadow-sm transition-all p-4">
                                    <div class="w-10 h-10 rounded-lg bg-blue-50 text-hastana-blue flex items-center justify-center">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-xs text-gray-500">Email</div>
                                        <div class="text-sm font-semibold text-gray-900 truncate">{{ $member->email }}</div>
                                    </div>
                                </a>
                            @endif
                            @if($member->phone)
                                <a href="tel:{{ $member->phone }}" class="flex items-center gap-3 rounded-xl border border-gray-100 hover:border-gray-200 hover:shadow-sm transition-all p-4">
                                    <div class="w-10 h-10 rounded-lg bg-red-50 text-hastana-red flex items-center justify-center">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-xs text-gray-500">Telepon</div>
                                        <div class="text-sm font-semibold text-gray-900 truncate">{{ $member->phone }}</div>
                                    </div>
                                </a>
                            @endif
                            @if($member->phone)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $member->phone) }}" target="_blank" rel="noopener" class="flex items-center gap-3 rounded-xl border border-gray-100 hover:border-gray-200 hover:shadow-sm transition-all p-4">
                                    <div class="w-10 h-10 rounded-lg bg-green-50 text-green-700 flex items-center justify-center">
                                        <i class="fab fa-whatsapp"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-xs text-gray-500">WhatsApp</div>
                                        <div class="text-sm font-semibold text-gray-900 truncate">Chat sekarang</div>
                                    </div>
                                </a>
                            @endif
                            @if($member->website)
                                <a href="{{ $member->website }}" target="_blank" rel="noopener" class="flex items-center gap-3 rounded-xl border border-gray-100 hover:border-gray-200 hover:shadow-sm transition-all p-4">
                                    <div class="w-10 h-10 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center">
                                        <i class="fas fa-globe"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-xs text-gray-500">Website</div>
                                        <div class="text-sm font-semibold text-gray-900 truncate">{{ $member->website }}</div>
                                    </div>
                                </a>
                            @endif
                            @if($member->instagram)
                                <a href="{{ $instagramHref ?? ('https://instagram.com/' . ltrim($member->instagram, '@')) }}" target="_blank" rel="noopener" class="flex items-center gap-3 rounded-xl border border-gray-100 hover:border-gray-200 hover:shadow-sm transition-all p-4">
                                    <div class="w-10 h-10 rounded-lg bg-pink-50 text-pink-600 flex items-center justify-center">
                                        <i class="fab fa-instagram"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-xs text-gray-500">Instagram</div>
                                        <div class="text-sm font-semibold text-gray-900 truncate">{{ '@' . ($instagramLabel ?? ltrim($member->instagram, '@')) }}</div>
                                    </div>
                                </a>
                            @endif
                            @if(!$member->email && !$member->phone && !$member->website && !$member->instagram)
                                <div class="text-sm text-gray-600 bg-gray-50 rounded-xl p-4">
                                    Kontak belum tersedia.
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-gray-900">Anggota Terkait</h2>
                            <span class="text-sm text-gray-600">{{ count($relatedMembers) }} anggota</span>
                        </div>

                        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @forelse ($relatedMembers as $related)
                                <a href="{{ route('members.show', $related->slug) }}" class="block rounded-xl border border-gray-100 hover:border-gray-200 hover:shadow-sm transition-all p-4 bg-white">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 shrink-0 overflow-hidden">
                                            @if($related->logo)
                                                <img src="{{ \Illuminate\Support\Facades\Storage::url($related->logo) }}" alt="{{ $related->organizer_name }}" class="w-full h-full object-cover">
                                            @else
                                                <i class="fas fa-store"></i>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <div class="text-sm font-semibold text-gray-900 truncate">{{ $related->organizer_name }}</div>
                                            <div class="text-xs text-gray-500 truncate">{{ $related->city ?? '-' }}</div>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="sm:col-span-2 text-sm text-gray-600 bg-gray-50 rounded-xl p-4">
                                    Tidak ada anggota terkait.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        #member-gallery-track::-webkit-scrollbar { display: none; }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const track = document.getElementById('member-gallery-track')
            if (!track) return
            const prevButton = document.getElementById('member-gallery-prev')
            const nextButton = document.getElementById('member-gallery-next')
            const slides = track.querySelectorAll('[data-slide]')
            if (!slides.length) return

            let snapTimeout = null
            let pointerDown = false
            let startX = 0
            let startScrollLeft = 0
            let moved = false

            function goToIndex(index, behavior = 'smooth') {
                const target = slides[index]
                if (!target) return
                track.scrollTo({ left: target.offsetLeft, behavior })
            }

            function snapToNearest() {
                const current = track.scrollLeft
                let closest = slides[0]
                let min = Math.abs(closest.offsetLeft - current)

                slides.forEach((slide) => {
                    const diff = Math.abs(slide.offsetLeft - current)
                    if (diff < min) {
                        min = diff
                        closest = slide
                    }
                })

                track.scrollTo({ left: closest.offsetLeft, behavior: 'smooth' })
            }

            track.addEventListener('scroll', function () {
                if (pointerDown) return
                if (snapTimeout) window.clearTimeout(snapTimeout)
                snapTimeout = window.setTimeout(snapToNearest, 120)
            }, { passive: true })

            track.addEventListener('pointerdown', function (e) {
                if (e.button !== 0) return
                pointerDown = true
                moved = false
                startX = e.clientX
                startScrollLeft = track.scrollLeft
                track.style.cursor = 'grabbing'
                track.setPointerCapture(e.pointerId)
            })

            track.addEventListener('pointermove', function (e) {
                if (!pointerDown) return
                const dx = e.clientX - startX
                if (Math.abs(dx) > 3) moved = true
                track.scrollLeft = startScrollLeft - dx
            })

            function onPointerUp() {
                if (!pointerDown) return
                pointerDown = false
                track.style.cursor = 'grab'
                if (moved) snapToNearest()
            }

            track.addEventListener('pointerup', onPointerUp)
            track.addEventListener('pointercancel', onPointerUp)

            function getNearestIndex() {
                const current = track.scrollLeft
                let nearestIndex = 0
                let min = Infinity
                slides.forEach((slide, index) => {
                    const diff = Math.abs(slide.offsetLeft - current)
                    if (diff < min) {
                        min = diff
                        nearestIndex = index
                    }
                })
                return nearestIndex
            }

            if (prevButton) {
                prevButton.addEventListener('click', function () {
                    const index = getNearestIndex()
                    goToIndex(Math.max(0, index - 1))
                })
            }

            if (nextButton) {
                nextButton.addEventListener('click', function () {
                    const index = getNearestIndex()
                    goToIndex(Math.min(slides.length - 1, index + 1))
                })
            }
        })
    </script>
@endpush
