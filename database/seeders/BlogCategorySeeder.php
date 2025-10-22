<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BlogCategory;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Tips & Tutorial',
                'slug' => 'tips-tutorial',
                'description' => 'Tips praktis dan tutorial untuk wedding organizer',
                'color' => '#3B82F6',
                'icon' => 'fas fa-lightbulb',
                'sort_order' => 1
            ],
            [
                'name' => 'Tren Pernikahan',
                'slug' => 'tren-pernikahan',
                'description' => 'Tren terbaru dalam industri pernikahan dan wedding organizer',
                'color' => '#EF4444',
                'icon' => 'fas fa-chart-line',
                'sort_order' => 2
            ],
            [
                'name' => 'Teknologi & Aplikasi',
                'slug' => 'teknologi-aplikasi',
                'description' => 'Teknologi dan aplikasi untuk meningkatkan efisiensi wedding organizer',
                'color' => '#8B5CF6',
                'icon' => 'fas fa-mobile-alt',
                'sort_order' => 3
            ],
            [
                'name' => 'Bisnis & Marketing',
                'slug' => 'bisnis-marketing',
                'description' => 'Strategi bisnis dan marketing untuk wedding organizer',
                'color' => '#10B981',
                'icon' => 'fas fa-chart-bar',
                'sort_order' => 4
            ],
            [
                'name' => 'Inspirasi Dekorasi',
                'slug' => 'inspirasi-dekorasi',
                'description' => 'Inspirasi dan ide dekorasi pernikahan terkini',
                'color' => '#F59E0B',
                'icon' => 'fas fa-palette',
                'sort_order' => 5
            ],
            [
                'name' => 'Event Management',
                'slug' => 'event-management',
                'description' => 'Tips dan strategi manajemen event pernikahan',
                'color' => '#6366F1',
                'icon' => 'fas fa-calendar-check',
                'sort_order' => 6
            ],
            [
                'name' => 'Vendor & Partnership',
                'slug' => 'vendor-partnership',
                'description' => 'Tips membangun relasi dengan vendor dan partnership',
                'color' => '#EC4899',
                'icon' => 'fas fa-handshake',
                'sort_order' => 7
            ],
            [
                'name' => 'Budget & Finance',
                'slug' => 'budget-finance',
                'description' => 'Manajemen budget dan keuangan untuk wedding organizer',
                'color' => '#14B8A6',
                'icon' => 'fas fa-dollar-sign',
                'sort_order' => 8
            ]
        ];

        foreach ($categories as $category) {
            BlogCategory::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
