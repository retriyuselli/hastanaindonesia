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
        top: 0.75rem;
        left: 0.75rem;
        z-index: 10;
    }
    
    .featured-post {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(220, 38, 38, 0.1));
        border: 2px solid #3b82f6;
    }
    
    .read-time {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        font-size: 0.75rem;
        color: #6b7280;
    }
    
    .author-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .post-stats {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.75rem;
        color: #6b7280;
    }
    
    .trending-badge {
        background: linear-gradient(45deg, #ff6b6b, #feca57);
        color: white;
        padding: 0.25rem 0.625rem;
        border-radius: 9999px;
        font-size: 0.625rem;
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
<section class="bg-gradient-to-r from-red-900 via-red-800 to-blue-800 py-16 text-white mt-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="font-poppins text-3xl md:text-5xl font-bold mb-5">
            Blog HASTANA
        </h1>
        <p class="text-lg mb-6 text-white/90">
            Tips, tren, dan panduan lengkap untuk wedding organizer profesional
        </p>
        
        <!-- Search Box -->
        <div class="search-box max-w-md mx-auto">
            <form action="{{ route('blog') }}" method="GET" class="relative">
                <input type="text" 
                       name="search" 
                       id="searchInput"
                       value="{{ request('search') }}"
                       placeholder="Cari artikel..." 
                       class="w-full px-3 py-2.5 pl-10 pr-10 text-sm text-gray-900 bg-white rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                @if(request('search'))
                <button type="button" onclick="clearSearch()" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-sm"></i>
                </button>
                @endif
            </form>
        </div>
    </div>
</section>

@if(request('search'))
<!-- Search Result Info -->
<section class="py-6 bg-blue-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">
                    Menampilkan hasil pencarian untuk: 
                    <span class="font-bold text-gray-900">"{{ request('search') }}"</span>
                </p>
                <p class="text-xs text-gray-500 mt-1">
                    Ditemukan {{ $blogs->total() }} artikel
                </p>
            </div>
            <a href="{{ route('blog') }}" class="text-sm text-blue-600 hover:text-blue-800 font-semibold">
                <i class="fas fa-times mr-1"></i>Hapus Filter
            </a>
        </div>
    </div>
</section>
@endif

@if($blogs->count() > 0)
<!-- Featured Post -->
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3">Artikel Pilihan</h2>
            <p class="text-base text-gray-600">Artikel terbaru dan trending dari komunitas HASTANA</p>
        </div>
        
        @php
            $featuredPost = $blogs->first();
        @endphp
        
        <div class="featured-post bg-white rounded-3xl shadow-2xl overflow-hidden">
            <div class="lg:flex">
                <div class="lg:w-1/2">
                    <img src="{{ $featuredPost->featured_image_url }}"
                         alt="{{ $featuredPost->title }}" 
                         class="w-full h-56 lg:h-full object-cover">
                </div>
                <div class="lg:w-1/2 p-6 lg:p-10">
                    <div class="flex items-center gap-2.5 mb-5">
                        <span class="trending-badge">FEATURED</span>
                        <span class="bg-blue-100 text-blue-800 px-2.5 py-1 rounded-full text-xs font-semibold">
                            {{ $featuredPost->category->name ?? 'Artikel' }}
                        </span>
                    </div>
                    
                    <h3 class="text-xl lg:text-2xl font-bold text-gray-900 mb-3 leading-tight">
                        {{ $featuredPost->title }}
                    </h3>
                    
                    <p class="text-gray-600 mb-5 leading-relaxed text-sm">
                        {{ $featuredPost->excerpt }}
                    </p>
                    
                    <div class="flex items-center justify-between mb-5">
                        <div class="author-info">
                            @if($featuredPost->author)
                                <img src="{{ $featuredPost->author->avatar_url }}" 
                                     alt="{{ $featuredPost->author->name }}" 
                                     class="w-10 h-10 rounded-full">
                                <div>
                                    <p class="font-semibold text-gray-900 text-sm">{{ $featuredPost->author->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $featuredPost->published_at->format('d M Y') }}</p>
                                </div>
                            @else
                                <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?w=40&h=40&fit=crop&crop=face&auto=format" 
                                     alt="Author" 
                                     class="w-10 h-10 rounded-full">
                                <div>
                                    <p class="font-semibold text-gray-900 text-sm">Anonymous</p>
                                    <p class="text-xs text-gray-500">{{ $featuredPost->published_at->format('d M Y') }}</p>
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
                            <span><i class="fas fa-eye mr-1"></i>{{ number_format($featuredPost->views_count ?? 0) }} views</span>
                            <span><i class="fas fa-heart mr-1"></i>{{ number_format($featuredPost->likes_count ?? 0) }} likes</span>
                            <span><i class="fas fa-comment mr-1"></i>{{ number_format($featuredPost->comments_count ?? 0) }} comments</span>
                        </div>
                        <a href="{{ route('blog.detail', $featuredPost->slug) }}" 
                           class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-5 py-2.5 rounded-full hover:from-blue-700 hover:to-blue-800 transition-all font-semibold text-sm">
                            Baca Selengkapnya
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blog Grid -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-3">Artikel Terbaru</h2>
            <p class="text-base text-gray-600">Update terbaru dari dunia wedding organizer</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($blogs->skip(1) as $blog)
            <div class="blog-card bg-white rounded-2xl shadow-lg overflow-hidden relative">
                <div class="category-badge">
                    <span class="bg-{{ $blog->category->color ?? 'blue' }}-500 text-white px-2.5 py-1 rounded-full text-xs font-bold">
                        {{ strtoupper($blog->category->name ?? 'ARTIKEL') }}
                    </span>
                </div>
                <div class="relative">
                    <img src="{{ $blog->featured_image_url }}" 
                         alt="{{ $blog->title }}" 
                         class="w-full h-44 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                </div>
                <div class="p-5">
                    <div class="flex items-center gap-1.5 mb-2.5">
                        <span class="bg-{{ $blog->category->color ?? 'blue' }}-100 text-{{ $blog->category->color ?? 'blue' }}-800 px-2.5 py-1 rounded-full text-xs">
                            {{ $blog->category->name ?? 'Artikel' }}
                        </span>
                        <span class="text-xs text-gray-500">{{ $blog->published_at->format('d M Y') }}</span>
                    </div>
                    
                    <h3 class="text-base font-bold text-gray-900 mb-2.5">{{ $blog->title }}</h3>
                    <p class="text-gray-600 mb-3 text-sm leading-relaxed">
                        {{ Str::limit($blog->excerpt, 120) }}
                    </p>
                    
                    <div class="flex items-center justify-between mb-3">
                        <div class="author-info">
                            @if($blog->author)
                                <img src="{{ $blog->author->avatar_url }}" 
                                     alt="{{ $blog->author->name }}" 
                                     class="w-8 h-8 rounded-full">
                                <span class="text-xs font-semibold">{{ $blog->author->name }}</span>
                            @else
                                <img src="https://images.unsplash.com/photo-1566492031773-4f4e44671d66?w=32&h=32&fit=crop&crop=face&auto=format" 
                                     alt="Author" 
                                     class="w-8 h-8 rounded-full">
                                <span class="text-xs font-semibold">Anonymous</span>
                            @endif
                        </div>
                        <div class="read-time">
                            <i class="fas fa-clock text-gray-400"></i>
                            <span>{{ $blog->read_time ?? 15 }} min</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="post-stats">
                            <span><i class="fas fa-eye mr-1 text-gray-400"></i>{{ number_format($blog->views_count ?? 0) }}</span>
                            <span><i class="fas fa-heart mr-1 text-red-400"></i>{{ number_format($blog->likes_count ?? 0) }}</span>
                        </div>
                        <a href="{{ route('blog.detail', $blog->slug) }}" 
                           class="text-blue-600 hover:text-blue-800 font-semibold text-xs">
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
            {{ $blogs->appends(['search' => request('search')])->links() }}
        </div>
        @endif
    </div>
</section>

@else
<!-- No Posts Message -->
<section class="py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="bg-white rounded-2xl shadow-lg p-10">
            @if(request('search'))
                <i class="fas fa-search text-5xl text-gray-300 mb-5"></i>
                <h2 class="text-xl font-bold text-gray-900 mb-3">Artikel Tidak Ditemukan</h2>
                <p class="text-gray-600 mb-6 text-sm">
                    Tidak ada hasil untuk pencarian "<span class="font-bold">{{ request('search') }}</span>". 
                    Coba kata kunci lain atau hapus filter.
                </p>
                <div class="flex gap-3 justify-center">
                    <a href="{{ route('blog') }}" 
                       class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-2.5 rounded-full hover:from-blue-700 hover:to-blue-800 transition-all font-semibold text-sm">
                        <i class="fas fa-times mr-2"></i>Hapus Filter
                    </a>
                    <a href="{{ route('home') }}" 
                       class="bg-gray-200 text-gray-700 px-6 py-2.5 rounded-full hover:bg-gray-300 transition-all font-semibold text-sm">
                        Kembali ke Home
                    </a>
                </div>
            @else
                <i class="fas fa-newspaper text-5xl text-gray-300 mb-5"></i>
                <h2 class="text-xl font-bold text-gray-900 mb-3">Belum Ada Artikel</h2>
                <p class="text-gray-600 mb-6 text-sm">Artikel-artikel menarik akan segera hadir. Stay tuned!</p>
                <a href="{{ route('home') }}" 
                   class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-2.5 rounded-full hover:from-blue-700 hover:to-blue-800 transition-all font-semibold text-sm">
                    Kembali ke Home
                </a>
            @endif
        </div>
    </div>
</section>
@endif

<!-- Newsletter Section -->
{{-- <section class="bg-gradient-to-r from-blue-800 to-red-800 py-16 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-2xl font-bold mb-3">Subscribe Newsletter</h2>
        <p class="text-base mb-6 text-white/90">
            Dapatkan update artikel terbaru langsung di email Anda
        </p>
        
        <form class="max-w-md mx-auto flex gap-3">
            <input type="email" placeholder="Email Anda" 
                   class="flex-1 px-3 py-2.5 text-gray-900 rounded-full focus:outline-none focus:ring-2 focus:ring-white text-sm">
            <button type="submit" 
                    class="px-6 py-2.5 bg-white text-blue-800 rounded-full hover:bg-gray-100 transition-colors font-semibold text-sm">
                Subscribe
            </button>
        </form>
    </div>
</section> --}}

@endsection

@push('scripts')
<script>
// Clear search function
function clearSearch() {
    window.location.href = "{{ route('blog') }}";
}

// Auto submit on Enter key
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    
    if (searchInput) {
        // Submit on Enter
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                this.form.submit();
            }
        });
        
        // Optional: Live search with debounce
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            
            // Only trigger if minimum 3 characters
            if (this.value.length >= 3 || this.value.length === 0) {
                searchTimeout = setTimeout(() => {
                    // Uncomment below for auto-submit while typing
                    // this.form.submit();
                }, 500);
            }
        });
    }
});
</script>
@endpush