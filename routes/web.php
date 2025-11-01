<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogEngagementController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\JoinController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Gallery routes
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::get('/gallery/{id}', [GalleryController::class, 'show'])->name('gallery.show');

// Join/Registration routes (requires authentication)
Route::middleware('auth')->group(function () {
    Route::get('/bergabung', [JoinController::class, 'index'])->name('join');
    Route::post('/bergabung', [JoinController::class, 'store'])->name('join.store');
    
    // Product Management routes - fallback redirect
    Route::get('/products', function() {
        $weddingOrganizer = \App\Models\WeddingOrganizer::where('user_id', auth()->id())->first();
        if (!$weddingOrganizer) {
            return redirect()->route('join')->with('error', 'Anda belum memiliki Wedding Organizer. Silakan daftar terlebih dahulu.');
        }
        return redirect()->route('products.manage', $weddingOrganizer->slug);
    });
    
    // Product Management routes with slug
    Route::get('/{slug}/products', [ProductController::class, 'index'])->name('products.manage');
    Route::get('/{slug}/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/{slug}/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/{slug}/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/{slug}/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/{slug}/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
});

Route::get('/syarat-ketentuan', function () {
    return view('terms');
})->name('terms');

Route::get('/kebijakan-privasi', function () {
    return view('privacy');
})->name('privacy');

Route::get('/portfolio', function () {
    return view('front.portfolio');
})->name('portfolio');

Route::get('/portfolio/detail/{id?}', function ($id = 1) {
    return view('front.portfolio-detail');
})->name('portfolio.detail');

// Members/Anggota routes
Route::get('/anggota', [MemberController::class, 'index'])->name('members');
Route::get('/anggota/{slug}', [MemberController::class, 'show'])->name('members.show');
Route::get('/anggota/{slug}/product/{productId}', [MemberController::class, 'showProduct'])->name('members.product');

// Debug route - hapus setelah selesai debug
Route::get('/debug-product/{id}', function($id) {
    $product = \App\Models\Product::findOrFail($id);
    return response()->json([
        'id' => $product->id,
        'name' => $product->name,
        'images_raw' => $product->images,
        'images_type' => gettype($product->images),
        'images_count' => is_array($product->images) ? count($product->images) : 0,
        'images_with_storage_url' => is_array($product->images) ? array_map(fn($img) => Storage::url($img), $product->images) : [],
    ]);
});

// Events routes
Route::get('/events', [EventController::class, 'index'])->name('events');
Route::get('/events/free', [EventController::class, 'free'])->name('events.free');
Route::get('/events/featured', [EventController::class, 'featured'])->name('events.featured');
Route::get('/events/trending', [EventController::class, 'trending'])->name('events.trending');
Route::get('/events/category/{categorySlug}', [EventController::class, 'category'])->name('events.category');
Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show');

// Event Registration - Requires Authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/events/{slug}/register', [EventController::class, 'register'])->name('events.register');
    Route::post('/events/{slug}/register', [EventController::class, 'storeRegistration'])->name('events.register.store');
    
    // E-Ticket Routes
    Route::get('/my-tickets/{registrationCode}', [EventController::class, 'showTicket'])->name('tickets.show');
    Route::get('/my-tickets/{registrationCode}/download', [EventController::class, 'downloadTicket'])->name('tickets.download');
});



Route::get('/blog', function () {
    $query = \App\Models\Blog::with('category', 'author')
                            ->withCount([
                                'comments' => function($query) {
                                    $query->where('is_approved', true);
                                },
                                'likes',
                                'views'
                            ])
                            ->where('status', 'published');
    
    // Handle search query
    if (request()->has('search') && request('search') != '') {
        $searchTerm = request('search');
        $query->where(function($q) use ($searchTerm) {
            $q->where('title', 'like', '%' . $searchTerm . '%')
              ->orWhere('content', 'like', '%' . $searchTerm . '%')
              ->orWhere('excerpt', 'like', '%' . $searchTerm . '%')
              ->orWhereHas('category', function($categoryQuery) use ($searchTerm) {
                  $categoryQuery->where('name', 'like', '%' . $searchTerm . '%');
              });
        });
    }
    
    $blogs = $query->orderBy('created_at', 'desc')->paginate(10);
    
    $categories = \App\Models\BlogCategory::withCount(['blogs' => function($query) {
        $query->where('status', 'published');
    }])->get();
    
    return view('blog.index', compact('blogs', 'categories'));
})->name('blog');

Route::get('/blog/debug', function () {
    return view('blog.debug');
})->name('blog.debug');

Route::get('/debug-views', function () {
    return view('debug-views');
})->name('debug.views');

Route::get('/blog/{slug}', function ($slug) {
    // Get blog from database with comments
    $blog = \App\Models\Blog::where('slug', $slug)
                           ->withCount([
                               'comments' => function($query) {
                                   $query->where('is_approved', true);
                               },
                               'likes',
                               'views'
                           ])
                           ->with(['category', 'author', 'comments' => function($query) {
                               $query->where('is_approved', true)
                                     ->orderBy('created_at', 'desc');
                           }])
                           ->first();
    
    if (!$blog) {
        abort(404);
    }
    
    // Increment views count
    $blog->incrementViews(
        request()->ip(),
        request()->userAgent(),
        request()->headers->get('referer')
    );
    
    // Refresh to get updated views_count
    $blog->refresh();
    
    return view('blog.detail', compact('blog'));
})->name('blog.detail');

// Blog Comment Route (requires authentication)
Route::middleware(['auth'])->group(function () {
    Route::post('/blog/{slug}/comment', [BlogEngagementController::class, 'storeCommentWeb'])->name('blog.comment.store');
    
    // Comment Actions API Routes
    Route::prefix('api/comments')->group(function () {
        Route::post('/{id}/like', [BlogEngagementController::class, 'likeComment'])->name('api.comment.like');
        Route::delete('/{id}', [BlogEngagementController::class, 'deleteComment'])->name('api.comment.delete');
        Route::post('/{id}/report', [BlogEngagementController::class, 'reportComment'])->name('api.comment.report');
    });
});

// Blog Engagement AJAX Routes
Route::prefix('api/blog')->group(function () {
    // Debug route to test blog finding
    Route::get('debug/{blogId}', function($blogId) {
        try {
            $blog = \App\Models\Blog::findOrFail($blogId);
            return response()->json([
                'success' => true,
                'blog_found' => true,
                'blog_id' => $blog->id,
                'blog_title' => $blog->title,
                'message' => 'Blog found successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'blog_found' => false,
                'error' => $e->getMessage(),
                'blogId_searched' => $blogId
            ], 404);
        }
    });
    
    Route::post('{blogId}/like', [BlogEngagementController::class, 'toggleLike'])->name('blog.toggle-like');
    Route::post('{blogId}/view', [BlogEngagementController::class, 'recordView'])->name('blog.record-view');
    Route::post('{blogId}/comment', [BlogEngagementController::class, 'storeComment'])->name('blog.store-comment');
    Route::get('{blogId}/comments', [BlogEngagementController::class, 'getComments'])->name('blog.get-comments');
    Route::patch('{blogId}/duration', [BlogEngagementController::class, 'updateDuration'])->name('blog.update-duration');
    Route::get('{blogId}/stats', [BlogEngagementController::class, 'getStats'])->name('blog.get-stats');
    Route::get('{blog}', function($blogId) {
        $blog = \App\Models\Blog::findOrFail($blogId);
        return response()->json([
            'id' => $blog->id,
            'title' => $blog->title,
            'views_count' => $blog->views_count
        ]);
    });
    Route::get('{blog}/view-pixel', function($blogId) {
        try {
            $blog = \App\Models\Blog::findOrFail($blogId);
            $blog->incrementViews(request()->ip(), 'Fallback Pixel Tracking');
            
            // Return 1x1 transparent pixel
            return response(base64_decode('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7'))
                ->header('Content-Type', 'image/gif')
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        } catch (\Exception $e) {
            return response('', 404);
        }
    });
});

Route::get('/contact', function () {
    return view('front.contact');
})->name('contact');

Route::get('/about', [App\Http\Controllers\Front\AboutController::class, 'index'])->name('about');

Route::get('/header-demo', function () {
    return view('layouts.header');
});

Route::get('/demo-home', function () {
    return view('demo-home');
})->name('demo.home');

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
