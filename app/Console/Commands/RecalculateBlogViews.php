<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Blog;
use App\Models\BlogView;
use Illuminate\Support\Facades\DB;

class RecalculateBlogViews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:recalculate-views {--blog_id= : Specific blog ID to recalculate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate views_count for all blogs based on unique IPs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Starting views count recalculation...');
        
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
        
        $this->info('✅ Views count recalculation completed!');
        return 0;
    }
    
    /**
     * Recalculate views for a single blog
     */
    protected function recalculateBlog(Blog $blog)
    {
        // Get unique IP count (each IP counted once, using latest view)
        $uniqueViewsCount = BlogView::where('blog_id', $blog->id)
            ->select('ip_address', DB::raw('MAX(viewed_at) as latest_view'))
            ->groupBy('ip_address')
            ->get()
            ->count();
        
        $oldCount = $blog->views_count;
        $blog->views_count = $uniqueViewsCount;
        $blog->save();
        
        if ($this->option('verbose')) {
            $this->line("Blog #{$blog->id}: {$oldCount} → {$uniqueViewsCount} views");
        }
    }
}
