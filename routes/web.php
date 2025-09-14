<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/bergabung', function () {
    return view('join');
})->name('join');

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

Route::get('/events', function () {
    return view('front.events');
})->name('events');

Route::get('/blog', function () {
    return view('blog.index');
})->name('blog');

Route::get('/blog/{slug}', function ($slug) {
    return view('blog.detail', compact('slug'));
})->name('blog.detail');

Route::get('/contact', function () {
    return view('front.contact');
})->name('contact');

Route::get('/header-demo', function () {
    return view('layouts.header');
});

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
