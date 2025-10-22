@extends('layouts.app')

@section('title', $blog->title . ' - HASTANA Indonesia')
@section('description', $blog->excerpt)

@push('styles')
<style>
    /* Enhanced Article Styling */
    .article-content {
        line-height: 1.8;
        font-size: 1.1rem;
    }
    
    .article-content h2 {
        font-size: 1.75rem;
        font-weight: bold;
        margin: 2.5rem 0 1.5rem 0;
        color: #1f2937;
        border-left: 4px solid #f59e0b;
        padding-left: 1rem;
    }
    
    .article-content h3 {
        font-size: 1.4rem;
        font-weight: 600;
        margin: 2rem 0 1rem 0;
        color: #374151;
    }
    
    .article-content p {
        margin-bottom: 1.5rem;
        color: #4b5563;
    }
    
    .article-content ul, .article-content ol {
        margin: 1.5rem 0;
        padding-left: 2rem;
    }
    
    .article-content li {
        margin-bottom: 0.75rem;
        color: #4b5563;
    }
    
    .article-content blockquote {
        border-left: 4px solid #e5e7eb;
        padding-left: 1.5rem;
        margin: 2rem 0;
        font-style: italic;
        color: #6b7280;
        background: #f9fafb;
        padding: 1.5rem;
        border-radius: 0.5rem;
    }

    /* Enhanced Like Button */
    .like-btn {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .like-btn:hover {
        transform: translateY(-2px);
        shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }
    
    .like-btn.liked {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        border-color: #dc2626;
    }
    
    .like-btn.liked::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        animation: ripple 0.6s ease-out;
    }
    
    @keyframes ripple {
        to {
            width: 100px;
            height: 100px;
            opacity: 0;
        }
    }

    /* Enhanced Like Counter Animation */
    .like-count-number {
        transition: all 0.3s ease;
        display: inline-block;
    }
    
    .like-btn.liked .like-icon {
        animation: heartBeat 0.5s ease-in-out;
    }
    
    @keyframes heartBeat {
        0%, 100% { transform: scale(1); }
        25% { transform: scale(1.3); }
        50% { transform: scale(1.1); }
        75% { transform: scale(1.2); }
    }
    
    .like-count-number.increment {
        animation: countUp 0.5s ease-out;
    }
    
    .like-count-number.decrement {
        animation: countDown 0.5s ease-out;
    }
    
    @keyframes countUp {
        0% { 
            transform: translateY(20px) scale(0.8);
            opacity: 0;
        }
        50% {
            transform: translateY(-5px) scale(1.2);
        }
        100% { 
            transform: translateY(0) scale(1);
            opacity: 1;
        }
    }
    
    @keyframes countDown {
        0% { 
            transform: translateY(-20px) scale(0.8);
            opacity: 0;
        }
        50% {
            transform: translateY(5px) scale(1.2);
        }
        100% { 
            transform: translateY(0) scale(1);
            opacity: 1;
        }
    }
    
    .like-btn:active .like-icon {
        transform: scale(0.9);
    }

    /* Enhanced View Counter */
    .view-counter {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
        border-radius: 50px;
        padding: 0.5rem 1rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Reading Progress Bar */
    .reading-progress {
        position: fixed;
        top: 0;
        left: 0;
        width: 0%;
        height: 4px;
        background: linear-gradient(90deg, #f59e0b, #d97706);
        z-index: 1000;
        transition: width 0.1s ease;
    }

    /* Share Buttons */
    .share-btn {
        transition: all 0.3s ease;
    }
    
    .share-btn:hover {
        transform: translateY(-2px);
    }

    /* Toast Notification */
    .toast {
        position: fixed;
        bottom: 20px;
        right: 20px;
        padding: 12px 24px;
        border-radius: 8px;
        color: white;
        font-weight: 600;
        z-index: 1000;
        transform: translateX(100%);
        transition: transform 0.3s ease;
    }
    
    .toast.show {
        transform: translateX(0);
    }
    
    .toast.success {
        background: #10b981;
    }
    
    .toast.error {
        background: #ef4444;
    }

    /* Enhanced Category Badge */
    .category-badge {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 600;
    }

    /* Author Section */
    .author-section {
        background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        border-radius: 1rem;
        padding: 1.5rem;
        border: 2px solid #e5e7eb;
    }

    /* Related Articles */
    .related-article-card {
        transition: all 0.3s ease;
    }
    
    .related-article-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush

@section('content')
<!-- Reading Progress Bar -->
<div class="reading-progress"></div>

<!-- Blog Container with data-blog-id for JavaScript -->
<div data-blog-id="{{ $blog->id }}" class="min-h-screen bg-gray-50 mt-20">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            
            <!-- Breadcrumb -->
            <nav class="mb-6 text-sm">
                <ol class="flex items-center space-x-2 text-gray-500">
                    <li><a href="{{ route('home') }}" class="hover:text-amber-600 transition-colors">Home</a></li>
                    <li class="text-gray-400">/</li>
                    <li><a href="{{ route('blog') }}" class="hover:text-amber-600 transition-colors">Blog</a></li>
                    <li class="text-gray-400">/</li>
                    <li class="text-gray-700 font-medium">{{ Str::limit($blog->title, 50) }}</li>
                </ol>
            </nav>

            <!-- Article Header -->
            <article class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
                
                <!-- Featured Image -->
                @if($blog->featured_image)
                <div class="relative h-96 overflow-hidden">
                    <img src="{{ $blog->featured_image_url }}" 
                         alt="{{ $blog->title }}"
                         class="w-full h-full object-cover transition-transform duration-700 hover:scale-105">
                    
                    <!-- Category Badge Overlay -->
                    @if($blog->category)
                    <div class="absolute top-4 left-4">
                        <span class="category-badge">
                            {{ $blog->category->name }}
                        </span>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Article Content -->
                <div class="p-8">
                    
                    <!-- Article Meta -->
                    <div class="flex flex-wrap items-center gap-4 mb-6 text-sm text-gray-600">
                        <!-- Author -->
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                            <span>{{ $blog->author ? $blog->author->name : 'Anonymous' }}</span>
                        </div>
                        
                        <!-- Published Date -->
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                            <time datetime="{{ $blog->published_at }}">{{ $blog->published_at->format('d M Y') }}</time>
                        </div>
                        
                        <!-- Reading Time -->
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                            <span>{{ $blog->read_time }} menit baca</span>
                        </div>
                    </div>

                    <!-- Article Title -->
                    <h1 class="text-4xl font-bold text-gray-900 mb-6 leading-tight">
                        {{ $blog->title }}
                    </h1>

                    <!-- Article Excerpt -->
                    @if($blog->excerpt)
                    <div class="text-xl text-gray-600 mb-8 font-medium leading-relaxed">
                        {{ $blog->excerpt }}
                    </div>
                    @endif

                    <!-- Engagement Stats & Actions -->
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-8 p-4 bg-gray-50 rounded-lg">
                        
                        <!-- Left: Stats -->
                        <div class="flex items-center gap-6">
                            <!-- Views Counter -->
                            <div class="view-counter">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span id="views-count">{{ number_format($blog->views_count) }}</span>
                                <span>views</span>
                            </div>
                        </div>

                        <!-- Right: Actions -->
                        <div class="flex items-center gap-3">
                            
                            <!-- Like Button -->
                            <button id="like-btn" 
                                    class="like-btn flex items-center gap-2 px-4 py-2 border-2 border-red-500 text-red-500 rounded-lg font-semibold hover:bg-red-500 hover:text-white transition-all duration-300"
                                    data-likes="{{ $blog->likes_count }}">
                                <!-- Heart Icon with Pulse Animation -->
                                <svg class="w-5 h-5 like-icon transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                </svg>
                                <!-- Enhanced Like Counter with Animation -->
                                <span id="like-count" class="like-count-number font-bold min-w-[2rem] text-center" data-count="{{ $blog->likes_count }}">
                                    @if($blog->likes_count >= 1000)
                                        {{ number_format($blog->likes_count / 1000, 1) }}K
                                    @elseif($blog->likes_count > 0)
                                        {{ number_format($blog->likes_count) }}
                                    @else
                                        0
                                    @endif
                                </span>
                                <span class="like-text">Like</span>
                            </button>

                            <!-- Share Dropdown -->
                            <div class="relative">
                                <button id="share-btn" class="share-btn flex items-center gap-2 px-4 py-2 border-2 border-blue-500 text-blue-500 rounded-lg font-semibold hover:bg-blue-500 hover:text-white transition-all duration-300">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z"></path>
                                    </svg>
                                    <span>Share</span>
                                </button>
                                
                                <!-- Share Options -->
                                <div id="share-options" class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-10">
                                    <a href="#" onclick="shareToFacebook()" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-colors">
                                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                        </svg>
                                        <span>Facebook</span>
                                    </a>
                                    <a href="#" onclick="shareToTwitter()" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-colors">
                                        <svg class="w-5 h-5 text-sky-500" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                        </svg>
                                        <span>Twitter</span>
                                    </a>
                                    <a href="#" onclick="shareToWhatsApp()" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-colors">
                                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                        </svg>
                                        <span>WhatsApp</span>
                                    </a>
                                    <a href="#" onclick="copyLink()" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-colors">
                                        <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"></path>
                                            <path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z"></path>
                                        </svg>
                                        <span>Copy Link</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Article Content -->
                    <div class="article-content prose prose-lg max-w-none">
                        {!! $blog->content !!}
                    </div>

                    <!-- Tags -->
                    @if($blog->tags)
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-semibold mb-3">Tags:</h3>
                        <div class="flex flex-wrap gap-2">
                            @php
                                // Handle both string and array formats
                                $tags = is_array($blog->tags) ? $blog->tags : explode(',', $blog->tags);
                            @endphp
                            @foreach($tags as $tag)
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm font-medium hover:bg-gray-200 transition-colors">
                                #{{ trim($tag) }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                </div>
            </article>

            <!-- Author Bio -->
            <div class="author-section mb-8">
                @if($blog->author)
                    <div class="flex items-start gap-4">
                        @if($blog->author->avatar)
                            <img src="{{ $blog->author->avatar_url }}" 
                                 alt="{{ $blog->author->name }}" 
                                 class="w-16 h-16 rounded-full object-cover">
                        @else
                            <div class="w-16 h-16 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full flex items-center justify-center text-white font-bold text-xl">
                                {{ substr($blog->author->name, 0, 1) }}
                            </div>
                        @endif
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $blog->author->name }}</h3>
                            <p class="text-gray-600 leading-relaxed">
                                {{ $blog->author->bio ?? 'Wedding organizer profesional dengan pengalaman lebih dari 5 tahun dalam industri pernikahan. Spesialis dalam menciptakan momen pernikahan yang tak terlupakan dengan sentuhan personal dan detail yang sempurna.' }}
                            </p>
                            @if($blog->author->website || $blog->author->instagram || $blog->author->facebook || $blog->author->twitter)
                                <div class="flex gap-3 mt-3">
                                    @if($blog->author->website)
                                        <a href="{{ $blog->author->website }}" target="_blank" class="text-gray-500 hover:text-amber-600 transition">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.083 9h1.946c.089-1.546.383-2.97.837-4.118A6.004 6.004 0 004.083 9zM10 2a8 8 0 100 16 8 8 0 000-16zm0 2c-.076 0-.232.032-.465.262-.238.234-.497.623-.737 1.182-.389.907-.673 2.142-.766 3.556h3.936c-.093-1.414-.377-2.649-.766-3.556-.24-.56-.5-.948-.737-1.182C10.232 4.032 10.076 4 10 4zm3.971 5c-.089-1.546-.383-2.97-.837-4.118A6.004 6.004 0 0115.917 9h-1.946zm-2.003 2H8.032c.093 1.414.377 2.649.766 3.556.24.56.5.948.737 1.182.233.23.389.262.465.262.076 0 .232-.032.465-.262.238-.234.498-.623.737-1.182.389-.907.673-2.142.766-3.556zm1.166 4.118c.454-1.147.748-2.572.837-4.118h1.946a6.004 6.004 0 01-2.783 4.118zm-6.268 0C6.412 13.97 6.118 12.546 6.03 11H4.083a6.004 6.004 0 002.783 4.118z" clip-rule="evenodd"></path>
                                            </svg>
                                        </a>
                                    @endif
                                    @if($blog->author->instagram)
                                        <a href="{{ $blog->author->instagram }}" target="_blank" class="text-gray-500 hover:text-pink-600 transition">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                            </svg>
                                        </a>
                                    @endif
                                    @if($blog->author->facebook)
                                        <a href="{{ $blog->author->facebook }}" target="_blank" class="text-gray-500 hover:text-blue-600 transition">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                            </svg>
                                        </a>
                                    @endif
                                    @if($blog->author->twitter)
                                        <a href="{{ $blog->author->twitter }}" target="_blank" class="text-gray-500 hover:text-blue-400 transition">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Related Articles -->
            @php
                $relatedBlogs = App\Models\Blog::where('id', '!=', $blog->id)
                    ->where('status', 'published')
                    ->when($blog->category_id, function($query) use ($blog) {
                        return $query->where('category_id', $blog->category_id);
                    })
                    ->latest()
                    ->take(3)
                    ->get();
            @endphp

            @if($relatedBlogs->count() > 0)
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Artikel Terkait</h2>
                <div class="grid md:grid-cols-3 gap-6">
                    @foreach($relatedBlogs as $relatedBlog)
                    <article class="related-article-card bg-white rounded-lg shadow-md overflow-hidden">
                        @if($relatedBlog->featured_image)
                        <div class="h-48 overflow-hidden">
                            <img src="{{ $relatedBlog->featured_image_url }}" 
                                 alt="{{ $relatedBlog->title }}"
                                 class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                        </div>
                        @endif
                        <div class="p-6">
                            <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">
                                <a href="{{ route('blog.detail', $relatedBlog->slug) }}" 
                                   class="hover:text-amber-600 transition-colors">
                                    {{ $relatedBlog->title }}
                                </a>
                            </h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $relatedBlog->excerpt }}</p>
                            <div class="flex justify-between items-center text-xs text-gray-500">
                                <span>{{ $relatedBlog->published_at->format('d M Y') }}</span>
                                <span>{{ $relatedBlog->read_time }} min</span>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>
            </section>
            @endif

            <!-- Comments Section (Placeholder for future) -->
            <section class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Komentar</h2>
                <div id="comments-section">
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-lg">Fitur komentar akan segera hadir!</p>
                        <p class="text-sm">Sementara waktu, silakan share pendapat Anda melalui social media.</p>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>

<!-- Toast Notification -->
<div id="toast" class="toast"></div>
@endsection

@push('scripts')
<!-- Blog Engagement Script -->
@vite('resources/js/blog-engagement.js')

<script>
    // Enhanced Blog Detail JavaScript
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🎯 DEBUG: blog-engagement.js loaded and DOM ready');
        
        // Check for blog ID element
        console.log('🔍 Checking for blog ID element...');
        const blogElement = document.querySelector('[data-blog-id]');
        console.log('🔘 Blog element found:', !!blogElement);
        
        if (blogElement) {
            const blogId = blogElement.dataset.blogId;
            console.log('🆔 Found blog ID:', blogId);
            
            if (blogId && typeof BlogEngagement !== 'undefined') {
                console.log('✅ Initializing BlogEngagement for blog:', blogId);
                
                // Add delay to ensure DOM is fully ready
                setTimeout(() => {
                    console.log('🚀 Creating BlogEngagement instance now...');
                    try {
                        window.blogEngagement = new BlogEngagement(blogId);
                        console.log('✅ BlogEngagement instance created successfully');
                    } catch (error) {
                        console.error('❌ Error creating BlogEngagement:', error);
                    }
                }, 100);
            } else {
                console.warn('⚠️ BlogEngagement class not found or blog ID missing');
            }
        } else {
            console.error('❌ No blog ID found on page');
        }

        // Reading Progress Bar
        const progressBar = document.querySelector('.reading-progress');
        if (progressBar) {
            window.addEventListener('scroll', updateReadingProgress);
        }

        // Share Button Toggle
        const shareBtn = document.getElementById('share-btn');
        const shareOptions = document.getElementById('share-options');
        
        if (shareBtn && shareOptions) {
            shareBtn.addEventListener('click', function(e) {
                e.preventDefault();
                shareOptions.classList.toggle('hidden');
            });

            // Close share options when clicking outside
            document.addEventListener('click', function(e) {
                if (!shareBtn.contains(e.target) && !shareOptions.contains(e.target)) {
                    shareOptions.classList.add('hidden');
                }
            });
        }
    });

    // Reading Progress Function
    function updateReadingProgress() {
        const article = document.querySelector('article');
        if (!article) return;

        const articleTop = article.offsetTop;
        const articleHeight = article.offsetHeight;
        const scrollTop = window.pageYOffset;
        const windowHeight = window.innerHeight;
        
        const scrolled = scrollTop - articleTop;
        const totalHeight = articleHeight - windowHeight;
        
        if (scrolled > 0 && totalHeight > 0) {
            const progress = Math.min((scrolled / totalHeight) * 100, 100);
            document.querySelector('.reading-progress').style.width = progress + '%';
        }
    }

    // Enhanced Share Functions
    function shareToFacebook() {
        const url = encodeURIComponent(window.location.href);
        const title = encodeURIComponent(document.title);
        window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank', 'width=600,height=400');
        hideShareOptions();
        showToast('Sharing to Facebook...', 'success');
    }

    function shareToTwitter() {
        const url = encodeURIComponent(window.location.href);
        const title = encodeURIComponent(document.title);
        window.open(`https://twitter.com/intent/tweet?url=${url}&text=${title}`, '_blank', 'width=600,height=400');
        hideShareOptions();
        showToast('Sharing to Twitter...', 'success');
    }

    function shareToWhatsApp() {
        const url = encodeURIComponent(window.location.href);
        const title = encodeURIComponent(document.title);
        window.open(`https://wa.me/?text=${title} ${url}`, '_blank');
        hideShareOptions();
        showToast('Sharing to WhatsApp...', 'success');
    }

    function copyLink() {
        navigator.clipboard.writeText(window.location.href).then(function() {
            showToast('Link copied to clipboard!', 'success');
        }).catch(function() {
            showToast('Failed to copy link', 'error');
        });
        hideShareOptions();
    }

    function hideShareOptions() {
        document.getElementById('share-options').classList.add('hidden');
    }

    // Enhanced Toast Function
    function showToast(message, type = 'success') {
        const toast = document.getElementById('toast');
        toast.textContent = message;
        toast.className = `toast ${type}`;
        toast.classList.add('show');
        
        setTimeout(() => {
            toast.classList.remove('show');
        }, 3000);
    }

    // Enhanced Like Counter Formatter
    function formatLikeCount(count) {
        if (count >= 1000000) {
            return (count / 1000000).toFixed(1).replace(/\.0$/, '') + 'M';
        }
        if (count >= 1000) {
            return (count / 1000).toFixed(1).replace(/\.0$/, '') + 'K';
        }
        return count.toString();
    }

    // Animate Like Counter with Direction
    function animateLikeCounter(newCount, isIncrement = true) {
        const counterElement = document.getElementById('like-count');
        if (!counterElement) return;

        // Remove previous animation classes
        counterElement.classList.remove('increment', 'decrement');
        
        // Force reflow to restart animation
        void counterElement.offsetWidth;
        
        // Add appropriate animation class
        counterElement.classList.add(isIncrement ? 'increment' : 'decrement');
        
        // Update the count with formatted number
        counterElement.textContent = formatLikeCount(newCount);
        counterElement.dataset.count = newCount;
        
        // Remove animation class after completion
        setTimeout(() => {
            counterElement.classList.remove('increment', 'decrement');
        }, 500);
    }

    // Override updateLikeButton function for better animation
    if (typeof window.blogEngagement !== 'undefined') {
        const originalUpdateLikeButton = window.blogEngagement.updateLikeButton;
        window.blogEngagement.updateLikeButton = function(isLiked, count) {
            const likeBtn = document.getElementById('like-btn');
            const currentCount = parseInt(document.getElementById('like-count')?.dataset.count || '0');
            const isIncrement = count > currentCount;
            
            if (likeBtn) {
                if (isLiked) {
                    likeBtn.classList.add('liked');
                } else {
                    likeBtn.classList.remove('liked');
                }
            }
            
            // Animate counter
            animateLikeCounter(count, isIncrement);
        };
    }

    // Global function for BlogEngagement to use
    window.showToast = showToast;
    window.animateLikeCounter = animateLikeCounter;
    window.formatLikeCount = formatLikeCount;
</script>
@endpush
