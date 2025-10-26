@extends('layouts.app')

@section('title', $blog->title . ' - HASTANA Indonesia')

@section('content')
<style>
    /* Blog Content Styling */
    .blog-content {
        font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
        color: #1f2937;
        line-height: 1.8;
    }
    
    .blog-content p {
        font-size: 0.9375rem;
        line-height: 1.8;
        margin-bottom: 1.25rem;
        color: #374151;
    }
    
    .blog-content h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #111827;
        margin-top: 2rem;
        margin-bottom: 1rem;
        line-height: 1.3;
        border-bottom: 2px solid #e5e7eb;
        padding-bottom: 0.5rem;
    }
    
    .blog-content h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #111827;
        margin-top: 1.75rem;
        margin-bottom: 0.875rem;
        line-height: 1.4;
    }
    
    .blog-content h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
        line-height: 1.4;
    }
    
    .blog-content h4,
    .blog-content h5,
    .blog-content h6 {
        font-size: 1.0625rem;
        font-weight: 600;
        color: #374151;
        margin-top: 1.25rem;
        margin-bottom: 0.625rem;
    }
    
    .blog-content ul,
    .blog-content ol {
        margin-bottom: 1.25rem;
        padding-left: 1.75rem;
    }
    
    .blog-content ul li,
    .blog-content ol li {
        font-size: 0.9375rem;
        line-height: 1.7;
        margin-bottom: 0.5rem;
        color: #374151;
    }
    
    .blog-content ul li {
        list-style-type: disc;
    }
    
    .blog-content ol li {
        list-style-type: decimal;
    }
    
    .blog-content ul li::marker {
        color: #3b82f6;
    }
    
    .blog-content ol li::marker {
        color: #3b82f6;
        font-weight: 600;
    }
    
    .blog-content blockquote {
        font-size: 0.9375rem;
        font-style: italic;
        border-left: 4px solid #3b82f6;
        padding-left: 1.25rem;
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
        margin: 1.5rem 0;
        background: #eff6ff;
        border-radius: 0 0.5rem 0.5rem 0;
        color: #1e40af;
    }
    
    .blog-content a {
        color: #3b82f6;
        text-decoration: underline;
        text-underline-offset: 2px;
        transition: color 0.2s;
    }
    
    .blog-content a:hover {
        color: #2563eb;
    }
    
    .blog-content strong {
        font-weight: 600;
        color: #111827;
    }
    
    .blog-content em {
        font-style: italic;
    }
    
    .blog-content code {
        background: #f3f4f6;
        padding: 0.125rem 0.375rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
        font-family: 'Monaco', 'Courier New', monospace;
        color: #dc2626;
    }
    
    .blog-content pre {
        background: #1f2937;
        color: #f9fafb;
        padding: 1rem;
        border-radius: 0.5rem;
        overflow-x: auto;
        margin: 1.25rem 0;
    }
    
    .blog-content pre code {
        background: transparent;
        color: #f9fafb;
        padding: 0;
    }
    
    .blog-content img {
        border-radius: 0.5rem;
        margin: 1.5rem auto;
        max-width: 100%;
        height: auto;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    .blog-content hr {
        border: none;
        border-top: 2px solid #e5e7eb;
        margin: 2rem 0;
    }
    
    .blog-content table {
        width: 100%;
        border-collapse: collapse;
        margin: 1.25rem 0;
        font-size: 0.875rem;
    }
    
    .blog-content table th {
        background: #f3f4f6;
        padding: 0.75rem;
        text-align: left;
        font-weight: 600;
        border: 1px solid #e5e7eb;
    }
    
    .blog-content table td {
        padding: 0.75rem;
        border: 1px solid #e5e7eb;
    }
    
    .blog-content table tr:nth-child(even) {
        background: #f9fafb;
    }
</style>
<div class="min-h-screen bg-gray-50 pt-20">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            
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
                    </div>

                    <!-- Title -->
                    <h1 class="text-3xl font-bold text-gray-900 mb-6">{{ $blog->title }}</h1>

                    <!-- Excerpt -->
                    @if($blog->excerpt)
                    <div class="text-lg text-gray-600 mb-8">{{ $blog->excerpt }}</div>
                    @endif

                    <!-- Stats -->
                    <div class="flex items-center gap-6 mb-8 p-4 bg-gray-50 rounded-lg text-sm">
                        <div class="flex items-center gap-2 text-gray-600">
                            <i class="fas fa-eye"></i>
                            <span>{{ number_format($blog->views_count ?? 0) }} views</span>
                        </div>
                    </div>

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
            <section class="bg-white rounded-lg shadow-lg p-8">
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
