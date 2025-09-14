<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Portfolio;
use App\Models\WeddingOrganizer;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada wedding organizer
        $weddingOrganizers = WeddingOrganizer::all();
        
        if ($weddingOrganizers->isEmpty()) {
            // Buat sample wedding organizers jika belum ada
            $weddingOrganizers = collect([
                WeddingOrganizer::create([
                    'name' => 'Elegant Wedding Organizer',
                    'email' => 'info@elegantwedding.com',
                    'phone' => '081234567890',
                    'region_id' => 1,
                    'status' => 'active'
                ]),
                WeddingOrganizer::create([
                    'name' => 'Bali Dream Wedding',
                    'email' => 'contact@balidreamwedding.com',
                    'phone' => '081234567891',
                    'region_id' => 1,
                    'status' => 'active'
                ]),
                WeddingOrganizer::create([
                    'name' => 'Jakarta Modern Wedding',
                    'email' => 'hello@jakartamodern.com',
                    'phone' => '081234567892',
                    'region_id' => 1,
                    'status' => 'active'
                ]),
                WeddingOrganizer::create([
                    'name' => 'Surabaya Traditional Wedding',
                    'email' => 'info@surabayatraditional.com',
                    'phone' => '081234567893',
                    'region_id' => 1,
                    'status' => 'active'
                ])
            ]);
        }

        $portfolios = [
            [
                'title' => 'Wedding Tradisional Jawa Elegant',
                'description' => 'Pernikahan tradisional Jawa dengan sentuhan modern yang memukau. Menggabungkan adat istiadat luhur Jawa dengan kemewahan kontemporer.',
                'images' => [
                    'portfolios/traditional-java-1.jpg',
                    'portfolios/traditional-java-2.jpg',
                    'portfolios/traditional-java-3.jpg'
                ],
                'featured' => true
            ],
            [
                'title' => 'Modern Garden Wedding Bali',
                'description' => 'Pernikahan outdoor di taman yang asri dengan dekorasi modern minimalis. Pemandangan alam Bali sebagai backdrop yang menawan.',
                'images' => [
                    'portfolios/garden-bali-1.jpg',
                    'portfolios/garden-bali-2.jpg',
                    'portfolios/garden-bali-3.jpg'
                ],
                'featured' => true
            ],
            [
                'title' => 'Intimate Beach Ceremony',
                'description' => 'Upacara pernikahan intim di tepi pantai dengan suasana romantis. Matahari terbenam sebagai saksi bisu momen bahagia.',
                'images' => [
                    'portfolios/beach-ceremony-1.jpg',
                    'portfolios/beach-ceremony-2.jpg'
                ],
                'featured' => true
            ],
            [
                'title' => 'Luxury Ballroom Reception',
                'description' => 'Resepsi mewah di ballroom dengan dekorasi glamour dan elegant. Setiap detail dirancang untuk menciptakan momen yang tak terlupakan.',
                'images' => [
                    'portfolios/luxury-ballroom-1.jpg',
                    'portfolios/luxury-ballroom-2.jpg',
                    'portfolios/luxury-ballroom-3.jpg',
                    'portfolios/luxury-ballroom-4.jpg'
                ],
                'featured' => true
            ],
            [
                'title' => 'Rustic Wedding Jakarta',
                'description' => 'Konsep pernikahan rustic dengan sentuhan vintage yang hangat dan nyaman.',
                'images' => [
                    'portfolios/rustic-jakarta-1.jpg',
                    'portfolios/rustic-jakarta-2.jpg'
                ],
                'featured' => false
            ],
            [
                'title' => 'Traditional Sundanese Wedding',
                'description' => 'Pernikahan adat Sunda yang kental dengan tradisi dan budaya lokal.',
                'images' => [
                    'portfolios/sundanese-1.jpg',
                    'portfolios/sundanese-2.jpg',
                    'portfolios/sundanese-3.jpg'
                ],
                'featured' => false
            ]
        ];

        foreach ($portfolios as $index => $portfolioData) {
            $weddingOrganizer = $weddingOrganizers->random();
            
            Portfolio::create([
                'wedding_organizer_id' => $weddingOrganizer->id,
                'title' => $portfolioData['title'],
                'description' => $portfolioData['description'],
                'images' => $portfolioData['images'],
                'featured' => $portfolioData['featured'],
                'video_url' => null
            ]);
        }

        $this->command->info('Portfolio seeder completed!');
    }
}
