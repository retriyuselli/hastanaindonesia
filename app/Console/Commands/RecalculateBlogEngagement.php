<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RecalculateBlogEngagement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:recalculate-engagement {--blog_id= : Specific blog ID to recalculate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate all engagement metrics (views, likes, comments) for blogs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Starting blog engagement recalculation...');
        $this->newLine();
        
        $blogId = $this->option('blog_id');
        $options = $blogId ? ['--blog_id' => $blogId] : [];
        
        // Recalculate Views
        $this->info('📊 Recalculating views...');
        $this->call('blog:recalculate-views', $options);
        $this->newLine();
        
        // Recalculate Likes
        $this->info('❤️  Recalculating likes...');
        $this->call('blog:recalculate-likes', $options);
        $this->newLine();
        
        $this->info('✅ All engagement metrics recalculated successfully!');
        return 0;
    }
}
