<?php

namespace Database\Seeders;

use App\Models\EventCategory;
use Illuminate\Database\Seeder;

class EventCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (app()->environment('production') && ! ($this->command?->option('force') ?? false)) {
            $this->command?->warn('EventCategorySeeder dilewati di production. Jalankan dengan --force jika benar-benar dibutuhkan.');

            return;
        }

        $categories = [
            [
                'name' => 'Workshop & Pelatihan',
                'slug' => 'workshop-pelatihan',
                'description' => 'Workshop dan pelatihan untuk meningkatkan skill wedding organizer, mulai dari teknik dekorasi, manajemen event, hingga customer service excellence.',
                'icon' => 'graduation-cap',
                'color' => '#0EA5E9',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Seminar & Talkshow',
                'slug' => 'seminar-talkshow',
                'description' => 'Seminar inspiratif dan talkshow dengan para ahli industri pernikahan, sharing knowledge dan trend terbaru wedding industry.',
                'icon' => 'chart-line',
                'color' => '#10B981',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Wedding Expo',
                'slug' => 'wedding-expo',
                'description' => 'Pameran pernikahan terbesar dengan vendor-vendor terpilih, showcase portfolio, dan networking session untuk member HASTANA.',
                'icon' => 'store',
                'color' => '#F59E0B',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Networking Event',
                'slug' => 'networking-event',
                'description' => 'Acara networking eksklusif untuk member HASTANA, membangun koneksi bisnis dan kolaborasi antar wedding organizer.',
                'icon' => 'users',
                'color' => '#EC4899',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Sertifikasi HASTANA',
                'slug' => 'sertifikasi-hastana',
                'description' => 'Program sertifikasi resmi HASTANA untuk meningkatkan kredibilitas dan standar kompetensi wedding organizer profesional.',
                'icon' => 'trophy',
                'color' => '#7C3AED',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Kompetisi & Award',
                'slug' => 'kompetisi-award',
                'description' => 'Kompetisi kreativitas dan penghargaan untuk wedding organizer terbaik dalam berbagai kategori sesuai standar HASTANA.',
                'icon' => 'star',
                'color' => '#D97706',
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'Charity & CSR',
                'slug' => 'charity-csr',
                'description' => 'Program charity dan Corporate Social Responsibility untuk memberikan dampak positif kepada masyarakat melalui industri pernikahan.',
                'icon' => 'heart',
                'color' => '#DC2626',
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'Vendor Showcase',
                'slug' => 'vendor-showcase',
                'description' => 'Platform showcase untuk vendor dan supplier wedding industry, memperkenalkan produk dan layanan terbaru kepada wedding organizer.',
                'icon' => 'camera',
                'color' => '#8B5CF6',
                'is_active' => true,
                'sort_order' => 8,
            ],
            [
                'name' => 'Business Development',
                'slug' => 'business-development',
                'description' => 'Program pengembangan bisnis wedding organizer, meliputi strategi marketing, financial management, dan business scaling.',
                'icon' => 'briefcase',
                'color' => '#4F46E5',
                'is_active' => true,
                'sort_order' => 9,
            ],
            [
                'name' => 'Technology & Innovation',
                'slug' => 'technology-innovation',
                'description' => 'Workshop dan seminar tentang teknologi terbaru dalam industri pernikahan, dari virtual reality hingga wedding planning apps.',
                'icon' => 'lightbulb',
                'color' => '#059669',
                'is_active' => true,
                'sort_order' => 10,
            ],
            [
                'name' => 'Regional Meetup',
                'slug' => 'regional-meetup',
                'description' => 'Pertemuan regional member HASTANA di berbagai daerah untuk mempererat hubungan dan sharing pengalaman lokal.',
                'icon' => 'calendar-alt',
                'color' => '#14B8A6',
                'is_active' => true,
                'sort_order' => 11,
            ],
            [
                'name' => 'Special Launch',
                'slug' => 'special-launch',
                'description' => 'Event peluncuran program, produk, atau inisiatif baru dari HASTANA Indonesia yang melibatkan seluruh member.',
                'icon' => 'rocket',
                'color' => '#F97316',
                'is_active' => true,
                'sort_order' => 12,
            ],
        ];

        foreach ($categories as $category) {
            EventCategory::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }

        $this->command->info('EventCategory seeder completed! Created '.count($categories).' categories.');
    }
}
