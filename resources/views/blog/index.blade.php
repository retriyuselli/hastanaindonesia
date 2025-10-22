@extends('layouts.app')

@section('title', 'Blog - HASTANA Indonesia')
@section('description', 'Blog dan artikel terbaru dari HASTANA Indonesia. Tips wedding organizer, tren pernikahan, dan panduan bisnis WO.')

@push('styles')
<style>
    .blog-card {
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    
    .blog-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        border-color: #3b82f6;
    }
    
    .category-badge {
        position: absolute;
        top: 1rem;
        left: 1rem;
        z-index: 10;
    }
    
    .featured-post {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(220, 38, 38, 0.1));
        border: 2px solid #3b82f6;
    }
    
    .read-time {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        color: #6b7280;
    }
    
    .author-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .post-stats {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-size: 0.875rem;
        color: #6b7280;
    }
    
    .trending-badge {
        background: linear-gradient(45deg, #ff6b6b, #feca57);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: bold;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.8; }
    }
    
    .search-box {
        position: relative;
    }
</style>
@endpush

@section('content')

<!-- Hero Section -->
<section class="bg-gradient-to-r from-red-900 via-red-800 to-blue-800 py-20 text-white mt-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="font-poppins text-4xl md:text-6xl font-bold mb-6">
            Blog HASTANA
        </h1>
        <p class="text-xl mb-8 text-white/90">
            Tips, tren, dan panduan lengkap untuk wedding organizer profesional
        </p>
        
        <!-- Search Box -->
        <div class="search-box max-w-md mx-auto">
            <div class="relative">
                <input type="text" placeholder="Cari artikel..." 
                       class="w-full px-4 py-3 pl-12 pr-4 text-gray-900 bg-white rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>
    </div>
</section>

@if($blogs->count() > 0)
<!-- Featured Post -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Artikel Pilihan</h2>
            <p class="text-lg text-gray-600">Artikel terbaru dan trending dari komunitas HASTANA</p>
        </div>
        
        @php
            $featuredPost = $blogs->first();
        @endphp
        
        <div class="featured-post bg-white rounded-3xl shadow-2xl overflow-hidden">
            <div class="lg:flex">
                <div class="lg:w-1/2">
                    <img src="{{ $featuredPost->featured_image_url }}"
                         alt="{{ $featuredPost->title }}" 
                         class="w-full h-64 lg:h-full object-cover">
                </div>
                <div class="lg:w-1/2 p-8 lg:p-12">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="trending-badge">FEATURED</span>
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $featuredPost->category->name ?? 'Artikel' }}
                        </span>
                    </div>
                    
                    <h3 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-4 leading-tight">
                        {{ $featuredPost->title }}
                    </h3>
                    
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        {{ $featuredPost->excerpt }}
                    </p>
                    
                    <div class="flex items-center justify-between mb-6">
                        <div class="author-info">
                            @if($featuredPost->author)
                                <img src="{{ $featuredPost->author->avatar_url }}" 
                                     alt="{{ $featuredPost->author->name }}" 
                                     class="w-10 h-10 rounded-full">
                                <div>
                                    <div class="font-semibold text-gray-900">{{ $featuredPost->author->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $featuredPost->published_at->format('d M Y') }}</div>
                                </div>
                            @else
                                <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?w=40&h=40&fit=crop&crop=face&auto=format" 
                                     alt="Author" 
                                     class="w-10 h-10 rounded-full">
                                <div>
                                    <div class="font-semibold text-gray-900">Anonymous</div>
                                    <div class="text-sm text-gray-500">{{ $featuredPost->published_at->format('d M Y') }}</div>
                                </div>
                            @endif
                        </div>
                        <div class="read-time">
                            <i class="fas fa-clock text-gray-400"></i>
                            <span>{{ $featuredPost->read_time ?? 15 }} min read</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="post-stats">
                            <span><i class="fas fa-eye mr-1"></i>{{ number_format($featuredPost->views_count) }} views</span>
                            <span><i class="fas fa-heart mr-1"></i>{{ number_format($featuredPost->likes_count) }} likes</span>
                            <span><i class="fas fa-comment mr-1"></i>{{ number_format($featuredPost->comments_count) }} comments</span>
                        </div>
                        <a href="{{ route('blog.detail', $featuredPost->slug) }}" 
                           class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-full hover:from-blue-700 hover:to-blue-800 transition-all font-semibold">
                            Baca Selengkapnya
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blog Grid -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Artikel Terbaru</h2>
            <p class="text-lg text-gray-600">Update terbaru dari dunia wedding organizer</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($blogs->skip(1) as $blog)
            <div class="blog-card bg-white rounded-2xl shadow-lg overflow-hidden relative">
                <div class="category-badge">
                    <span class="bg-{{ $blog->category->color ?? 'blue' }}-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                        {{ strtoupper($blog->category->name ?? 'ARTIKEL') }}
                    </span>
                </div>
                <div class="relative">
                    <img src="{{ $blog->featured_image_url }}" 
                         alt="{{ $blog->title }}" 
                         class="w-full h-48 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="bg-{{ $blog->category->color ?? 'blue' }}-100 text-{{ $blog->category->color ?? 'blue' }}-800 px-3 py-1 rounded-full text-sm">
                            {{ $blog->category->name ?? 'Artikel' }}
                        </span>
                        <span class="text-sm text-gray-500">{{ $blog->published_at->format('d M Y') }}</span>
                    </div>
                    
                    <h3 class="text-lg font-bold text-gray-900 mb-3">{{ $blog->title }}</h3>
                    <p class="text-gray-600 mb-4 text-sm leading-relaxed">
                        {{ Str::limit($blog->excerpt, 120) }}
                    </p>
                    
                    <div class="flex items-center justify-between mb-4">
                        <div class="author-info">
                            @if($blog->author)
                                <img src="{{ $blog->author->avatar_url }}" 
                                     alt="{{ $blog->author->name }}" 
                                     class="w-8 h-8 rounded-full">
                                <span class="text-sm font-semibold">{{ $blog->author->name }}</span>
                            @else
                                <img src="https://images.unsplash.com/photo-1566492031773-4f4e44671d66?w=32&h=32&fit=crop&crop=face&auto=format" 
                                     alt="Author" 
                                     class="w-8 h-8 rounded-full">
                                <span class="text-sm font-semibold">Anonymous</span>
                            @endif
                        </div>
                        <div class="read-time">
                            <i class="fas fa-clock text-gray-400"></i>
                            <span>{{ $blog->read_time ?? 15 }} min</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="post-stats">
                            <span><i class="fas fa-eye mr-1 text-gray-400"></i>{{ number_format($blog->views_count) }}</span>
                            <span><i class="fas fa-heart mr-1 text-red-400"></i>{{ number_format($blog->likes_count) }}</span>
                        </div>
                        <a href="{{ route('blog.detail', $blog->slug) }}" 
                           class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
                            Baca →
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if($blogs->hasPages())
        <div class="mt-12 flex justify-center">
            {{ $blogs->links() }}
        </div>
        @endif
    </div>
</section>

@else
<!-- No Posts Message -->
<section class="py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="bg-white rounded-2xl shadow-lg p-12">
            <i class="fas fa-newspaper text-6xl text-gray-300 mb-6"></i>
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Belum Ada Artikel</h2>
            <p class="text-gray-600 mb-8">Artikel-artikel menarik akan segera hadir. Stay tuned!</p>
            <a href="{{ route('home') }}" 
               class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-3 rounded-full hover:from-blue-700 hover:to-blue-800 transition-all font-semibold">
                Kembali ke Home
            </a>
        </div>
    </div>
</section>
@endif

<!-- Newsletter Section -->
<section class="bg-gradient-to-r from-blue-800 to-red-800 py-16 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold mb-4">Subscribe Newsletter</h2>
        <p class="text-xl mb-8 text-white/90">
            Dapatkan update artikel terbaru langsung di email Anda
        </p>
        
        <form class="max-w-md mx-auto flex gap-4">
            <input type="email" placeholder="Email Anda" 
                   class="flex-1 px-4 py-3 text-gray-900 rounded-full focus:outline-none focus:ring-2 focus:ring-white">
            <button type="submit" 
                    class="px-8 py-3 bg-white text-blue-800 rounded-full hover:bg-gray-100 transition-colors font-semibold">
                Subscribe
            </button>
        </form>
    </div>
</section>

@endsection