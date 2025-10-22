<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogComment;
use App\Models\BlogLike;
use App\Models\BlogView;
use Illuminate\Support\Facades\Log;

class BlogEngagementController extends Controller
{
    /**
     * Toggle like for a blog
     */
    public function toggleLike(Request $request, $blogId)
    {
        $blog = Blog::findOrFail($blogId);
        
        // Enhanced debugging
        Log::info('Like toggle request received', [
            'blog_id' => $blog->id,
            'blog_title' => $blog->title,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);
        
        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();
        
        $result = $blog->toggleLike($ipAddress, $userAgent);
        
        Log::info('Like toggle result', [
            'blog_id' => $blog->id,
            'action' => $result['action'],
            'count' => $result['count']
        ]);
        
        return response()->json([
            'success' => true,
            'action' => $result['action'],
            'likes_count' => $result['count'],
            'is_liked' => $result['action'] === 'liked'
        ]);
    }

    /**
     * Record a view for a blog
     */
    public function recordView(Request $request, $blogId)
    {
        $blog = Blog::findOrFail($blogId);
        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();
        $referrer = $request->header('referer');
        
        $blog->incrementViews($ipAddress, $userAgent, $referrer);
        
        return response()->json([
            'success' => true,
            'views_count' => $blog->fresh()->views_count
        ]);
    }

    /**
     * Store a new comment
     */
    public function storeComment(Request $request, $blogId)
    {
        $blog = Blog::findOrFail($blogId);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'comment' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:blog_comments,id'
        ]);

        $comment = $blog->comments()->create([
            'name' => $request->name,
            'email' => $request->email,
            'comment' => $request->comment,
            'parent_id' => $request->parent_id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'is_approved' => true // Auto-approve for now, can be changed later
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil ditambahkan!',
            'comment' => [
                'id' => $comment->id,
                'name' => $comment->name,
                'comment' => $comment->comment,
                'avatar_url' => $comment->avatar_url,
                'formatted_date' => $comment->formatted_date,
                'parent_id' => $comment->parent_id
            ],
            'comments_count' => $blog->fresh()->comments_count
        ]);
    }

    /**
     * Get comments for a blog
     */
    public function getComments($blogId)
    {
        $blog = Blog::findOrFail($blogId);
        
        $comments = $blog->topLevelComments()
                        ->with(['replies' => function($query) {
                            $query->orderBy('created_at', 'asc');
                        }])
                        ->get();

        return response()->json([
            'success' => true,
            'comments' => $comments->map(function($comment) {
                return [
                    'id' => $comment->id,
                    'name' => $comment->name,
                    'comment' => $comment->comment,
                    'avatar_url' => $comment->avatar_url,
                    'formatted_date' => $comment->formatted_date,
                    'replies' => $comment->replies->map(function($reply) {
                        return [
                            'id' => $reply->id,
                            'name' => $reply->name,
                            'comment' => $reply->comment,
                            'avatar_url' => $reply->avatar_url,
                            'formatted_date' => $reply->formatted_date,
                        ];
                    })
                ];
            })
        ]);
    }

    /**
     * Update reading duration
     */
    public function updateDuration(Request $request, $blogId)
    {
        $blog = Blog::findOrFail($blogId);
        
        $request->validate([
            'duration' => 'required|integer|min:1'
        ]);

        $ipAddress = $request->ip();
        
        // Find the most recent view from this IP
        $view = BlogView::where('blog_id', $blog->id)
                       ->where('ip_address', $ipAddress)
                       ->latest()
                       ->first();

        if ($view) {
            $view->updateDuration($request->duration);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Get blog engagement stats
     */
    public function getStats($blogId)
    {
        $blog = Blog::findOrFail($blogId);
        
        $stats = $blog->getEngagementStats();
        
        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }
}
