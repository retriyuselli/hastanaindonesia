<?php

use App\Http\Controllers\AdminFileController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogEngagementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Front\AboutController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IuranController;
use App\Http\Controllers\JoinController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PrivateFileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegionProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Gallery routes
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::get('/gallery/{id}', [GalleryController::class, 'show'])->name('gallery.show');

// Join/Registration routes (requires authentication)
Route::middleware('auth')->group(function () {
    Route::get('/bergabung', [JoinController::class, 'index'])->name('join');
    Route::post('/bergabung', [JoinController::class, 'store'])->name('join.store');

    // Product Management routes - fallback redirect
    Route::get('/products', [ProductController::class, 'redirectToManage']);

    // Product Management routes with slug
    Route::get('/{slug}/products', [ProductController::class, 'index'])->name('products.manage');
    Route::get('/{slug}/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/{slug}/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/{slug}/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/{slug}/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/{slug}/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
});

Route::view('/syarat-ketentuan', 'terms')->name('terms');
Route::view('/kebijakan-privasi', 'privacy')->name('privacy');
Route::view('/kebijakan-cookie', 'cookies')->name('cookies');
Route::view('/portfolio', 'front.portfolio.index')->name('portfolio');
Route::view('/portfolio/detail/{id?}', 'front.portfolio.detail')->name('portfolio.detail');

// Members/Anggota routes
Route::get('/anggota', [MemberController::class, 'index'])->name('members');
Route::get('/anggota/{slug}', [MemberController::class, 'show'])->name('members.show');
Route::post('/anggota/{slug}/gallery', [MemberController::class, 'storeGallery'])
    ->middleware('auth')
    ->name('members.gallery.store');
Route::get('/anggota/{slug}/product/{productId}', [MemberController::class, 'showProduct'])->name('members.product');

Route::get('/profile-region', [RegionProfileController::class, 'index'])->name('regions.index');
Route::get('/profile-region/{region}', [RegionProfileController::class, 'show'])->name('regions.show');

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

    // Event Review Routes
    Route::post('/events/{slug}/review', [EventController::class, 'storeReview'])->name('events.review.store');

    // E-Ticket Routes
    Route::get('/my-tickets/{registrationCode}', [EventController::class, 'showTicket'])->name('tickets.show');
    Route::get('/my-tickets/{registrationCode}/download', [EventController::class, 'downloadTicket'])->name('tickets.download');

    // Cancel Registration
    Route::delete('/my-registrations/{registrationCode}/cancel', [EventController::class, 'cancelRegistration'])->name('registrations.cancel');
});

Route::middleware('auth')->prefix('admin/files')->group(function () {
    Route::get('wedding-organizers/{weddingOrganizer}/legal/{index}', [AdminFileController::class, 'downloadWeddingOrganizerLegalDocument'])
        ->whereNumber('index')
        ->name('admin.files.wedding-organizers.legal');

    Route::get('event-participants/{eventParticipant}/payment-proof', [AdminFileController::class, 'downloadEventParticipantPaymentProof'])
        ->name('admin.files.event-participants.payment-proof');

    Route::get('event-participants/{eventParticipant}/invoice', [AdminFileController::class, 'eventParticipantInvoice'])
        ->name('admin.files.event-participants.invoice');

    Route::get('event-participants/recap', [AdminFileController::class, 'eventParticipantRecap'])
        ->name('admin.files.event-participants.recap');

    Route::get('event-participants/recap-excel', [AdminFileController::class, 'eventParticipantRecapExcel'])
        ->name('admin.files.event-participants.recap-excel');
});

Route::middleware('auth')->prefix('files')->group(function () {
    Route::get('event-participants/{eventParticipant}/payment-proof', [PrivateFileController::class, 'showEventParticipantPaymentProof'])
        ->name('files.event-participants.payment-proof');
});

if (app()->environment(['local', 'testing'])) {
    require __DIR__.'/local.php';
}

Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.detail');

// Blog Comment Route (requires authentication)
Route::middleware(['auth'])->group(function () {
    Route::post('/blog/{slug}/comment', [BlogEngagementController::class, 'storeCommentWeb'])
        ->middleware('throttle:5,1')
        ->name('blog.comment.store');

    // Comment Actions API Routes
    Route::prefix('api/comments')->middleware('throttle:20,1')->group(function () {
        Route::post('/{id}/like', [BlogEngagementController::class, 'likeComment'])->name('api.comment.like');
        Route::delete('/{id}', [BlogEngagementController::class, 'deleteComment'])->name('api.comment.delete');
        Route::post('/{id}/report', [BlogEngagementController::class, 'reportComment'])->name('api.comment.report');
    });
});

// Blog Engagement AJAX Routes
Route::prefix('api/blog')->group(function () {
    Route::post('{blogId}/like', [BlogEngagementController::class, 'toggleLike'])
        ->middleware('throttle:20,1')
        ->name('blog.toggle-like');
    Route::get('{blogId}/check-like', [BlogEngagementController::class, 'checkLike'])
        ->middleware('throttle:60,1')
        ->name('blog.check-like');
});

Route::view('/contact', 'front.contact.index')->name('contact');

Route::get('/about', [AboutController::class, 'index'])->name('about');

Route::get('/dpp', [PageController::class, 'dpp'])->name('dpp');

// Layanan
Route::view('/layanan/sertifikasi-wo', 'layanan.sertifikasi-wo')->name('layanan.sertifikasi');
Route::view('/layanan/pelatihan-profesional', 'layanan.pelatihan-profesional')->name('layanan.pelatihan');
Route::view('/layanan/networking-event', 'layanan.networking-event')->name('layanan.networking');
Route::view('/layanan/konsultasi-bisnis', 'layanan.konsultasi-bisnis')->name('layanan.konsultasi');
Route::view('/layanan/directory-wo', 'layanan.directory-wo')->name('layanan.directory');
Route::view('/layanan/quality-assurance', 'layanan.quality-assurance')->name('layanan.quality');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->prefix('iuran')->name('iuran.')->group(function () {
    Route::post('/{iuran}/bayar', [IuranController::class, 'bayar'])->name('bayar');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
