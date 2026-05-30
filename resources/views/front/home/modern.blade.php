@extends('layouts.app')

@section('title', 'HASTANA Indonesia - Himpunan Perusahaan Penata Acara Seluruh Indonesia')
@section('description', 'Organisasi resmi yang menaungi para wedding organizer profesional di Indonesia. Mendukung profesionalisme dan kolaborasi WO di seluruh Indonesia.')

@push('styles')
    <style>
        .home-hero {
            background: linear-gradient(180deg, #020617, #0b1220);
        }

        .home-grid {
            background-image: radial-gradient(rgba(148, 163, 184, 0.18) 1px, transparent 1px);
            background-size: 18px 18px;
            mask-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.85), transparent);
        }

        .home-card {
            backdrop-filter: blur(10px);
        }

        .home-hero-carousel {
            touch-action: pan-y;
        }

        .home-hero-track {
            display: flex;
            width: 100%;
            will-change: transform;
            transition: transform 400ms ease;
        }

        .home-hero-slide {
            width: 100%;
            flex-shrink: 0;
        }

        .home-hero-dots {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .home-hero-dot {
            width: 10px;
            height: 10px;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.35);
            border: 1px solid rgba(255, 255, 255, 0.25);
            transition: background 200ms ease, transform 200ms ease;
        }

        .home-hero-dot[aria-current="true"] {
            background: rgba(255, 255, 255, 0.95);
            transform: scale(1.05);
        }
    </style>
@endpush

@section('content')
    @php
        $heroSlides = collect($homeHeroImages ?? [])
            ->filter(fn ($item) => filled($item?->image_url))
            ->values();

        if ($heroSlides->isEmpty()) {
            $heroSlides = collect([
                (object) [
                    'image_url' => asset('images/' . rawurlencode('Untitled design_20251103_181604_0000.png')),
                    'alt' => 'HASTANA Indonesia',
                    'link' => null,
                ],
            ]);
        }
    @endphp

    <section class="home-hero home-hero-carousel relative overflow-hidden mt-20" data-hero-carousel>
        <div class="home-hero-track" data-hero-track>
            @foreach ($heroSlides as $slide)
                <div class="home-hero-slide">
                    @php
                        $slideAlt = filled($slide?->alt) ? $slide->alt : 'HASTANA Indonesia';
                        $hasLink = filled($slide?->link);
                        $isExternalLink = false;
                        if ($hasLink) {
                            $lowerLink = strtolower($slide->link);
                            if (str_starts_with($lowerLink, 'javascript:')) {
                                $hasLink = false;
                            } else {
                                $isExternalLink = str_starts_with($lowerLink, 'http://') || str_starts_with($lowerLink, 'https://');
                            }
                        }
                    @endphp

                    @if ($hasLink)
                        <a 
                            href="{{ $slide->link }}" 
                            class="block cursor-pointer" 
                            aria-label="{{ $slideAlt }}"
                            @if($isExternalLink) target="_blank" rel="noopener noreferrer" @endif
                        >
                            <img src="{{ $slide->image_url }}" alt="{{ $slideAlt }}" class="block w-full h-auto select-none" loading="{{ $loop->first ? 'eager' : 'lazy' }}" decoding="async" draggable="false">
                        </a>
                    @else
                        <img src="{{ $slide->image_url }}" alt="{{ $slideAlt }}" class="block w-full h-auto select-none" loading="{{ $loop->first ? 'eager' : 'lazy' }}" decoding="async" draggable="false">
                    @endif
                </div>
            @endforeach
        </div>

        @if ($heroSlides->count() > 1)
            <button type="button" class="hidden sm:flex absolute left-4 top-1/2 -translate-y-1/2 z-10 w-10 h-10 items-center justify-center rounded-full border border-white/20 bg-white/10 text-white backdrop-blur transition hover:bg-white/15 disabled:opacity-40 disabled:cursor-not-allowed" aria-label="Sebelumnya" data-hero-prev>
                <i class="fas fa-chevron-left text-sm"></i>
            </button>
            <button type="button" class="hidden sm:flex absolute right-4 top-1/2 -translate-y-1/2 z-10 w-10 h-10 items-center justify-center rounded-full border border-white/20 bg-white/10 text-white backdrop-blur transition hover:bg-white/15 disabled:opacity-40 disabled:cursor-not-allowed" aria-label="Berikutnya" data-hero-next>
                <i class="fas fa-chevron-right text-sm"></i>
            </button>

            <div class="absolute bottom-4 left-0 right-0 z-10 px-4">
                <div class="home-hero-dots">
                    @foreach ($heroSlides as $dotSlide)
                        <button type="button" class="home-hero-dot" aria-label="Slide {{ $loop->iteration }}" aria-current="{{ $loop->first ? 'true' : 'false' }}" data-hero-dot="{{ $loop->index }}"></button>
                    @endforeach
                </div>
            </div>
        @endif
    </section>

    <section class="py-8 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
                <div class="lg:col-span-5">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold">
                        <i class="fas fa-shield-check"></i>
                        Kurasi & Verifikasi
                    </div>
                    <h2 class="mt-4 text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight">
                        Standar profesional untuk industri wedding organizer
                    </h2>
                    <p class="mt-4 text-slate-600 leading-relaxed">
                        HASTANA membantu pasangan menemukan vendor yang tepat, sekaligus menjadi wadah peningkatan kapasitas bagi para anggota melalui pelatihan, event, dan jaringan region.
                    </p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('about') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-slate-900 text-white font-semibold hover:bg-slate-800 transition">
                            <i class="fas fa-circle-info text-sm"></i>
                            Tentang HASTANA
                        </a>
                        <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl border border-slate-200 text-slate-700 font-semibold hover:bg-slate-50 transition">
                            <i class="fas fa-envelope text-sm"></i>
                            Hubungi Kami
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-7">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                            <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center">
                                <i class="fas fa-certificate"></i>
                            </div>
                            <div class="mt-4 text-lg font-bold text-slate-900">Sertifikasi</div>
                            <div class="mt-1 text-sm text-slate-600 leading-relaxed">Standar keanggotaan untuk menjaga mutu layanan dan kredibilitas anggota.</div>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                            <div class="w-11 h-11 rounded-xl bg-red-50 text-red-700 flex items-center justify-center">
                                <i class="fas fa-people-group"></i>
                            </div>
                            <div class="mt-4 text-lg font-bold text-slate-900">Kolaborasi</div>
                            <div class="mt-1 text-sm text-slate-600 leading-relaxed">Wadah berbagi pengalaman, referensi, dan sinergi antar WO lintas kota.</div>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                            <div class="w-11 h-11 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div class="mt-4 text-lg font-bold text-slate-900">Pelatihan</div>
                            <div class="mt-1 text-sm text-slate-600 leading-relaxed">Program pengembangan skill dan insight tren industri yang relevan.</div>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                                <i class="fas fa-map-location-dot"></i>
                            </div>
                            <div class="mt-4 text-lg font-bold text-slate-900">Jaringan Region</div>
                            <div class="mt-1 text-sm text-slate-600 leading-relaxed">Struktur region untuk pemantauan, pembinaan, dan dukungan anggota.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-8 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between gap-6">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Anggota Hastana</h2>
                    <p class="mt-2 text-sm text-slate-600">Wedding organizer terverifikasi yang bisa kamu hubungi.</p>
                </div>
                <a href="{{ route('members') }}" class="hidden sm:inline-flex items-center gap-2 text-sm font-semibold text-blue-700 hover:text-blue-800">
                    Lihat semua
                    <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>

            <div class="mt-8 grid grid-cols-2 lg:grid-cols-4 gap-3">
                @forelse($featuredWeddingOrganizers->take(8) as $wo)
                    <a href="{{ route('members.show', $wo->slug) }}" class="group rounded-2xl border border-slate-200 bg-white p-3 sm:p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition flex flex-col">
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                            <div class="w-12 h-12 sm:w-14 sm:h-14 shrink-0 rounded-2xl overflow-hidden bg-slate-100 flex items-center justify-center text-slate-500 mx-auto sm:mx-0">
                                @if($wo->logo)
                                    <img src="{{ asset('storage/' . $wo->logo) }}" alt="{{ $wo->brand_name ?? $wo->organizer_name }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-lg font-bold">{{ strtoupper(substr($wo->brand_name ?: $wo->organizer_name, 0, 1)) }}</span>
                                @endif
                            </div>
                            <div class="min-w-0 text-center sm:text-left">
                                <div class="text-xs sm:text-sm font-bold text-slate-900 truncate">{{ \Illuminate\Support\Str::ucfirst($wo->brand_name ?: $wo->organizer_name) }}</div>
                                <div class="text-xs text-slate-600 truncate">{{ $wo->city ?? '-' }}</div>
                                <div class="mt-1 inline-flex items-center gap-1 text-xs font-semibold text-amber-600">
                                    <i class="fas fa-map-marker-alt text-[11px]"></i>
                                    <span class="truncate">{{ $wo->region?->region_name ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 flex items-center justify-between">
                            <span class="text-xs px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 font-semibold">
                                {{ $wo->verification_status === 'verified' ? 'Terverifikasi' : 'Belum' }}
                            </span>
                            <span class="text-xs font-semibold text-red-600 group-hover:text-red-700">Detail</span>
                        </div>
                    </a>
                @empty
                    @foreach ($data['featured_members'] as $member)
                        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                            <div class="text-sm font-bold text-slate-900">{{ $member['name'] }}</div>
                            <div class="text-xs text-slate-600 mt-1">{{ $member['location'] }}</div>
                        </div>
                    @endforeach
                @endforelse
            </div>
        </div>
    </section>

    @if(($featuredProducts?->count() ?? 0) > 0)
        <section class="py-8 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-end justify-between gap-6">
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Paket populer</h2>
                        <p class="mt-2 text-sm text-slate-600">Beberapa paket/produk yang sedang menarik perhatian.</p>
                    </div>
                    <a href="{{ route('members') }}" class="hidden sm:inline-flex items-center gap-2 text-sm font-semibold text-blue-700 hover:text-blue-800">
                        Jelajahi paket
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>

                <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                    @forelse($featuredProducts->take(6) as $product)
                        <a href="{{ $product->weddingOrganizer?->slug ? route('members.product', ['slug' => $product->weddingOrganizer->slug, 'productId' => $product->id]) : '#' }}"
                            class="group rounded-2xl border border-slate-200 bg-white overflow-hidden shadow-sm hover:shadow-md transition">
                            <div class="aspect-[4/5] bg-slate-100 overflow-hidden">
                                <img src="{{ $product->main_image }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-[1.02] transition-transform duration-300">
                            </div>
                            <div class="p-5">
                                <div class="flex items-center justify-between gap-3">
                                    <div class="min-w-0">
                                        <div class="text-sm font-bold text-slate-900 truncate">{{ $product->name }}</div>
                                        <div class="text-xs text-slate-600 truncate">{{ $product->weddingOrganizer?->brand_name ?: $product->weddingOrganizer?->organizer_name ?: 'Wedding Organizer' }}</div>
                                    </div>
                                    @if($product->limited_offer)
                                        <span class="text-xs px-2.5 py-1 rounded-full bg-red-50 text-red-700 font-semibold">Terbatas</span>
                                    @endif
                                </div>
                                <div class="mt-4 flex items-end justify-between">
                                    <div>
                                        @if((float) $product->original_price > (float) $product->price)
                                            <div class="text-xs text-slate-400 line-through">Rp {{ number_format($product->original_price) }}</div>
                                        @endif
                                        <div class="text-base font-extrabold text-slate-900">Rp {{ number_format($product->price) }}</div>
                                    </div>
                                    <span class="text-sm font-semibold text-blue-700 group-hover:text-blue-800">Detail</span>
                                </div>
                            </div>
                        </a>
                    @empty
                    @endforelse
                </div>
            </div>
        </section>
    @endif

    <section class="py-8 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between gap-6">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Event terdekat</h2>
                    <p class="mt-2 text-sm text-slate-600">Workshop, pelatihan, dan networking untuk anggota.</p>
                </div>
                <a href="{{ route('events') }}" class="hidden sm:inline-flex items-center gap-2 text-sm font-semibold text-blue-700 hover:text-blue-800">
                    Semua event
                    <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>

            <div class="mt-8 grid grid-cols-2 lg:grid-cols-4 gap-3">
                @forelse($upcomingEvents as $event)
                    <a href="{{ route('events.show', $event->slug) }}" class="group rounded-2xl border border-slate-200 bg-white overflow-hidden shadow-sm hover:shadow-md transition">
                        <div class="aspect-[4/5] bg-slate-100 overflow-hidden">
                            <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-[1.02] transition-transform duration-300">
                        </div>
                        <div class="p-3 sm:p-5">
                            <div class="text-xs text-slate-600 flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
                                <span class="inline-flex items-center gap-1">
                                    <i class="fas fa-calendar text-slate-400"></i>
                                    {{ $event->formatted_date }}
                                </span>
                                <span class="hidden sm:inline text-slate-300">•</span>
                                <span class="inline-flex items-center gap-1">
                                    <i class="fas fa-location-dot text-slate-400"></i>
                                    {{ $event->city ?? $event->location }}
                                </span>
                            </div>
                            <div class="mt-2 text-xs sm:text-sm font-bold text-slate-900 line-clamp-2">{{ $event->title }}</div>
                            <div class="mt-3 flex items-center justify-between">
                                <span class="text-xs font-semibold text-red-600">
                                    {{ $event->is_free ? 'GRATIS' : $event->formatted_price }}
                                </span>
                                <span class="text-xs font-semibold text-slate-700 group-hover:text-red-600">Detail</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="rounded-2xl border border-slate-200 bg-gray-50 p-6 text-sm text-slate-600">
                        Event belum tersedia saat ini.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="py-8 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between gap-6">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Artikel terbaru</h2>
                    <p class="mt-2 text-sm text-slate-600">Wawasan untuk anggota dan pasangan calon pengantin.</p>
                </div>
                <a href="{{ route('blog') }}" class="hidden sm:inline-flex items-center gap-2 text-sm font-semibold text-blue-700 hover:text-blue-800">
                    Ke blog
                    <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>

            <div class="mt-8 grid grid-cols-2 lg:grid-cols-4 gap-3">
                @forelse($latestBlogs as $blog)
                    <a href="{{ route('blog.detail', $blog->slug) }}" class="group rounded-2xl border border-slate-200 bg-white overflow-hidden shadow-sm hover:shadow-md transition">
                        <div class="aspect-[4/5] bg-slate-100 overflow-hidden">
                            <img src="{{ $blog->featured_image_url }}" alt="{{ $blog->title }}" class="w-full h-full object-cover group-hover:scale-[1.02] transition-transform duration-300">
                        </div>
                        <div class="p-3 sm:p-5">
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-xs px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-full bg-slate-100 text-slate-700 font-semibold truncate">
                                    {{ $blog->category?->name ?? 'Artikel' }}
                                </span>
                                <span class="text-xs text-slate-500 shrink-0 hidden sm:inline">{{ $blog->formatted_date }}</span>
                            </div>
                            <div class="mt-2 sm:mt-3 text-xs sm:text-sm font-bold text-slate-900 line-clamp-2">{{ $blog->title }}</div>
                            <div class="mt-1 sm:mt-2 text-xs sm:text-sm text-slate-600 line-clamp-2 hidden sm:block">{{ $blog->excerpt ?: Str::limit(strip_tags($blog->content ?? ''), 120) }}</div>
                            <div class="mt-3 sm:mt-4 inline-flex items-center gap-2 text-xs sm:text-sm font-semibold text-red-600 group-hover:text-red-700">
                                Baca
                                <i class="fas fa-arrow-right text-xs"></i>
                            </div>
                        </div>
                    </a>
                @empty
                    @foreach ($data['latest_articles'] as $article)
                        <div class="rounded-2xl border border-slate-200 bg-gray-50 p-6">
                            <div class="text-sm font-bold text-slate-900">{{ $article['title'] }}</div>
                            <div class="text-xs text-slate-500 mt-1">{{ $article['date'] }}</div>
                            <div class="text-sm text-slate-600 mt-3">{{ $article['excerpt'] }}</div>
                        </div>
                    @endforeach
                @endforelse
            </div>
        </div>
    </section>

    <section class="py-8 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-3xl border border-slate-200 bg-gradient-to-r from-slate-900 to-slate-800 overflow-hidden">
                <div class="px-6 py-10 sm:px-10 sm:py-12">
                    <div class="max-w-3xl">
                        <div class="text-white/70 text-sm font-semibold">Untuk Wedding Organizer</div>
                        <h2 class="mt-3 text-3xl sm:text-4xl font-bold text-white tracking-tight">
                            Tingkatkan kredibilitas dan akses peluang kolaborasi
                        </h2>
                        <p class="mt-4 text-white/70 leading-relaxed">
                            Daftarkan WO kamu, lengkapi dokumen, dan tampil di direktori anggota. Ikuti event pelatihan dan terhubung dengan jaringan region.
                        </p>
                        <div class="mt-7 flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('join') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-white text-slate-900 font-semibold hover:bg-white/90 transition">
                                <i class="fas fa-plus-circle"></i>
                                Daftar Sekarang
                            </a>
                            <a href="{{ route('contact') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl border border-white/15 bg-white/5 text-white font-semibold hover:bg-white/10 transition home-card">
                                <i class="fas fa-envelope"></i>
                                Konsultasi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        (function () {
            function initHeroCarousel(root) {
                const track = root.querySelector('[data-hero-track]');
                if (!track) return;

                const slides = Array.from(track.children);
                const prevBtn = root.querySelector('[data-hero-prev]');
                const nextBtn = root.querySelector('[data-hero-next]');
                const dotButtons = Array.from(root.querySelectorAll('[data-hero-dot]'));

                if (slides.length <= 1) {
                    if (prevBtn) prevBtn.classList.add('hidden');
                    if (nextBtn) nextBtn.classList.add('hidden');
                    return;
                }

                let index = 0;
                let isDragging = false;
                let startX = 0;
                let startTranslatePx = 0;
                let didDrag = false;

                function setDisabledStates() {
                    if (prevBtn) prevBtn.disabled = index <= 0;
                    if (nextBtn) nextBtn.disabled = index >= slides.length - 1;
                }

                function setIndex(nextIndex) {
                    index = Math.max(0, Math.min(slides.length - 1, nextIndex));
                    track.style.transition = 'transform 400ms ease';
                    track.style.transform = 'translateX(-' + (index * 100) + '%)';
                    if (dotButtons.length) {
                        dotButtons.forEach(function (btn, i) {
                            btn.setAttribute('aria-current', i === index ? 'true' : 'false');
                        });
                    }
                    setDisabledStates();
                }

                function goPrev() {
                    setIndex(index - 1);
                }

                function goNext() {
                    setIndex(index + 1);
                }

                if (prevBtn) prevBtn.addEventListener('click', goPrev);
                if (nextBtn) nextBtn.addEventListener('click', goNext);

                if (dotButtons.length) {
                    dotButtons.forEach(function (btn) {
                        btn.addEventListener('click', function () {
                            const targetIndex = Number(btn.getAttribute('data-hero-dot'));
                            if (Number.isFinite(targetIndex)) setIndex(targetIndex);
                        });
                    });
                }

                function onPointerDown(e) {
                    if (e.button != null && e.button !== 0) return;
                    isDragging = true;
                    didDrag = false;
                    startX = e.clientX;
                    startTranslatePx = -index * root.clientWidth;
                    track.style.transition = 'none';
                }

                function onPointerMove(e) {
                    if (!isDragging) return;
                    const dx = e.clientX - startX;
                    if (Math.abs(dx) > 6) didDrag = true;
                    track.style.transform = 'translateX(' + (startTranslatePx + dx) + 'px)';
                }

                function onPointerEnd(e) {
                    if (!isDragging) return;
                    isDragging = false;
                    const dx = e.clientX - startX;
                    const threshold = root.clientWidth * 0.2;
                    if (dx > threshold) {
                        setIndex(index - 1);
                    } else if (dx < -threshold) {
                        setIndex(index + 1);
                    } else {
                        setIndex(index);
                    }
                    if (didDrag) {
                        e.preventDefault();
                    }
                    didDrag = false;
                }

                track.addEventListener('pointerdown', onPointerDown);
                track.addEventListener('pointermove', onPointerMove);
                track.addEventListener('pointerup', onPointerEnd);
                track.addEventListener('pointercancel', onPointerEnd);

                window.addEventListener('resize', function () {
                    track.style.transition = 'none';
                    track.style.transform = 'translateX(-' + (index * 100) + '%)';
                    setDisabledStates();
                });

                setIndex(0);
            }

            function boot() {
                document.querySelectorAll('[data-hero-carousel]').forEach(initHeroCarousel);
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', boot);
            } else {
                boot();
            }
        })();
    </script>
@endpush
