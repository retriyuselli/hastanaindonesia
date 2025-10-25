@extends('layouts.app')

@section('title', $blog->title . ' - HASTANA Indonesia')

@push('styles')
<style>
    /* Reduce all font sizes proportionally */
    body {
        font-size: 13px !important;
    }
    
    h1 {
        font-size: 1.5rem !important;
    }
    
    h2 {
        font-size: 1.25rem !important;
    }
    
    h3 {
        font-size: 1.125rem !important;
    }
    
    .text-4xl {
        font-size: 1.5rem !important;
    }
    
    .text-3xl {
        font-size: 1.25rem !important;
    }
    
    .text-2xl {
        font-size: 1.125rem !important;
    }
    
    .text-xl {
        font-size: 1rem !important;
    }
    
    .text-lg {
        font-size: 0.9375rem !important;
    }
    
    .text-base {
        font-size: 0.8125rem !important;
    }
    
    .text-sm {
        font-size: 0.75rem !important;
    }
    
    .text-xs {
        font-size: 0.625rem !important;
    }
    
    button, .btn {
        font-size: 0.75rem !important;
    }
    
    input, textarea, select {
        font-size: 0.75rem !important;
    }
    
    label {
        font-size: 0.75rem !important;
    }
    
    /* Enhanced Article Content Styling */
    .prose {
        max-width: 100% !important;
        color: #374151 !important;
        font-size: 0.875rem !important;
    }
    
    .prose p {
        font-size: 0.875rem !important;
    }
    
    .prose h2 {
        font-size: 1.25rem !important;
    }
    
    .prose h3 {
        font-size: 1rem !important;
    }
    
    /* Headings in content */
    .prose h2 {
        color: #1f2937;
        font-weight: 700;
        margin-top: 2.5rem;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 3px solid #f59e0b;
        position: relative;
    }
    
    .prose h2::before {
        content: '';
        position: absolute;
        left: 0;
        bottom: -3px;
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, #f59e0b, #d97706);
    }
    
    .prose h3 {
        color: #374151;
        font-weight: 600;
        margin-top: 2rem;
        margin-bottom: 1rem;
        padding-left: 1rem;
        border-left: 4px solid #3b82f6;
    }
    
    /* Paragraphs */
    .prose p {
        margin-bottom: 1.5rem;
        line-height: 1.8;
        text-align: justify;
    }
    
    .prose p:first-of-type::first-letter {
        font-size: 3.5rem;
        font-weight: 700;
        float: left;
        line-height: 1;
        margin-right: 0.5rem;
        margin-top: 0.1rem;
        color: #f59e0b;
    }
    
    /* Lists */
    .prose ul, .prose ol {
        margin: 1.5rem 0;
        padding-left: 1.5rem;
    }
    
    .prose ul li {
        position: relative;
        padding-left: 1.5rem;
        margin-bottom: 0.75rem;
    }
    
    .prose ul li::before {
        content: '▸';
        position: absolute;
        left: 0;
        color: #f59e0b;
        font-weight: bold;
    }
    
    .prose ol li {
        padding-left: 0.5rem;
        margin-bottom: 0.75rem;
    }
    
    .prose ol {
        counter-reset: item;
        list-style: none;
    }
    
    .prose ol li {
        counter-increment: item;
        position: relative;
    }
    
    .prose ol li::before {
        content: counter(item);
        position: absolute;
        left: -2rem;
        top: 0;
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
        width: 1.5rem;
        height: 1.5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    /* Blockquotes */
    .prose blockquote {
        border-left: 4px solid #f59e0b;
        padding: 1.5rem;
        margin: 2rem 0;
        background: linear-gradient(90deg, #fff7ed, #ffffff);
        border-radius: 0 0.5rem 0.5rem 0;
        font-style: italic;
        color: #6b7280;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }
    
    .prose blockquote p {
        margin: 0;
        font-size: 1.05rem;
    }
    
    /* Links */
    .prose a {
        color: #3b82f6;
        text-decoration: none;
        border-bottom: 2px solid transparent;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    
    .prose a:hover {
        color: #1d4ed8;
        border-bottom-color: #3b82f6;
    }
    
    /* Images */
    .prose img {
        border-radius: 0.75rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        margin: 2rem auto;
        transition: transform 0.3s ease;
    }
    
    .prose img:hover {
        transform: scale(1.02);
    }
    
    /* Code blocks */
    .prose code {
        background: #f3f4f6;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
        color: #dc2626;
        font-family: 'Courier New', monospace;
    }
    
    .prose pre {
        background: #1f2937;
        color: #f3f4f6;
        padding: 1.5rem;
        border-radius: 0.75rem;
        overflow-x: auto;
        margin: 2rem 0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    .prose pre code {
        background: transparent;
        color: inherit;
        padding: 0;
    }
    
    /* Tables */
    .prose table {
        width: 100%;
        border-collapse: collapse;
        margin: 2rem 0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border-radius: 0.5rem;
        overflow: hidden;
    }
    
    .prose th {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
        padding: 1rem;
        text-align: left;
        font-weight: 600;
    }
    
    .prose td {
        padding: 0.875rem 1rem;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .prose tr:hover {
        background: #f9fafb;
    }
    
    /* Strong/Bold */
    .prose strong {
        color: #1f2937;
        font-weight: 700;
    }
    
    /* Emphasis/Italic */
    .prose em {
        color: #6b7280;
    }
    
    /* HR */
    .prose hr {
        border: none;
        height: 2px;
        background: linear-gradient(90deg, transparent, #e5e7eb, transparent);
        margin: 3rem 0;
    }
    
    /* Add some spacing after certain elements */
    .prose h2 + p,
    .prose h3 + p {
        margin-top: 0.5rem;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .prose {
            font-size: 0.875rem !important;
        }
        
        .prose h2 {
            font-size: 1.25rem !important;
        }
        
        .prose h3 {
            font-size: 1.0625rem !important;
        }
        
        .prose p:first-of-type::first-letter {
            font-size: 2.5rem;
        }
    }
    
    /* Like Button Styling */
    .like-button {
        color: #6b7280;
        font-weight: 500;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    
    .like-button:hover {
        color: #3b82f6;
    }
    
    .like-button.liked {
        color: #3b82f6;
        font-weight: 600;
    }
    
    .like-button.liked i {
        animation: likeAnimation 0.4s ease-in-out;
    }
    
    @keyframes likeAnimation {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.3) rotate(-10deg);
        }
        100% {
            transform: scale(1) rotate(0deg);
        }
    }
    
    .like-button:active {
        transform: scale(0.95);
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50 pt-20">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-7xl mx-auto">

            <!-- Breadcrumb -->
            <nav class="mb-6 text-sm">
                <ol class="flex items-center space-x-2 text-gray-500">
                    <li><a href="{{ route('home') }}" class="hover:text-amber-600">Home</a></li>
                    <li>/</li>
                    <li><a href="{{ route('blog') }}" class="hover:text-amber-600">Blog</a></li>
                    <li>/</li>
                    <li class="text-gray-700">{{ Str::limit($blog->title, 50) }}</li>
                </ol>
            </nav>

            <!-- Main Content Grid with Sidebar -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Main Content Area -->
                <div class="lg:col-span-2">
                    
            <!-- Article -->
            <article class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
                
                <!-- Featured Image -->
                @if($blog->featured_image)
                <div class="relative h-96 overflow-hidden">
                    <img src="{{ $blog->featured_image_url }}" 
                         alt="{{ $blog->title }}"
                         class="w-full h-full object-cover">
                    
                    @if($blog->category)
                    <div class="absolute top-4 left-4">
                        <span class="bg-amber-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $blog->category->name }}
                        </span>
                    </div>
                    @endif
                    
                    <!-- Views Badge -->
                    <div class="absolute top-4 right-4">
                        <span class="bg-blue-600 bg-opacity-90 text-white px-3 py-1.5 rounded-full text-sm font-semibold flex items-center gap-2 shadow-lg backdrop-blur-sm" title="Unique views (1 IP = 1 view per 24 jam)">
                            <i class="fas fa-eye"></i>
                            {{ number_format($blog->views_count ?? 0) }}
                        </span>
                    </div>
                </div>
                @endif

                <div class="p-8">
                    
                    <!-- Meta -->
                    <div class="flex items-center gap-4 mb-6 text-sm text-gray-600">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-user"></i>
                            <span>{{ $blog->author ? $blog->author->name : 'Anonymous' }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-calendar"></i>
                            <time>{{ $blog->published_at ? $blog->published_at->format('d M Y') : $blog->created_at->format('d M Y') }}</time>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-clock"></i>
                            <span>{{ $blog->read_time ?? 5 }} menit</span>
                        </div>
                    </div>

                    <!-- Title -->
                    <div class="flex items-center justify-between mb-6">
                        <h1 class="text-4xl font-bold text-gray-900 flex-1">{{ $blog->title }}</h1>
                        
                        <!-- Admin Edit Button -->
                        @auth
                            @if(auth()->user()->isAdmin())
                            <a href="/admin/blogs/{{ $blog->slug }}/edit" 
                               class="flex items-center gap-2 px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-all shadow-md hover:shadow-lg ml-4">
                                <i class="fas fa-edit"></i>
                                <span class="font-semibold text-sm">Edit Artikel</span>
                            </a>
                            @endif
                        @endauth
                    </div>

                    <!-- Excerpt -->
                    {{-- @if($blog->excerpt)
                    <div class="text-xl text-gray-600 mb-8">{{ $blog->excerpt }}</div>
                    @endif --}}
                    
                    <!-- Reading Progress -->
                    <div class="mb-6 flex items-center gap-4 text-sm text-gray-500">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-book-open text-amber-500"></i>
                            <span>{{ $blog->read_time ?? 5 }} menit bacaan</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-layer-group text-blue-500"></i>
                            <span>{{ str_word_count(strip_tags($blog->content)) }} kata</span>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="prose prose-lg max-w-none">{!! $blog->content !!}</div>
                    
                    <!-- Share Article -->
                    <div class="mt-12 pt-8 border-t border-gray-200">
                        <div class="flex items-center justify-between flex-wrap gap-4">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-share-alt text-blue-600"></i>
                                Bagikan Artikel Ini
                            </h3>
                            <div class="flex items-center gap-3">
                                <!-- Facebook -->
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                                   target="_blank"
                                   class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                    <i class="fab fa-facebook-f"></i>
                                    <span class="text-sm font-medium">Facebook</span>
                                </a>
                                <!-- Twitter -->
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($blog->title) }}" 
                                   target="_blank"
                                   class="flex items-center gap-2 px-4 py-2 bg-sky-500 text-white rounded-lg hover:bg-sky-600 transition">
                                    <i class="fab fa-twitter"></i>
                                    <span class="text-sm font-medium">Twitter</span>
                                </a>
                                <!-- WhatsApp -->
                                <a href="https://wa.me/?text={{ urlencode($blog->title . ' - ' . request()->url()) }}" 
                                   target="_blank"
                                   class="flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                    <i class="fab fa-whatsapp"></i>
                                    <span class="text-sm font-medium">WhatsApp</span>
                                </a>
                                <!-- Copy Link -->
                                <button onclick="copyLink()" 
                                        class="flex items-center gap-2 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                                    <i class="fas fa-link"></i>
                                    <span class="text-sm font-medium">Salin Link</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Tags -->
                    @if($blog->tags)
                    <div class="mt-8 pt-6 border-t">
                        <h3 class="font-semibold mb-3">Tags:</h3>
                        <div class="flex flex-wrap gap-2">
                            @php
                                $tags = is_array($blog->tags) ? $blog->tags : explode(',', $blog->tags);
                            @endphp
                            @foreach($tags as $tag)
                            <span class="px-3 py-1 bg-gray-100 rounded-full text-sm">#{{ trim($tag) }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </article>

             <!-- Flash Messages -->
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-5 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <p class="text-green-800 text-sm font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-5 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                        <p class="text-red-800 text-sm font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-5 rounded-lg">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-circle text-red-500 mr-3 mt-0.5"></i>
                        <div class="flex-1">
                            <p class="text-red-800 text-sm font-medium mb-1">Terjadi kesalahan:</p>
                            <ul class="list-disc list-inside text-red-700 text-xs">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Comments Section -->
            <section class="bg-white rounded-lg shadow-lg p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-comments text-blue-600"></i>
                        Komentar
                        <span class="text-base font-normal text-gray-500">({{ $blog->comments()->where('is_approved', true)->count() }})</span>
                    </h2>
                </div>

                @auth
                    <!-- Comment Form -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-5 mb-6 border border-blue-100">
                        <form action="{{ route('blog.comment.store', $blog->slug) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="comment" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-pencil-alt mr-1"></i>
                                    Tulis Komentar Anda
                                </label>
                                <textarea 
                                    id="comment"
                                    name="comment" 
                                    rows="4" 
                                    maxlength="1000"
                                    class="w-full px-3 py-2.5 border border-gray-300 text-sm"
                                    placeholder="Bagikan pendapat atau pertanyaan Anda tentang artikel ini... (Min. 3 karakter, Maks. 1000 karakter)"
                                    required
                                ></textarea>
                                <div class="flex justify-between items-center mt-1">
                                    <span class="text-xs text-gray-500">
                                        <i class="fas fa-check-circle text-green-500"></i>
                                        Min. 3 karakter
                                    </span>
                                    <span id="char-count" class="text-xs text-gray-500">0 / 1000 karakter</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <p class="text-xs text-gray-500">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Komentar akan ditinjau sebelum dipublikasikan
                                </p>
                                <button 
                                    type="submit" 
                                    class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-5 py-2 rounded-lg hover:from-blue-700 hover:to-blue-800 font-semibold text-sm flex items-center gap-2">
                                    <i class="fas fa-paper-plane"></i>
                                    Kirim Komentar
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <!-- Login Prompt -->
                    <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-lg p-5 mb-6 border border-amber-200">
                        <div class="flex items-start gap-3">
                            <div class="bg-amber-100 p-2.5 rounded-full">
                                <i class="fas fa-lock text-amber-600 text-lg"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 mb-1">Login untuk Berkomentar</h3>
                                <p class="text-sm text-gray-600 mb-3">
                                    Silakan login terlebih dahulu untuk memberikan komentar pada artikel ini.
                                </p>
                                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-amber-500 text-white px-4 py-2 rounded-lg hover:bg-amber-600 font-semibold text-sm">
                                    <i class="fas fa-sign-in-alt"></i>
                                    Login Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                @endauth

                <!-- Comments List -->
                <div class="space-y-4">
                    @forelse($blog->comments()->with('user')->where('is_approved', true)->whereNull('parent_id')->orderBy('created_at', 'desc')->get() as $comment)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                        <div class="flex items-start gap-3">
                            <!-- Avatar -->
                            <div class="flex-shrink-0">
                                @php
                                    // Get avatar from user if exists, otherwise from comment
                                    $userAvatar = null;
                                    if($comment->user) {
                                        // Use avatar_url accessor if available
                                        if(method_exists($comment->user, 'getAvatarUrlAttribute')) {
                                            $userAvatar = $comment->user->avatar_url;
                                        } elseif($comment->user->avatar) {
                                            // Check if it's a full URL
                                            if(filter_var($comment->user->avatar, FILTER_VALIDATE_URL)) {
                                                $userAvatar = $comment->user->avatar;
                                            } else {
                                                // It's a storage path
                                                $userAvatar = asset('storage/' . $comment->user->avatar);
                                            }
                                        }
                                    }
                                    
                                    // Fallback to comment avatar
                                    if(!$userAvatar && $comment->avatar) {
                                        if(filter_var($comment->avatar, FILTER_VALIDATE_URL)) {
                                            $userAvatar = $comment->avatar;
                                        } else {
                                            $userAvatar = asset('storage/' . $comment->avatar);
                                        }
                                    }
                                @endphp
                                
                                @if($userAvatar)
                                    <img src="{{ $userAvatar }}" 
                                         alt="{{ $comment->name }}" 
                                         class="w-10 h-10 rounded-full object-cover border-2 border-gray-200"
                                         onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full items-center justify-center text-white font-bold text-sm hidden">
                                        {{ strtoupper(substr($comment->name, 0, 1)) }}
                                    </div>
                                @else
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                        {{ strtoupper(substr($comment->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>

                            <!-- Comment Content -->
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-semibold text-gray-900">{{ $comment->name }}</span>
                                    @if($comment->is_approved)
                                        <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Terverifikasi</span>
                                    @endif
                                    <span class="text-xs text-gray-500">• {{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-gray-700 mb-2">{{ $comment->comment }}</p>
                                
                                <!-- Comment Actions -->
                                @auth
                                <div class="flex items-center gap-3 text-xs">
                                    @php
                                        $likedComments = session('liked_comments', []);
                                        $isLiked = in_array($comment->id, $likedComments);
                                    @endphp
                                    <button 
                                        onclick="likeComment({{ $comment->id }})" 
                                        id="like-btn-{{ $comment->id }}"
                                        class="like-button {{ $isLiked ? 'liked' : '' }} flex items-center gap-1 transition-all duration-300 hover:scale-110"
                                    >
                                        <i class="{{ $isLiked ? 'fas' : 'far' }} fa-thumbs-up transition-all duration-300"></i>
                                        <span class="like-text">{{ $isLiked ? 'Disukai' : 'Suka' }}</span>
                                    </button>
                                    @if(auth()->user()->email === $comment->email)
                                    <button onclick="deleteComment({{ $comment->id }})" class="text-gray-500 hover:text-red-600 flex items-center gap-1 transition-colors duration-300">
                                        <i class="far fa-trash-alt"></i>
                                        <span>Hapus</span>
                                    </button>
                                    @endif
                                </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-comments text-4xl mb-3 text-gray-300"></i>
                        <p>Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                    </div>
                    @endforelse
                </div>
            </section>
            
            </div>
            <!-- End Main Content Area -->

            <!-- Sidebar -->
            <aside class="lg:col-span-1">
                
                <!-- Edvetorial Widget (Advertisement) -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 pb-3 border-b-2 border-amber-500">
                        Edvetorial
                    </h3>
                    
                    <!-- Square Ad Space -->
                    <div class="aspect-square bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex flex-col items-center justify-center p-6 hover:border-amber-400 transition-colors duration-300">
                        <i class="fas fa-bullhorn text-5xl text-amber-500 mb-3"></i>
                        <p class="text-sm font-semibold text-gray-700 mb-2">Advetorial Space</p>
                        <p class="text-xs text-gray-500 text-center">300x300 Advertisement</p>
                    </div>
                </div>
                
                <!-- Latest Posts Widget -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-6 sticky top-24">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 pb-3 border-b-2 border-amber-500">
                        Latest
                    </h3>
                    
                    <div class="space-y-6">
                        @php
                            $latestBlogs = \App\Models\Blog::where('id', '!=', $blog->id)
                                ->where('status', 'published')
                                ->orderBy('published_at', 'desc')
                                ->take(5)
                                ->get();
                        @endphp
                        
                        @foreach($latestBlogs as $latestBlog)
                        <div class="group">
                            <a href="{{ route('blog.detail', $latestBlog->slug) }}" class="block">
                                <!-- Thumbnail -->
                                @if($latestBlog->featured_image)
                                <div class="relative h-32 rounded-lg overflow-hidden mb-3">
                                    <img src="{{ $latestBlog->featured_image_url }}" 
                                         alt="{{ $latestBlog->title }}"
                                         class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                                    <!-- Overlay on hover -->
                                    <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                                </div>
                                @endif
                                
                                <!-- Title -->
                                <h4 class="font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-amber-600 transition-colors duration-300">
                                    {{ $latestBlog->title }}
                                </h4>
                                
                                <!-- Date -->
                                <p class="text-xs text-gray-500">
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    {{ $latestBlog->published_at ? $latestBlog->published_at->format('d F Y') : $latestBlog->created_at->format('d F Y') }}
                                </p>
                            </a>
                            
                            @if(!$loop->last)
                            <hr class="mt-6 border-gray-200">
                            @endif
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- View All Button -->
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <a href="{{ route('blog') }}" 
                           class="block text-center px-4 py-2 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-lg hover:from-amber-600 hover:to-orange-600 transition-all font-semibold text-sm">
                            <i class="fas fa-th-list mr-2"></i>
                            Lihat Semua Artikel
                        </a>
                    </div>
                </div>
                
                <!-- Advertisement Widget (Optional) -->
                <div class="bg-gray-100 rounded-lg shadow-lg p-6 text-center">
                    <p class="text-sm text-gray-500 mb-4">- Advertisement -</p>
                    <div class="bg-white rounded-lg p-8 border-2 border-dashed border-gray-300">
                        <i class="fas fa-ad text-4xl text-gray-400 mb-2"></i>
                        <p class="text-sm text-gray-500">Ad Space Available</p>
                    </div>
                </div>
                
            </aside>
            <!-- End Sidebar -->

        </div>
        <!-- End Grid Layout -->
        </div>
    </div>
</div>

<script>
// Character counter
const textarea = document.getElementById('comment');
const charCount = document.getElementById('char-count');

if (textarea && charCount) {
    textarea.addEventListener('input', function() {
        const length = this.value.length;
        charCount.textContent = `${length} / 1000 karakter`;
        
        if (length < 3) {
            charCount.classList.add('text-red-600');
            charCount.classList.remove('text-gray-500');
        } else {
            charCount.classList.remove('text-red-600');
            charCount.classList.add('text-gray-500');
        }
    });
}

// Like comment
function likeComment(commentId) {
    const button = document.getElementById(`like-btn-${commentId}`);
    const icon = button.querySelector('i');
    const text = button.querySelector('.like-text');
    
    fetch(`/api/comments/${commentId}/like`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Toggle liked state
            if (data.liked) {
                button.classList.add('liked');
                icon.classList.remove('far');
                icon.classList.add('fas');
                text.textContent = 'Disukai';
                
                // Trigger animation
                icon.style.animation = 'none';
                setTimeout(() => {
                    icon.style.animation = 'likeAnimation 0.4s ease-in-out';
                }, 10);
            } else {
                button.classList.remove('liked');
                icon.classList.remove('fas');
                icon.classList.add('far');
                text.textContent = 'Suka';
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menyukai komentar');
    });
}

// Delete comment
function deleteComment(commentId) {
    if (!confirm('Apakah Anda yakin ingin menghapus komentar ini?')) {
        return;
    }

    fetch(`/api/comments/${commentId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Komentar berhasil dihapus');
            location.reload();
        }
    })
    .catch(error => console.error('Error:', error));
}

// Copy link to clipboard
function copyLink() {
    const url = window.location.href;
    
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(url).then(() => {
            alert('Link berhasil disalin!');
        }).catch(err => {
            console.error('Error copying:', err);
            fallbackCopyTextToClipboard(url);
        });
    } else {
        fallbackCopyTextToClipboard(url);
    }
}

function fallbackCopyTextToClipboard(text) {
    const textArea = document.createElement("textarea");
    textArea.value = text;
    textArea.style.position = "fixed";
    textArea.style.top = "-999999px";
    textArea.style.left = "-999999px";
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    
    try {
        document.execCommand('copy');
        alert('Link berhasil disalin!');
    } catch (err) {
        alert('Gagal menyalin link');
    }
    
    document.body.removeChild(textArea);
}

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Add fade-in animation to prose elements on scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Observe prose elements
document.querySelectorAll('.prose > *').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(20px)';
    el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(el);
});
</script>
@endsection
