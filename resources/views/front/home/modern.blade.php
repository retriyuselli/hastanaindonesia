@extends('layouts.app')

@section('title', 'HASTANA Indonesia - Himpunan Perusahaan Penata Acara Seluruh Indonesia')
@section('description', 'Organisasi resmi yang menaungi para wedding organizer profesional di Indonesia. Mendukung profesionalisme dan kolaborasi WO di seluruh Indonesia.')

@push('styles')
    <style>
        .home-hero {
            background:
                radial-gradient(60rem 60rem at 15% 20%, rgba(37, 99, 235, 0.35), transparent 60%),
                radial-gradient(55rem 55rem at 85% 30%, rgba(239, 68, 68, 0.30), transparent 55%),
                radial-gradient(45rem 45rem at 60% 90%, rgba(168, 85, 247, 0.18), transparent 55%),
                linear-gradient(180deg, #020617, #0b1220);
        }

        .home-grid {
            background-image: radial-gradient(rgba(148, 163, 184, 0.18) 1px, transparent 1px);
            background-size: 18px 18px;
            mask-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.85), transparent);
        }

        .home-card {
            backdrop-filter: blur(10px);
        }
    </style>
@endpush

@section('content')
    <section class="home-hero relative overflow-hidden">
        <div class="absolute inset-0 home-grid opacity-60"></div>
        <div class="absolute -top-24 -left-24 w-80 h-80 rounded-full bg-blue-500/25 blur-3xl"></div>
        <div class="absolute -top-24 -right-24 w-80 h-80 rounded-full bg-red-500/20 blur-3xl"></div>
        <div class="absolute -bottom-28 left-1/2 -translate-x-1/2 w-[42rem] h-[42rem] rounded-full bg-purple-500/10 blur-3xl"></div>

        <div class="relative pt-28 pb-14">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border border-white/10 bg-white/5 text-white/80 text-xs home-card">
                        <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-white/10">
                            <i class="fas fa-sparkles text-[10px] text-white/90"></i>
                        </span>
                        <span>Organisasi resmi wedding organizer di Indonesia</span>
                    </div>

                    <h1 class="mt-5 text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-white">
                        HASTANA Indonesia
                    </h1>
                    <p class="mt-4 text-base sm:text-lg text-white/75 leading-relaxed">
                        Direktori anggota terverifikasi, event pelatihan, dan ekosistem kolaborasi untuk meningkatkan profesionalisme wedding organizer di seluruh Indonesia.
                    </p>

                    <div class="mt-7 flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('members') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-white text-slate-900 font-semibold hover:bg-white/90 transition">
                            <i class="fas fa-users text-sm"></i>
                            Jelajahi Anggota
                        </a>
                        <a href="{{ route('join') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">
                            <i class="fas fa-handshake text-sm"></i>
                            Daftar Menjadi Anggota
                        </a>
                        <a href="{{ route('regions.index') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl border border-white/15 bg-white/5 text-white font-semibold hover:bg-white/10 transition home-card">
                            <i class="fas fa-map-marked-alt text-sm"></i>
                            Profile Region
                        </a>
                    </div>

                    <form action="{{ route('members') }}" method="GET" class="mt-8">
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                            <div class="sm:col-span-7">
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-white/50">
                                        <i class="fas fa-magnifying-glass"></i>
                                    </span>
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari WO, brand, atau kota"
                                        class="w-full pl-10 pr-4 py-3 rounded-xl bg-white/10 border border-white/10 text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-blue-500/60 focus:border-transparent home-card">
                                </div>
                            </div>
                            <div class="sm:col-span-3">
                                <select name="province"
                                    class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/10 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/60 focus:border-transparent home-card">
                                    <option value="" class="text-slate-900">Semua Provinsi</option>
                                    @foreach (config('indonesia.provinces', []) as $province)
                                        <option value="{{ $province }}" class="text-slate-900" {{ request('province') === $province ? 'selected' : '' }}>
                                            {{ $province }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="sm:col-span-2">
                                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-red-600 text-white font-semibold hover:bg-red-700 transition">
                                    <i class="fas fa-arrow-right"></i>
                                    Cari
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="mt-10 grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4 home-card">
                            <div class="text-xs text-white/60">Anggota</div>
                            <div class="mt-1 text-2xl font-bold text-white">{{ number_format($totalWeddingOrganizers ?? 0) }}</div>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4 home-card">
                            <div class="text-xs text-white/60">Region</div>
                            <div class="mt-1 text-2xl font-bold text-white">{{ number_format($totalRegions ?? 0) }}</div>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4 home-card">
                            <div class="text-xs text-white/60">Event</div>
                            <div class="mt-1 text-2xl font-bold text-white">Rutin</div>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4 home-card">
                            <div class="text-xs text-white/60">Verifikasi</div>
                            <div class="mt-1 text-2xl font-bold text-white">Aktif</div>
                        </div>
                    </div>
                </div>

                <div class="mt-12 lg:mt-0 lg:absolute lg:right-10 lg:top-24 lg:w-[34rem] hidden lg:block">
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-6 home-card shadow-[0_30px_80px_rgba(0,0,0,0.35)]">
                        <div class="flex items-center justify-between">
                            <div class="text-sm font-semibold text-white/90">Anggota Terverifikasi</div>
                            <a href="{{ route('members') }}" class="text-xs text-white/70 hover:text-white transition">Lihat semua</a>
                        </div>
                        <div class="mt-4 grid grid-cols-2 gap-3">
                            @forelse($featuredWeddingOrganizers->take(4) as $wo)
                                <a href="{{ route('members.show', $wo->slug) }}" class="rounded-2xl border border-white/10 bg-white/5 p-4 hover:bg-white/10 transition home-card">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl overflow-hidden bg-white/10 flex items-center justify-center text-white/80">
                                            @if($wo->logo)
                                                <img src="{{ asset('storage/' . $wo->logo) }}" alt="{{ $wo->brand_name ?? $wo->organizer_name }}" class="w-full h-full object-cover">
                                            @else
                                                <span class="text-sm font-bold">{{ strtoupper(substr($wo->brand_name ?: $wo->organizer_name, 0, 1)) }}</span>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <div class="text-sm font-semibold text-white truncate">{{ $wo->brand_name ?: $wo->organizer_name }}</div>
                                            <div class="text-xs text-white/60 truncate">{{ $wo->city ?? '-' }}</div>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                @foreach($data['featured_members'] as $member)
                                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4 home-card">
                                        <div class="text-sm font-semibold text-white">{{ $member['name'] }}</div>
                                        <div class="text-xs text-white/60 mt-1">{{ $member['location'] }}</div>
                                    </div>
                                @endforeach
                            @endforelse
                        </div>
                        <div class="mt-5 rounded-2xl border border-white/10 bg-gradient-to-r from-blue-500/15 to-red-500/15 p-4 home-card">
                            <div class="flex items-center justify-between">
                                <div class="text-sm font-semibold text-white">Mau jadi anggota?</div>
                                <a href="{{ route('join') }}" class="text-xs text-white hover:text-white/90 transition">Daftar</a>
                            </div>
                            <div class="text-xs text-white/65 mt-1">Lengkapi profil dan dapatkan akses event serta kolaborasi.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-white">
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
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
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

    <section class="py-16 bg-gray-50">
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

            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @forelse($featuredWeddingOrganizers->take(8) as $wo)
                    <a href="{{ route('members.show', $wo->slug) }}" class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl overflow-hidden bg-slate-100 flex items-center justify-center text-slate-500">
                                @if($wo->logo)
                                    <img src="{{ asset('storage/' . $wo->logo) }}" alt="{{ $wo->brand_name ?? $wo->organizer_name }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-lg font-bold">{{ strtoupper(substr($wo->brand_name ?: $wo->organizer_name, 0, 1)) }}</span>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <div class="text-sm font-bold text-slate-900 truncate">{{ $wo->brand_name ?: $wo->organizer_name }}</div>
                                <div class="text-xs text-slate-600 truncate">{{ $wo->city ?? '-' }}{{ $wo->province ? ', ' . $wo->province : '' }}</div>
                                <div class="mt-2 inline-flex items-center gap-2">
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold text-amber-600">
                                        <i class="fas fa-star text-[11px]"></i>
                                        {{ number_format((float) ($wo->rating ?? 0), 1) }}/5
                                    </span>
                                    <span class="text-xs text-slate-500">{{ (int) ($wo->completed_events ?? 0) }} ulasan</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-xs px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 font-semibold">
                                {{ $wo->verification_status === 'verified' ? 'Terverifikasi' : 'Belum' }}
                            </span>
                            <span class="text-xs font-semibold text-blue-700 group-hover:text-blue-800">Detail</span>
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

    @if(($featuredProducts?->count() ?? 0) > 10)
        <section class="py-16 bg-white">
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

                <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($featuredProducts->take(6) as $product)
                        <a href="{{ $product->weddingOrganizer?->slug ? route('members.product', ['slug' => $product->weddingOrganizer->slug, 'productId' => $product->id]) : '#' }}"
                            class="group rounded-2xl border border-slate-200 bg-white overflow-hidden shadow-sm hover:shadow-md transition">
                            <div class="aspect-[16/10] bg-slate-100 overflow-hidden">
                                <img src="{{ $product->main_image }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-[1.02] transition-transform duration-300">
                            </div>
                            <div class="p-5">
                                <div class="flex items-center justify-between gap-4">
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
                        <div class="rounded-2xl border border-slate-200 bg-gray-50 p-6 text-sm text-slate-600">
                            Paket belum tersedia saat ini.
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    @endif

    <section class="py-16 bg-gray-50">
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

            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @forelse($upcomingEvents as $event)
                    <a href="{{ route('events.show', $event->slug) }}" class="group rounded-2xl border border-slate-200 bg-white overflow-hidden shadow-sm hover:shadow-md transition">
                        <div class="aspect-[16/10] bg-slate-100 overflow-hidden">
                            <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-[1.02] transition-transform duration-300">
                        </div>
                        <div class="p-5">
                            <div class="text-xs text-slate-600 flex items-center gap-2">
                                <span class="inline-flex items-center gap-1">
                                    <i class="fas fa-calendar text-slate-400"></i>
                                    {{ $event->formatted_date }}
                                </span>
                                <span class="text-slate-300">•</span>
                                <span class="inline-flex items-center gap-1">
                                    <i class="fas fa-location-dot text-slate-400"></i>
                                    {{ $event->city ?? $event->location }}
                                </span>
                            </div>
                            <div class="mt-2 text-sm font-bold text-slate-900 line-clamp-2">{{ $event->title }}</div>
                            <div class="mt-3 flex items-center justify-between">
                                <span class="text-xs font-semibold text-blue-700">
                                    {{ $event->is_free ? 'GRATIS' : $event->formatted_price }}
                                </span>
                                <span class="text-xs font-semibold text-slate-700 group-hover:text-blue-800">Detail</span>
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

    <section class="py-16 bg-white">
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

            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
                @forelse($latestBlogs as $blog)
                    <a href="{{ route('blog.detail', $blog->slug) }}" class="group rounded-2xl border border-slate-200 bg-white overflow-hidden shadow-sm hover:shadow-md transition">
                        <div class="aspect-[16/10] bg-slate-100 overflow-hidden">
                            <img src="{{ $blog->featured_image_url }}" alt="{{ $blog->title }}" class="w-full h-full object-cover group-hover:scale-[1.02] transition-transform duration-300">
                        </div>
                        <div class="p-5">
                            <div class="flex items-center justify-between gap-3">
                                <span class="text-xs px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 font-semibold">
                                    {{ $blog->category?->name ?? 'Artikel' }}
                                </span>
                                <span class="text-xs text-slate-500">{{ $blog->formatted_date }}</span>
                            </div>
                            <div class="mt-3 text-sm font-bold text-slate-900 line-clamp-2">{{ $blog->title }}</div>
                            <div class="mt-2 text-sm text-slate-600 line-clamp-2">{{ $blog->excerpt ?: Str::limit(strip_tags($blog->content ?? ''), 120) }}</div>
                            <div class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-blue-700 group-hover:text-blue-800">
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

    <section class="py-16 bg-gray-50">
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
