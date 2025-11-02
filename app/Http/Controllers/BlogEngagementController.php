<?php


namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BlogEngagementController extends Controller
{
    /**
     * Store a new comment (Web version)
     */
    public function storeCommentWeb(Request $request, $slug)
    {
        try {
            // Validate input
            $validated = $request->validate([
                'comment' => 'required|string|min:3|max:1000',
                'parent_id' => 'nullable|exists:blog_comments,id',
            ], [
                'comment.required' => 'Komentar tidak boleh kosong.',
                'comment.min' => 'Komentar minimal 3 karakter.',
                'comment.max' => 'Komentar maksimal 1000 karakter.',
            ]);

            // Get authenticated user
            $user = auth()->user();
            if (!$user) {
                return redirect()
                    ->back()
                    ->with('error', 'Anda harus login terlebih dahulu untuk mengirim komentar.');
            }

            // Find blog
            $blog = Blog::where('slug', $slug)->firstOrFail();

            // Check for duplicate comments (same user, same blog, similar content in last 5 minutes)
            $recentDuplicate = BlogComment::where('email', $user->email)
                ->where('blog_id', $blog->id)
                ->where('comment', $validated['comment'])
                ->where('created_at', '>=', now()->subMinutes(5))
                ->exists();

            if ($recentDuplicate) {
                return redirect()
                    ->back()
                    ->with('error', 'Anda baru saja mengirim komentar yang sama. Mohon tunggu beberapa saat.');
            }

            // Rate limiting: max 3 comments per user per blog per day
            $todayCommentsCount = BlogComment::where('email', $user->email)
                ->where('blog_id', $blog->id)
                ->whereDate('created_at', today())
                ->count();

            if ($todayCommentsCount >= 3) {
                return redirect()
                    ->back()
                    ->with('error', 'Anda telah mencapai batas maksimal komentar untuk artikel ini hari ini (3 komentar).');
            }

            // Create comment
            $comment = BlogComment::create([
                'blog_id' => $blog->id,
                'name' => $user->name,
                'email' => $user->email,
                'comment' => $validated['comment'],
                'parent_id' => $validated['parent_id'] ?? null,
                'is_approved' => false,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Auto-approve for trusted users (users with 3+ approved comments)
            $approvedCommentsCount = BlogComment::where('email', $user->email)
                ->where('is_approved', true)
                ->count();

            if ($approvedCommentsCount >= 3) {
                $comment->update(['is_approved' => true]);
                $message = 'Komentar Anda berhasil dipublikasikan!';
            } else {
                $message = 'Komentar Anda berhasil dikirim dan sedang menunggu persetujuan admin.';
            }

            return redirect()
                ->back()
                ->with('success', $message);

        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error storing comment', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'slug' => $slug,
                'user' => auth()->user()?->email,
            ]);

            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan komentar. Silakan coba lagi.');
        }
    }

    /**
     * Like a comment
     */
    public function likeComment(Request $request, $id)
    {
        try {
            $comment = BlogComment::findOrFail($id);
            
            // Session-based like tracking
            $likedComments = session('liked_comments', []);
            
            if (in_array($id, $likedComments)) {
                // Unlike
                $likedComments = array_diff($likedComments, [$id]);
                session(['liked_comments' => $likedComments]);
                $liked = false;
            } else {
                // Like
                $likedComments[] = $id;
                session(['liked_comments' => $likedComments]);
                $liked = true;
            }

            return response()->json([
                'success' => true,
                'liked' => $liked,
                'count' => count(session('liked_comments', [])),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan.',
            ], 500);
        }
    }

    /**
     * Delete a comment
     */
    public function deleteComment(Request $request, $id)
    {
        try {
            $comment = BlogComment::findOrFail($id);
            $user = auth()->user();

            // Check ownership
            if ($comment->email !== $user->email) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki izin untuk menghapus komentar ini.',
                ], 403);
            }

            $comment->delete();

            return response()->json([
                'success' => true,
                'message' => 'Komentar berhasil dihapus.',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus komentar.',
            ], 500);
        }
    }

    /**
     * Report a comment
     */
    public function reportComment(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'reason' => 'required|string|max:255',
            ]);

            $comment = BlogComment::findOrFail($id);

            Log::warning('Comment reported', [
                'comment_id' => $id,
                'reason' => $validated['reason'],
                'reported_by' => auth()->user()?->email,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Laporan Anda telah dikirim. Terima kasih.',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengirim laporan.',
            ], 500);
        }
    }

    /**
     * Toggle like for a blog
     */
    public function toggleLike($blogId)
    {
        try {
            // Find blog by ID or slug
            $blog = Blog::where('id', $blogId)
                       ->orWhere('slug', $blogId)
                       ->firstOrFail();
            
            $ipAddress = request()->ip();
            
            // Toggle like
            $result = $blog->toggleLike($ipAddress, request()->userAgent());
            
            // Refresh to get updated counts
            $blog->refresh();
            
            return response()->json([
                'success' => true,
                'liked' => $result['liked'],
                'likes_count' => $blog->likes_count ?? 0,
                'message' => $result['liked'] ? 'Blog disukai!' : 'Like dibatalkan.',
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error toggling blog like', [
                'error' => $e->getMessage(),
                'blog_id' => $blogId,
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses like.',
            ], 500);
        }
    }

    /**
     * Check if user has liked a blog
     */
    public function checkLike($blogId)
    {
        try {
            // Find blog by ID or slug
            $blog = Blog::where('id', $blogId)
                       ->orWhere('slug', $blogId)
                       ->firstOrFail();
            
            $ipAddress = request()->ip();
            $liked = $blog->isLikedBy($ipAddress);
            
            return response()->json([
                'success' => true,
                'liked' => $liked,
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'liked' => false,
            ], 500);
        }
    }
}
