<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (app()->environment('production') && ! ($this->command?->option('force') ?? false)) {
            $this->command?->warn('DatabaseSeeder dibatalkan di production. Jalankan dengan --force jika benar-benar dibutuhkan.');

            return;
        }

        $this->call([
            RoleSeeder::class,
            AdminUserSeeder::class,
            RegionSeeder::class,
            CompanySeeder::class,
            AboutPageSeeder::class,
            EventCategorySeeder::class,
            EventHastanaSeeder::class,
            EventParticipantSeeder::class,
            AuthorSeeder::class,
            WeddingOrganizerSeeder::class,
            BlogCategorySeeder::class,
            BlogSeeder::class,
            ProductSeeder::class,
            GallerySeeder::class,
            EventReviewSeeder::class,
        ]);
    }
}
