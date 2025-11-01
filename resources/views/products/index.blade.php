@extends('layouts.app')

@section('title', 'Kelola Produk - HASTANA Indonesia')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16 mt-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl font-bold mb-2">Kelola Produk</h1>
            <p class="text-blue-100">{{ $weddingOrganizer->organizer_name }}</p>
        </div>
    </div>
</section>

<!-- Products Content -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif
            
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Daftar Produk</h2>
                <a href="{{ route('products.create', $weddingOrganizer->slug) }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Produk
                </a>
            </div>
            
            <!-- Products Grid -->
            @if($products->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
                            <div class="relative aspect-square">
                                @if($product->images && count($product->images) > 0)
                                    @php
                                        $imageUrl = str_starts_with($product->images[0], 'http') 
                                            ? $product->images[0] 
                                            : Storage::url($product->images[0]);
                                    @endphp
                                    <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400 text-5xl"></i>
                                    </div>
                                @endif
                                
                                @if(!$product->is_active)
                                    <div class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded text-xs font-semibold">
                                        Nonaktif
                                    </div>
                                @endif
                            </div>
                            
                            <div class="p-4 flex-grow">
                                <h3 class="font-bold text-sm mb-2 text-gray-900 truncate" title="{{ $product->name }}">{{ $product->name }}</h3>
                                
                                <div class="mb-3">
                                    <p class="text-[10px] text-gray-500 line-through">IDR {{ number_format($product->original_price) }}</p>
                                    <p class="text-sm font-bold text-gray-900">IDR {{ number_format($product->price) }}</p>
                                    @if($product->discount)
                                        <p class="text-[10px] text-red-600">Diskon: {{ number_format($product->discount) }}</p>
                                    @endif
                                </div>
                                
                                @if($product->badges && count($product->badges) > 0)
                                    <div class="flex gap-1 mb-3">
                                        @foreach(array_slice($product->badges, 0, 3) as $badge)
                                            <span class="px-1.5 py-0.5 bg-gray-100 text-gray-700 text-[10px] rounded-full whitespace-nowrap">{{ $badge }}</span>
                                        @endforeach
                                        @if(count($product->badges) > 3)
                                            <span class="px-1.5 py-0.5 bg-gray-200 text-gray-700 text-[10px] rounded-full font-semibold">+{{ count($product->badges) - 3 }}</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            
                            <div class="p-4 pt-0 mt-auto">
                                <div class="flex gap-2">
                                    <a href="{{ route('products.edit', [$weddingOrganizer->slug, $product->id]) }}" class="flex-1 px-2 py-1 bg-yellow-500 text-white text-center text-xs font-semibold rounded hover:bg-yellow-600 transition">
                                        <i class="fas fa-edit text-[10px] mr-1"></i>Edit
                                    </a>
                                    <form action="{{ route('products.destroy', [$weddingOrganizer->slug, $product->id]) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full px-2 py-1 bg-red-500 text-white text-xs font-semibold rounded hover:bg-red-600 transition">
                                            <i class="fas fa-trash text-[10px] mr-1"></i>Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <i class="fas fa-box-open text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Produk</h3>
                    <p class="text-gray-600 mb-6">Mulai tambahkan produk wedding organizer Anda</p>
                    <a href="{{ route('products.create', $weddingOrganizer->slug) }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Produk Pertama
                    </a>
                </div>
            @endif
            
        </div>
    </div>
</section>
@endsection
