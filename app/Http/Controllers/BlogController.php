<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $query = Blog::with('category', 'author')
            ->withCount([
                'comments' => fn ($query) => $query->where('is_approved', true),
                'likes',
            ])
            ->where('status', 'published');

        if ($request->filled('search')) {
            $searchTerm = $request->string('search')->toString();

            $query->where(function ($query) use ($searchTerm) {
                $query->where('title', 'like', '%'.$searchTerm.'%')
                    ->orWhere('content', 'like', '%'.$searchTerm.'%')
                    ->orWhere('excerpt', 'like', '%'.$searchTerm.'%')
                    ->orWhereHas('category', fn ($categoryQuery) => $categoryQuery
                        ->where('name', 'like', '%'.$searchTerm.'%'));
            });
        }

        $blogs = $query->latest()->paginate(10)->withQueryString();

        $categories = BlogCategory::withCount([
            'blogs' => fn ($query) => $query->where('status', 'published'),
        ])->get();

        return view('blog.index', compact('blogs', 'categories'));
    }

    public function show(Request $request, string $slug): View
    {
        $blog = Blog::where('slug', $slug)
            ->where('status', 'published')
            ->withCount([
                'comments' => fn ($query) => $query->where('is_approved', true),
                'likes',
            ])
            ->with([
                'category',
                'author',
                'comments' => fn ($query) => $query
                    ->where('is_approved', true)
                    ->latest(),
            ])
            ->firstOrFail();

        $blog->incrementViews(
            $request->ip(),
            $request->userAgent(),
            $request->headers->get('referer'),
        );

        $blog->refresh()
            ->loadCount([
                'comments' => fn ($query) => $query->where('is_approved', true),
                'likes',
            ])
            ->load([
                'category',
                'author',
                'comments' => fn ($query) => $query
                    ->where('is_approved', true)
                    ->latest(),
            ]);

        $comments = $blog->comments
            ->whereNull('parent_id')
            ->values();
        $popularBlogs = Blog::query()
            ->where('status', 'published')
            ->where('id', '!=', $blog->id)
            ->orderByDesc('views_count')
            ->limit(5)
            ->get();
        $categories = BlogCategory::withCount([
            'blogs' => fn ($query) => $query->where('status', 'published'),
        ])
            ->whereHas('blogs', fn ($query) => $query->where('status', 'published'))
            ->orderByDesc('blogs_count')
            ->limit(8)
            ->get();

        return view('blog.detail', compact('blog', 'comments', 'popularBlogs', 'categories'));
    }
}
