<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Blog;
use App\Models\BlogLike;
use Illuminate\Support\Facades\DB;

class RecalculateBlogLikes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:recalculate-likes {--blog_id= : Specific blog ID to recalculate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate likes_count for all blogs based on unique IPs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Starting likes count recalculation...');
        
        $blogId = $this->option('blog_id');
        
        if ($blogId) {
            // Recalculate for specific blog
            $blog = Blog::find($blogId);
            if (!$blog) {
                $this->error("Blog with ID {$blogId} not found!");
                return 1;
            }
            $this->recalculateBlog($blog);
        } else {
            // Recalculate for all blogs
            $blogs = Blog::all();
            $progressBar = $this->output->createProgressBar($blogs->count());
            $progressBar->start();
            
            foreach ($blogs as $blog) {
                $this->recalculateBlog($blog);
                $progressBar->advance();
            }
            
            $progressBar->finish();
            $this->newLine();
        }
        
        $this->info('✅ Likes count recalculation completed!');
        return 0;
    }
    
    /**
     * Recalculate likes for a single blog
     */
    protected function recalculateBlog(Blog $blog)
    {
        // Get unique IP count (each IP counted once)
        $uniqueLikesCount = BlogLike::where('blog_id', $blog->id)
            ->distinct('ip_address')
            ->count('ip_address');
        
        $oldCount = $blog->likes_count;
        $blog->likes_count = $uniqueLikesCount;
        $blog->save();
        
        if ($this->option('verbose')) {
            $this->line("Blog #{$blog->id}: {$oldCount} → {$uniqueLikesCount} likes");
        }
    }
}
