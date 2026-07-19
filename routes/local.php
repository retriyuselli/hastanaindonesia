<?php

use App\Models\Blog;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/debug-product/{id}', function (int $id) {
    $product = Product::findOrFail($id);

    return response()->json([
        'id' => $product->id,
        'name' => $product->name,
        'images_raw' => $product->images,
        'images_type' => gettype($product->images),
        'images_count' => is_array($product->images) ? count($product->images) : 0,
        'images_with_storage_url' => is_array($product->images)
            ? array_map(fn ($image) => Storage::url($image), $product->images)
            : [],
    ]);
});

Route::prefix('api/blog')->group(function () {
    Route::get('debug/{blogId}', function (int $blogId) {
        $blog = Blog::findOrFail($blogId);

        return response()->json([
            'success' => true,
            'blog_found' => true,
            'blog_id' => $blog->id,
            'blog_title' => $blog->title,
            'message' => 'Blog found successfully',
        ]);
    });
});
