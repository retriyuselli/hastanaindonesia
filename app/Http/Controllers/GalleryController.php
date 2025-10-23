<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        // Get published galleries
        $galleries = Gallery::published()
            ->orderBy('date', 'desc')
            ->get()
            ->map(function ($gallery) {
                return [
                    'id' => $gallery->id,
                    'title' => $gallery->title,
                    'description' => $gallery->description,
                    'image' => $gallery->image_url,
                    'category' => $gallery->category,
                    'date' => $gallery->date?->format('Y-m-d'),
                    'location' => $gallery->location,
                    'photographer' => $gallery->photographer ?? 'HASTANA Photography Team',
                ];
            });

        // Get categories with counts
        $categories = Gallery::published()
            ->select('category', \DB::raw('count(*) as count'))
            ->groupBy('category')
            ->pluck('count', 'category')
            ->toArray();
        
        $categories = array_merge(['Semua' => $galleries->count()], $categories);

        return view('front.gallery', compact('galleries', 'categories'));
    }

    public function show($slug)
    {
        $gallery = Gallery::published()
            ->where('slug', $slug)
            ->firstOrFail();
        
        // Increment views
        $gallery->incrementViews();
        
        // Get related galleries (same category)
        $relatedGalleries = Gallery::published()
            ->where('category', $gallery->category)
            ->where('id', '!=', $gallery->id)
            ->limit(4)
            ->get();

        return view('front.gallery-detail', compact('gallery', 'relatedGalleries'));
    }
}
