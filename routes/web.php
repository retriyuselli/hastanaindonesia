<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogEngagementController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\JoinController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Gallery routes
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::get('/gallery/{id}', [GalleryController::class, 'show'])->name('gallery.show');

// Join/Registration routes (requires authentication)
Route::middleware('auth')->group(function () {
    Route::get('/bergabung', [JoinController::class, 'index'])->name('join');
    Route::post('/bergabung', [JoinController::class, 'store'])->name('join.store');
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

Route::get('/anggota', function () {
    return view('front.members');
})->name('members');

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
    $blogs = \App\Models\Blog::with('category')
                            ->where('status', 'published')
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);
    
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
    // Get blog from database
    $blog = \App\Models\Blog::where('slug', $slug)
                           ->with('category')
                           ->first();
    
    if (!$blog) {
        abort(404);
    }
    
    return view('blog.detail', compact('blog'));
})->name('blog.detail');

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

Route::get('/about', function () {
    return view('front.about');
})->name('about');

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
