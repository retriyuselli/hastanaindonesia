@extends('layouts.app')

@section('title', 'Profile Region - HASTANA Indonesia')
@section('description', 'Daftar region HASTANA Indonesia yang telah terdaftar.')

@section('content')
    <div class="pt-28 pb-16 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Profile Region</h1>
                    <p class="text-gray-600 mt-2">Pilih region untuk melihat detail profilnya.</p>
                </div>
            </div>

            @auth
                @if(auth()->user()->hasRole(config('filament-shield.super_admin.name', 'super_admin')))
                    <div class="mt-8 bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6">
                        <form method="GET" action="{{ route('regions.index') }}" class="grid grid-cols-1 md:grid-cols-12 gap-3">
                            <div class="md:col-span-6">
                                <label class="block text-xs font-medium text-gray-700 mb-1">Pencarian</label>
                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Cari nama region / DPC / provinsi"
                                    class="w-full rounded-xl border-gray-200 focus:border-hastana-blue focus:ring-hastana-blue"
                                >
                            </div>
                            <div class="md:col-span-4">
                                <label class="block text-xs font-medium text-gray-700 mb-1">Provinsi</label>
                                <select
                                    name="province"
                                    class="w-full rounded-xl border-gray-200 focus:border-hastana-blue focus:ring-hastana-blue"
                                >
                                    <option value="">Semua</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province }}" @selected(request('province') === $province)>
                                            {{ $province }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-2 flex items-end gap-2">
                                <button type="submit" class="w-full bg-hastana-blue text-white px-4 py-2 rounded-xl hover:bg-blue-800 transition-colors">
                                    Filter
                                </button>
                                <a href="{{ route('regions.index') }}" class="w-full text-center px-4 py-2 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50 transition-colors">
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>
                @endif
            @endauth

            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($regions as $region)
                    <a href="{{ route('regions.show', $region) }}" class="block bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow p-6">
                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 rounded-xl overflow-hidden bg-gray-100 flex items-center justify-center shrink-0">
                                @if($region->logo)
                                    <img src="{{ asset('storage/' . $region->logo) }}" alt="{{ $region->region_name }}" class="w-full h-full object-cover">
                                @else
                                    <i class="fas fa-map-marked-alt text-gray-400 text-xl"></i>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <div class="flex items-center gap-2">
                                    <h2 class="text-lg font-semibold text-gray-900 truncate">{{ $region->region_name }}</h2>
                                    @if(!is_null($region->is_active))
                                        <span class="text-xs px-2 py-1 rounded-full {{ $region->is_active ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                            {{ $region->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    @endif
                                </div>
                                @if($region->dpc_name)
                                    <p class="text-sm text-gray-600 mt-1 truncate">{{ $region->dpc_name }}</p>
                                @endif
                                <div class="text-sm text-gray-500 mt-3 flex flex-col gap-1">
                                    @if($region->province)
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-map-marker-alt text-xs text-gray-400 w-4"></i>
                                            <span class="truncate">{{ $region->province }}</span>
                                        </div>
                                    @endif
                                    @if($region->contact_email)
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-envelope text-xs text-gray-400 w-4"></i>
                                            <span class="truncate">{{ $region->contact_email }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="mt-4 text-hastana-blue font-medium text-sm">
                                    Lihat detail <i class="fas fa-arrow-right ml-1 text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full bg-white rounded-2xl border border-gray-100 p-10 text-center text-gray-600">
                        Tidak ada region yang ditemukan.
                    </div>
                @endforelse
            </div>

            <div class="mt-10">
                {{ $regions->links() }}
            </div>
        </div>
    </div>
@endsection
