<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Seeder;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (app()->environment('production') && ! ($this->command?->option('force') ?? false)) {
            $this->command?->warn('BlogCategorySeeder dilewati di production. Jalankan dengan --force jika benar-benar dibutuhkan.');

            return;
        }

        $categories = [
            [
                'name' => 'Tips & Tutorial',
                'slug' => 'tips-tutorial',
                'description' => 'Tips praktis dan tutorial untuk wedding organizer',
                'color' => '#3B82F6',
                'icon' => 'lightbulb',
                'sort_order' => 1,
            ],
            [
                'name' => 'Tren Pernikahan',
                'slug' => 'tren-pernikahan',
                'description' => 'Tren terbaru dalam industri pernikahan dan wedding organizer',
                'color' => '#EF4444',
                'icon' => 'chart-line',
                'sort_order' => 2,
            ],
            [
                'name' => 'Teknologi & Aplikasi',
                'slug' => 'teknologi-aplikasi',
                'description' => 'Teknologi dan aplikasi untuk meningkatkan efisiensi wedding organizer',
                'color' => '#8B5CF6',
                'icon' => 'mobile-alt',
                'sort_order' => 3,
            ],
            [
                'name' => 'Bisnis & Marketing',
                'slug' => 'bisnis-marketing',
                'description' => 'Strategi bisnis dan marketing untuk wedding organizer',
                'color' => '#10B981',
                'icon' => 'chart-bar',
                'sort_order' => 4,
            ],
            [
                'name' => 'Inspirasi Dekorasi',
                'slug' => 'inspirasi-dekorasi',
                'description' => 'Inspirasi dan ide dekorasi pernikahan terkini',
                'color' => '#F59E0B',
                'icon' => 'palette',
                'sort_order' => 5,
            ],
            [
                'name' => 'Event Management',
                'slug' => 'event-management',
                'description' => 'Tips dan strategi manajemen event pernikahan',
                'color' => '#6366F1',
                'icon' => 'calendar-check',
                'sort_order' => 6,
            ],
            [
                'name' => 'Vendor & Partnership',
                'slug' => 'vendor-partnership',
                'description' => 'Tips membangun relasi dengan vendor dan partnership',
                'color' => '#EC4899',
                'icon' => 'handshake',
                'sort_order' => 7,
            ],
            [
                'name' => 'Budget & Finance',
                'slug' => 'budget-finance',
                'description' => 'Manajemen budget dan keuangan untuk wedding organizer',
                'color' => '#14B8A6',
                'icon' => 'dollar-sign',
                'sort_order' => 8,
            ],
        ];

        foreach ($categories as $category) {
            BlogCategory::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
