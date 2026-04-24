@extends('layouts.app')

@section('title', ($region->region_name ?? 'Profile Region') . ' - HASTANA Indonesia')
@section('description', 'Detail profil region HASTANA Indonesia.')

@section('content')
    <div class="pt-28 pb-16 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <a href="{{ route('regions.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-hastana-blue">
                        <i class="fas fa-arrow-left mr-2 text-xs"></i>
                        Kembali ke daftar region
                    </a>
                    <h1 class="text-3xl font-bold text-gray-900 mt-3">{{ $region->region_name }}</h1>
                    <div class="mt-2 flex flex-wrap items-center gap-2 text-sm text-gray-600">
                        @if($region->province)
                            <span class="inline-flex items-center">
                                <i class="fas fa-map-marker-alt mr-2 text-xs text-gray-400"></i>{{ $region->province }}
                            </span>
                        @endif
                        @if($region->dpc_name)
                            <span class="inline-flex items-center">
                                <i class="fas fa-sitemap mr-2 text-xs text-gray-400"></i>{{ $region->dpc_name }}
                            </span>
                        @endif
                        @if(!is_null($region->is_active))
                            <span class="text-xs px-2 py-1 rounded-full {{ $region->is_active ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                {{ $region->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="hidden sm:block w-20 h-20 rounded-2xl overflow-hidden bg-white border border-gray-100 shadow-sm">
                    @if($region->logo)
                        <img src="{{ asset('storage/' . $region->logo) }}" alt="{{ $region->region_name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <i class="fas fa-map-marked-alt text-2xl"></i>
                        </div>
                    @endif
                </div>
            </div>

            @php
                $galleryImages = collect($region->gallery_images ?? [])
                    ->filter()
                    ->map(fn ($path) => str_starts_with($path, 'http') ? $path : \Illuminate\Support\Facades\Storage::url($path));

                $memberLogos = $members
                    ->getCollection()
                    ->pluck('logo')
                    ->filter()
                    ->map(fn ($path) => str_starts_with($path, 'http') ? $path : \Illuminate\Support\Facades\Storage::url($path));

                $galleryImages = $galleryImages
                    ->merge($memberLogos)
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
                        <button id="region-gallery-prev" type="button" class="hidden sm:flex items-center justify-center absolute left-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/90 border border-gray-200 shadow-sm hover:bg-white">
                            <i class="fas fa-chevron-left text-gray-700 text-sm"></i>
                        </button>
                        <button id="region-gallery-next" type="button" class="hidden sm:flex items-center justify-center absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/90 border border-gray-200 shadow-sm hover:bg-white">
                            <i class="fas fa-chevron-right text-gray-700 text-sm"></i>
                        </button>

                        <div id="region-gallery-track" class="pb-4 overflow-x-auto scroll-smooth snap-x snap-mandatory select-none" style="cursor: grab; scrollbar-width: none; -ms-overflow-style: none;">
                            <div class="flex">
                                @foreach ($galleryImages as $src)
                                    <div data-slide class="snap-start shrink-0 w-full box-border px-4">
                                        <div class="w-full aspect-[4/3] lg:aspect-video rounded-2xl overflow-hidden bg-black">
                                            <img src="{{ $src }}" alt="Foto region" class="w-full h-full object-cover object-center">
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
                        <h2 class="text-lg font-semibold text-gray-900">Informasi Region</h2>
                        <dl class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                            @if($region->address)
                                <div class="sm:col-span-2">
                                    <dt class="text-gray-500">Alamat</dt>
                                    <dd class="text-gray-900 mt-1">{{ $region->address }}</dd>
                                </div>
                            @endif
                            @if($region->contact_email)
                                <div>
                                    <dt class="text-gray-500">Email</dt>
                                    <dd class="text-gray-900 mt-1">
                                        <a href="mailto:{{ $region->contact_email }}" class="text-hastana-blue hover:underline">{{ $region->contact_email }}</a>
                                    </dd>
                                </div>
                            @endif
                            @if($region->contact_phone)
                                <div>
                                    <dt class="text-gray-500">Telepon</dt>
                                    <dd class="text-gray-900 mt-1">
                                        <a href="tel:{{ $region->contact_phone }}" class="text-hastana-blue hover:underline">{{ $region->contact_phone }}</a>
                                    </dd>
                                </div>
                            @endif
                            @if($region->website)
                                <div class="sm:col-span-2">
                                    <dt class="text-gray-500">Website</dt>
                                    <dd class="text-gray-900 mt-1">
                                        <a href="{{ $region->website }}" target="_blank" rel="noopener" class="text-hastana-blue hover:underline">{{ $region->website }}</a>
                                    </dd>
                                </div>
                            @endif
                            @if($region->establishment_date)
                                <div>
                                    <dt class="text-gray-500">Tanggal Berdiri</dt>
                                    <dd class="text-gray-900 mt-1">{{ optional($region->establishment_date)->format('d M Y') }}</dd>
                                </div>
                            @endif
                        </dl>
                        @if($region->description)
                            <div class="mt-6">
                                <h3 class="text-sm font-semibold text-gray-900">Deskripsi</h3>
                                <div class="mt-2 text-sm text-gray-700 whitespace-pre-line">{{ $region->description }}</div>
                            </div>
                        @endif
                    </div>

                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-gray-900">Anggota WO di Region Ini</h2>
                            <span class="text-sm text-gray-600">{{ $members->total() }} anggota</span>
                        </div>

                        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @forelse ($members as $member)
                                <a href="{{ route('members.show', $member->slug) }}" class="block rounded-xl border border-gray-100 hover:border-gray-200 hover:shadow-sm transition-all p-4 bg-white">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 shrink-0">
                                            <i class="fas fa-store"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <div class="text-sm font-semibold text-gray-900 truncate">{{ $member->organizer_name }}</div>
                                            <div class="text-xs text-gray-500 truncate">{{ $member->city ?? '-' }}</div>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="sm:col-span-2 text-sm text-gray-600 bg-gray-50 rounded-xl p-4">
                                    Belum ada anggota WO yang terdaftar di region ini.
                                </div>
                            @endforelse
                        </div>

                        <div class="mt-6">
                            {{ $members->links() }}
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5 space-y-6">
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-gray-900">Struktur DPW</h2>
                        <div class="mt-4 space-y-3 text-sm">
                            <div class="flex items-center justify-between gap-3">
                                <span class="text-gray-500">Ketua DPW</span>
                                <span class="text-gray-900 font-medium text-right">{{ $region->ketuaDpw?->name ?? '-' }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-3">
                                <span class="text-gray-500">Wakil Ketua 1</span>
                                <span class="text-gray-900 font-medium text-right">{{ $region->wkKetuaDpw?->name ?? '-' }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-3">
                                <span class="text-gray-500">Wakil Ketua 2</span>
                                <span class="text-gray-900 font-medium text-right">{{ $region->wkKetua2Dpw?->name ?? '-' }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-3">
                                <span class="text-gray-500">Sekretaris</span>
                                <span class="text-gray-900 font-medium text-right">{{ $region->sekretari?->name ?? '-' }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-3">
                                <span class="text-gray-500">Bendahara</span>
                                <span class="text-gray-900 font-medium text-right">{{ $region->bendahar?->name ?? '-' }}</span>
                            </div>
                        </div>

                        @auth
                            @if(auth()->user()->hasRole(config('filament-shield.super_admin.name', 'super_admin')))
                                <div class="mt-6 p-4 rounded-xl bg-gray-50">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-700">Kelengkapan Struktur</span>
                                        <span class="text-sm font-semibold text-gray-900">{{ $region->getDpwCompletionPercentage() }}%</span>
                                    </div>
                                    <div class="mt-2 w-full h-2 rounded-full bg-gray-200 overflow-hidden">
                                        <div class="h-2 rounded-full bg-hastana-blue" data-progress-width="{{ $region->getDpwCompletionPercentage() }}" style="width: 0%"></div>
                                    </div>
                                </div>
                            @endif
                        @endauth
                    </div>

                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-gray-900">Kontak Cepat</h2>
                        <div class="mt-4 space-y-3 text-sm">
                            @if($region->contact_email)
                                <a href="mailto:{{ $region->contact_email }}" class="flex items-center gap-3 rounded-xl border border-gray-100 hover:border-gray-200 hover:shadow-sm transition-all p-4">
                                    <div class="w-10 h-10 rounded-lg bg-blue-50 text-hastana-blue flex items-center justify-center">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-xs text-gray-500">Email</div>
                                        <div class="text-sm font-semibold text-gray-900 truncate">{{ $region->contact_email }}</div>
                                    </div>
                                </a>
                            @endif
                            @if($region->contact_phone)
                                <a href="tel:{{ $region->contact_phone }}" class="flex items-center gap-3 rounded-xl border border-gray-100 hover:border-gray-200 hover:shadow-sm transition-all p-4">
                                    <div class="w-10 h-10 rounded-lg bg-red-50 text-hastana-red flex items-center justify-center">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-xs text-gray-500">Telepon</div>
                                        <div class="text-sm font-semibold text-gray-900 truncate">{{ $region->contact_phone }}</div>
                                    </div>
                                </a>
                            @endif
                            @if($region->website)
                                <a href="{{ $region->website }}" target="_blank" rel="noopener" class="flex items-center gap-3 rounded-xl border border-gray-100 hover:border-gray-200 hover:shadow-sm transition-all p-4">
                                    <div class="w-10 h-10 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center">
                                        <i class="fas fa-globe"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-xs text-gray-500">Website</div>
                                        <div class="text-sm font-semibold text-gray-900 truncate">{{ $region->website }}</div>
                                    </div>
                                </a>
                            @endif
                            @if(!$region->contact_email && !$region->contact_phone && !$region->website)
                                <div class="text-sm text-gray-600 bg-gray-50 rounded-xl p-4">
                                    Kontak region belum tersedia.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        #region-gallery-track::-webkit-scrollbar { display: none; }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[data-progress-width]').forEach((el) => {
                const value = Number(el.dataset.progressWidth)
                if (!Number.isFinite(value)) return
                const clamped = Math.max(0, Math.min(100, value))
                el.style.width = `${clamped}%`
            })

            const track = document.getElementById('region-gallery-track')
            if (!track) return
            const prevButton = document.getElementById('region-gallery-prev')
            const nextButton = document.getElementById('region-gallery-next')
            const slides = track.querySelectorAll('[data-slide]')
            if (!slides.length) return

            let snapTimeout = null
            let pointerDown = false
            let startX = 0
            let startScrollLeft = 0
            let moved = false
            let blockClick = false

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
                if (e.pointerType === 'mouse') e.preventDefault()
            })

            function endDrag(e) {
                if (!pointerDown) return
                pointerDown = false
                track.style.cursor = 'grab'
                if (moved) {
                    blockClick = true
                    snapToNearest()
                    window.setTimeout(() => { blockClick = false }, 0)
                }
                try {
                    track.releasePointerCapture(e.pointerId)
                } catch (_) {}
            }

            track.addEventListener('pointerup', endDrag)
            track.addEventListener('pointercancel', endDrag)

            track.addEventListener('click', function (e) {
                if (!blockClick) return
                e.preventDefault()
                e.stopPropagation()
            }, true)

            if (prevButton) {
                prevButton.addEventListener('click', function () {
                    const current = track.scrollLeft
                    let closestIndex = 0
                    let min = Infinity
                    slides.forEach((slide, index) => {
                        const diff = Math.abs(slide.offsetLeft - current)
                        if (diff < min) {
                            min = diff
                            closestIndex = index
                        }
                    })
                    goToIndex(Math.max(0, closestIndex - 1))
                })
            }

            if (nextButton) {
                nextButton.addEventListener('click', function () {
                    const current = track.scrollLeft
                    let closestIndex = 0
                    let min = Infinity
                    slides.forEach((slide, index) => {
                        const diff = Math.abs(slide.offsetLeft - current)
                        if (diff < min) {
                            min = diff
                            closestIndex = index
                        }
                    })
                    goToIndex(Math.min(slides.length - 1, closestIndex + 1))
                })
            }
        })
    </script>
@endpush
