@extends('layouts.app')

@section('title', $blog->title . ' - HASTANA Indonesia')

@section('content')
<style>
    /* Blog Content Styling */
    .blog-content {
        font-family: 'Poppins', sans-serif;
        color: #1f2937;
        line-height: 1.9;
    }
    
    .blog-content p {
        font-size: 14px;
        line-height: 1.9;
        margin-bottom: 18px;
        color: #4b5563;
        text-align: justify;
    }
    
    .blog-content p:first-of-type::first-letter {
        font-size: 3.5em;
        font-weight: 700;
        float: left;
        line-height: 0.85;
        margin: 0.1em 0.1em 0 0;
        color: #3b82f6;
    }
    
    .blog-content h1 {
        font-size: 26px;
        font-weight: 700;
        color: #111827;
        margin-top: 36px;
        margin-bottom: 18px;
        line-height: 1.3;
        border-left: 5px solid #3b82f6;
        padding-left: 16px;
        padding-bottom: 0;
        border-bottom: none;
        background: linear-gradient(90deg, #eff6ff 0%, transparent 100%);
        padding-top: 8px;
        padding-bottom: 8px;
    }
    
    .blog-content h2 {
        font-size: 22px;
        font-weight: 700;
        color: #1f2937;
        margin-top: 32px;
        margin-bottom: 16px;
        line-height: 1.4;
        border-left: 4px solid #6366f1;
        padding-left: 14px;
        background: linear-gradient(90deg, #f5f3ff 0%, transparent 100%);
        padding-top: 6px;
        padding-bottom: 6px;
    }
    
    .blog-content h3 {
        font-size: 18px;
        font-weight: 600;
        color: #374151;
        margin-top: 28px;
        margin-bottom: 14px;
        line-height: 1.4;
        border-left: 3px solid #8b5cf6;
        padding-left: 12px;
    }
    
    .blog-content h4,
    .blog-content h5,
    .blog-content h6 {
        font-size: 16px;
        font-weight: 600;
        color: #4b5563;
        margin-top: 24px;
        margin-bottom: 12px;
        padding-left: 10px;
        border-left: 2px solid #d1d5db;
    }
    
    .blog-content ul,
    .blog-content ol {
        margin-bottom: 20px;
        padding-left: 32px;
        background: #f9fafb;
        padding-top: 14px;
        padding-bottom: 14px;
        border-radius: 8px;
    }
    
    .blog-content ul li,
    .blog-content ol li {
        font-size: 14px;
        line-height: 1.8;
        margin-bottom: 10px;
        color: #4b5563;
        padding-left: 8px;
    }
    
    .blog-content ul li {
        list-style-type: none;
        position: relative;
    }
    
    .blog-content ul li::before {
        content: "▸";
        color: #3b82f6;
        font-weight: bold;
        position: absolute;
        left: -24px;
        font-size: 16px;
    }
    
    .blog-content ol li {
        list-style-type: none;
        counter-increment: list-counter;
        position: relative;
    }
    
    .blog-content ol {
        counter-reset: list-counter;
    }
    
    .blog-content ol li::before {
        content: counter(list-counter);
        color: white;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        font-weight: 600;
        position: absolute;
        left: -32px;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        text-align: center;
        line-height: 22px;
    }
    
    .blog-content blockquote {
        font-size: 14px;
        font-style: italic;
        border-left: 5px solid #3b82f6;
        padding-left: 24px;
        padding-right: 20px;
        padding-top: 16px;
        padding-bottom: 16px;
        margin: 28px 0;
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border-radius: 0 12px 12px 0;
        color: #1e40af;
        position: relative;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.1);
    }
    
    .blog-content blockquote::before {
        content: '"';
        font-size: 48px;
        position: absolute;
        top: -8px;
        left: 12px;
        color: #3b82f6;
        opacity: 0.3;
        font-family: Georgia, serif;
    }
    
    .blog-content a {
        color: #3b82f6;
        text-decoration: none;
        font-weight: 500;
        border-bottom: 2px solid transparent;
        transition: all 0.3s;
        padding-bottom: 1px;
    }
    
    .blog-content a:hover {
        color: #2563eb;
        border-bottom-color: #3b82f6;
    }
    
    .blog-content strong {
        font-weight: 600;
        color: #111827;
        background: linear-gradient(180deg, transparent 60%, #fef3c7 60%);
        padding: 0 2px;
    }
    
    .blog-content em {
        font-style: italic;
        color: #6366f1;
    }
    
    .blog-content code {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        padding: 3px 8px;
        border-radius: 5px;
        font-size: 13px;
        font-family: 'Monaco', 'Courier New', monospace;
        color: #dc2626;
        font-weight: 500;
        border: 1px solid #fbbf24;
    }
    
    .blog-content pre {
        background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
        color: #f9fafb;
        padding: 20px;
        border-radius: 12px;
        overflow-x: auto;
        margin: 24px 0;
        border: 1px solid #374151;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }
    
    .blog-content pre code {
        background: transparent;
        color: #f9fafb;
        padding: 0;
        border: none;
        font-size: 13px;
    }
    
    .blog-content img {
        border-radius: 12px;
        margin: 28px auto;
        max-width: 100%;
        height: auto;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s;
        border: 4px solid #f3f4f6;
    }
    
    .blog-content img:hover {
        transform: scale(1.02);
    }
    
    .blog-content hr {
        border: none;
        height: 3px;
        background: linear-gradient(90deg, transparent 0%, #3b82f6 50%, transparent 100%);
        margin: 40px 0;
        border-radius: 2px;
    }
    
    .blog-content table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin: 24px 0;
        font-size: 13px;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    
    .blog-content table th {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        padding: 14px;
        text-align: left;
        font-weight: 600;
        border: none;
    }
    
    .blog-content table td {
        padding: 12px 14px;
        border-bottom: 1px solid #e5e7eb;
        background: white;
    }
    
    .blog-content table tr:last-child td {
        border-bottom: none;
    }
    
    .blog-content table tr:nth-child(even) td {
        background: #f9fafb;
    }
    
    .blog-content table tr:hover td {
        background: #eff6ff;
    }
    
    /* Reading Progress Indicator */
    .blog-content::before {
        content: '';
        display: block;
        height: 4px;
        background: linear-gradient(90deg, #3b82f6 0%, #8b5cf6 100%);
        border-radius: 2px;
        margin-bottom: 24px;
    }
</style>
<div class="min-h-screen bg-gray-50 pt-20">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-7xl mx-auto">
            
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

            <!-- Breadcrumb -->
            <nav class="mb-6 text-xs">
                <ol class="flex items-center space-x-2 text-gray-500">
                    <li><a href="{{ route('home') }}" class="hover:text-amber-600">Home</a></li>
                    <li>/</li>
                    <li><a href="{{ route('blog') }}" class="hover:text-amber-600">Blog</a></li>
                    <li>/</li>
                    <li class="text-gray-700">{{ Str::limit($blog->title, 50) }}</li>
                </ol>
            </nav>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left Column - Article -->
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
                    
                    <!-- Views Counter on Image -->
                    <div class="absolute top-4 right-4">
                        <div class="flex items-center gap-2 bg-black/60 backdrop-blur-sm text-white px-3 py-1.5 rounded-full text-xs font-medium">
                            <i class="fas fa-eye"></i>
                            <span>{{ number_format($blog->views_count ?? 0) }}</span>
                        </div>
                    </div>
                </div>
                @endif

                <div class="p-8">
                    
                    <!-- Meta -->
                    <div class="flex items-center gap-4 mb-6 text-xs text-gray-600">
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
                        @auth
                        <div onclick="toggleLike()" id="like-button" class="flex items-center gap-2 cursor-pointer transition-all hover:scale-105">
                            <i class="fas fa-heart mr-1" id="heart-icon"></i>
                            <span id="like-count">{{ number_format($blog->likes_count ?? 0) }}</span>
                            <span id="like-text">likes</span>
                        </div>
                        @else
                        <a href="{{ route('login') }}" class="flex items-center gap-2 hover:text-pink-500 transition-all">
                            <i class="far fa-heart mr-1"></i>
                            <span>{{ number_format($blog->likes_count ?? 0) }}</span>
                            <span>likes</span>
                        </a>
                        @endauth
                    </div>

                    <!-- Title -->
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $blog->title }}</h1>

                    <!-- Engagement Stats -->
                    {{-- <div class="flex items-center gap-6 mb-6 pb-6 border-b">
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <i class="fas fa-eye text-blue-500"></i>
                            <span>{{ number_format($blog->views_count ?? 0) }} views</span>
                        </div>
                        <button onclick="toggleLike()" id="like-button" class="flex items-center gap-2 text-sm font-medium transition-all hover:scale-105">
                            <i class="fas fa-heart mr-1" id="heart-icon"></i>
                            <span id="like-count">{{ number_format($blog->likes_count ?? 0) }}</span>
                            <span id="like-text">likes</span>
                        </button>
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <i class="fas fa-comment text-gray-500"></i>
                            <span>{{ number_format($blog->comments()->where('is_approved', true)->count()) }} comments</span>
                        </div>
                    </div> --}}

                    <!-- Excerpt -->
                    {{-- @if($blog->excerpt)
                    <div class="text-lg text-gray-600 mb-8">{{ $blog->excerpt }}</div>
                    @endif --}}

                    <!-- Content -->
                    <div class="blog-content">
                        {!! $blog->content !!}
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

            <!-- Comments Section -->
            <section class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-comments text-blue-600"></i>
                        Komentar
                        <span class="text-sm font-normal text-gray-500">({{ $blog->comments()->where('is_approved', true)->count() }})</span>
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
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none text-sm"
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
                                <i class="fas fa-lock text-amber-600 text-base"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 mb-1 text-base">Login untuk Berkomentar</h3>
                                <p class="text-xs text-gray-600 mb-3">
                                    Silakan login terlebih dahulu untuk memberikan komentar pada artikel ini.
                                </p>
                                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-amber-500 text-white px-4 py-2 rounded-lg hover:bg-amber-600 font-semibold text-xs">
                                    <i class="fas fa-sign-in-alt"></i>
                                    Login Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                @endauth

                <!-- Comments List -->
                <div class="space-y-4">
                    @forelse($blog->comments()->where('is_approved', true)->whereNull('parent_id')->orderBy('created_at', 'desc')->get() as $comment)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                        <div class="flex items-start gap-3">
                            <!-- Avatar -->
                            <div class="flex-shrink-0">
                                @if($comment->avatar)
                                    <img src="{{ $comment->avatar }}" alt="{{ $comment->name }}" class="w-10 h-10 rounded-full">
                                @else
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold">
                                        {{ strtoupper(substr($comment->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>

                            <!-- Comment Content -->
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-semibold text-gray-900 text-sm">{{ $comment->name }}</span>
                                    @if($comment->is_approved)
                                        <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Terverifikasi</span>
                                    @endif
                                    <span class="text-xs text-gray-500">• {{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-gray-700 mb-2 text-sm">{{ $comment->comment }}</p>
                                
                                <!-- Comment Actions -->
                                @auth
                                <div class="flex items-center gap-3 text-xs">
                                    <button onclick="likeComment({{ $comment->id }})" class="text-gray-500 hover:text-blue-600 flex items-center gap-1">
                                        <i class="far fa-thumbs-up"></i>
                                        <span>Suka</span>
                                    </button>
                                    @if(auth()->user()->email === $comment->email)
                                    <button onclick="deleteComment({{ $comment->id }})" class="text-gray-500 hover:text-red-600 flex items-center gap-1">
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
                        <i class="fas fa-comments text-3xl mb-3 text-gray-300"></i>
                        <p class="text-sm">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                    </div>
                    @endforelse
                </div>
            </section>
            </div>
            
            <!-- Right Column - Sidebar Widgets -->
            <aside class="lg:col-span-1">
                
                <!-- Author Widget -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-6 top-24">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-user-circle text-blue-600"></i>
                        Tentang Penulis
                    </h3>
                    <div class="text-center mb-4">
                        <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full mx-auto mb-3 flex items-center justify-center text-white text-2xl font-bold">
                            {{ strtoupper(substr($blog->author ? $blog->author->name : 'A', 0, 1)) }}
                        </div>
                        <h4 class="font-semibold text-gray-900 text-sm">{{ $blog->author ? $blog->author->name : 'Anonymous' }}</h4>
                        <p class="text-xs text-gray-500 mt-1">Content Writer</p>
                    </div>
                    <p class="text-xs text-gray-600 text-center mb-4">Penulis artikel informatif seputar pernikahan dan event organizing</p>
                    <div class="flex justify-center gap-3">
                        <a href="#" class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 hover:bg-blue-200 transition">
                            <i class="fab fa-facebook-f text-sm"></i>
                        </a>
                        <a href="#" class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 hover:bg-blue-200 transition">
                            <i class="fab fa-twitter text-sm"></i>
                        </a>
                        <a href="#" class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 hover:bg-blue-200 transition">
                            <i class="fab fa-linkedin-in text-sm"></i>
                        </a>
                    </div>
                </div>

                <!-- Popular Posts Widget -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-fire text-orange-500"></i>
                        Artikel Populer
                    </h3>
                    @php
                        $popularBlogs = \App\Models\Blog::where('is_published', true)
                            ->where('id', '!=', $blog->id)
                            ->orderBy('views_count', 'desc')
                            ->take(5)
                            ->get();
                    @endphp
                    <div class="space-y-4">
                        @foreach($popularBlogs as $index => $popularBlog)
                        <a href="{{ route('blog.detail', $popularBlog->slug) }}" class="flex gap-3 group hover:bg-gray-50 p-2 rounded-lg transition">
                            <div class="flex-shrink-0">
                                <span class="w-8 h-8 bg-gradient-to-br from-orange-500 to-red-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                    {{ $index + 1 }}
                                </span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-xs font-semibold text-gray-900 group-hover:text-blue-600 transition line-clamp-2 mb-1">
                                    {{ $popularBlog->title }}
                                </h4>
                                <div class="flex items-center gap-2 text-xs text-gray-500">
                                    <i class="fas fa-eye"></i>
                                    <span>{{ number_format($popularBlog->views_count ?? 0) }}</span>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- Categories Widget -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-folder text-purple-600"></i>
                        Kategori
                    </h3>
                    @php
                        $categories = \App\Models\BlogCategory::withCount([
                            'blogs' => function($query) {
                                $query->where('is_published', true);
                            }
                        ])
                        ->has('blogs')
                        ->orderBy('blogs_count', 'desc')
                        ->take(8)
                        ->get();
                    @endphp
                    <div class="space-y-2">
                        @foreach($categories as $category)
                        <a href="{{ route('blog') }}?category={{ $category->slug }}" class="flex items-center justify-between p-2 rounded-lg hover:bg-purple-50 transition group">
                            <span class="text-xs text-gray-700 group-hover:text-purple-600 font-medium">{{ $category->name }}</span>
                            <span class="text-xs bg-purple-100 text-purple-600 px-2 py-1 rounded-full">{{ $category->blogs_count }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- Tags Cloud Widget -->
                {{-- <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-tags text-green-600"></i>
                        Tag Populer
                    </h3>
                    @php
                        $allTags = \App\Models\Blog::where('is_published', true)
                            ->whereNotNull('tags')
                            ->pluck('tags')
                            ->flatten()
                            ->map(function($tags) {
                                return is_array($tags) ? $tags : explode(',', $tags);
                            })
                            ->flatten()
                            ->map(function($tag) {
                                return trim($tag);
                            })
                            ->filter()
                            ->countBy()
                            ->sortDesc()
                            ->take(15);
                    @endphp
                    <div class="flex flex-wrap gap-2">
                        @foreach($allTags as $tag => $count)
                        <a href="{{ route('blog') }}?tag={{ urlencode($tag) }}" class="px-3 py-1 bg-green-50 text-green-700 rounded-full text-xs hover:bg-green-100 transition font-medium">
                            #{{ $tag }} <span class="text-green-500">({{ $count }})</span>
                        </a>
                        @endforeach
                    </div>
                </div> --}}
                
            </aside>
            
            </div>
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

// Toggle blog like
function toggleLike() {
    @guest
        window.location.href = '{{ route('login') }}';
        return;
    @endguest
    
    const blogSlug = '{{ $blog->slug }}';
    const likeButton = document.getElementById('like-button');
    const heartIcon = document.getElementById('heart-icon');
    const likeCount = document.getElementById('like-count');
    
    fetch(`/api/blog/${blogSlug}/like`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update count
            likeCount.textContent = new Intl.NumberFormat().format(data.likes_count);
            
            // Update button style
            if (data.liked) {
                likeButton.classList.remove('text-gray-600');
                likeButton.classList.add('text-pink-500');
                heartIcon.classList.remove('far');
                heartIcon.classList.add('fas');
            } else {
                likeButton.classList.remove('text-pink-500');
                likeButton.classList.add('text-gray-600');
                heartIcon.classList.remove('fas');
                heartIcon.classList.add('far');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    });
}

// Initialize like button state
document.addEventListener('DOMContentLoaded', function() {
    const likeButton = document.getElementById('like-button');
    const heartIcon = document.getElementById('heart-icon');
    
    // Check if user has liked this blog
    @auth
    if (likeButton && heartIcon) {
        fetch(`/api/blog/{{ $blog->slug }}/check-like`)
            .then(response => response.json())
            .then(data => {
                if (data.liked) {
                    likeButton.classList.add('text-pink-500');
                    heartIcon.classList.add('fas');
                } else {
                    likeButton.classList.add('text-gray-600');
                    heartIcon.classList.add('far');
                }
            })
            .catch(error => console.error('Error:', error));
    }
    @endauth
});

// Like comment
function likeComment(commentId) {
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
            alert(data.liked ? 'Komentar disukai!' : 'Suka dibatalkan');
        }
    })
    .catch(error => console.error('Error:', error));
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
</script>
@endsection
