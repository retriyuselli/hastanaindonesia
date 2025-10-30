<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\WeddingOrganizer;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all wedding organizers
        $organizers = WeddingOrganizer::all();

        if ($organizers->isEmpty()) {
            $this->command->warn('No wedding organizers found. Please run WeddingOrganizerSeeder first.');
            return;
        }

        $products = [
            [
                'name' => 'Paket Pernikahan Premium Gold',
                'description' => '<p>Paket pernikahan premium yang mencakup semua kebutuhan pernikahan impian Anda.</p>
<p><strong>Fasilitas yang didapatkan:</strong></p>
<ol>
<li>Wedding Organizer & Coordinator profesional</li>
<li>Dekorasi pelaminan mewah dengan fresh flowers</li>
<li>Dokumentasi foto unlimited (2 fotografer)</li>
<li>Video cinematic dengan drone</li>
<li>Make up & busana pengantin lengkap</li>
<li>Prewedding indoor & outdoor</li>
<li>Live music & entertainment</li>
<li>Catering premium 500 pax</li>
</ol>
<p><strong>Bonus:</strong></p>
<ul>
<li>Wedding cake 5 tier</li>
<li>Souvenir eksklusif 500 pcs</li>
<li>Dekorasi mobil pengantin</li>
<li>Photo booth unlimited print</li>
</ul>',
                'original_price' => 150000000,
                'price' => 120000000,
                'images' => [
                    'https://images.unsplash.com/photo-1519741497674-611481863552?w=800&h=800&fit=crop',
                    'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=800&h=800&fit=crop',
                    'https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=800&h=800&fit=crop',
                ],
                'features' => [
                    'Full Package Wedding Organizer',
                    'Dekorasi Premium dengan Fresh Flowers',
                    'Dokumentasi Foto & Video Profesional',
                    'Make Up & Busana Pengantin Lengkap',
                    'Catering Premium 500 Pax',
                ],
                'badges' => ['Best Seller', 'Premium Package', 'Free Prewedding'],
                'limited_offer' => true,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Paket Pernikahan Intimate Silver',
                'description' => '<p>Paket pernikahan intimate yang cocok untuk acara dengan skala menengah.</p>
<p><strong>Fasilitas yang didapatkan:</strong></p>
<ol>
<li>Wedding Organizer & Coordinator</li>
<li>Dekorasi pelaminan elegant</li>
<li>Dokumentasi foto (1 fotografer, 300 foto)</li>
<li>Video cinematic highlight 5-7 menit</li>
<li>Make up pengantin & orang tua</li>
<li>Prewedding indoor</li>
<li>Catering 300 pax</li>
</ol>
<p><strong>Bonus:</strong></p>
<ul>
<li>Wedding cake 3 tier</li>
<li>Souvenir 300 pcs</li>
<li>Dekorasi mobil pengantin</li>
</ul>',
                'original_price' => 80000000,
                'price' => 67000000,
                'images' => [
                    'https://images.unsplash.com/photo-1606800052052-a08af7148866?w=800&h=800&fit=crop',
                    'https://images.unsplash.com/photo-1591604466107-ec97de577aff?w=800&h=800&fit=crop',
                    'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=800&h=800&fit=crop',
                ],
                'features' => [
                    'Wedding Organizer Professional',
                    'Dekorasi Elegant',
                    'Dokumentasi Foto & Video',
                    'Make Up Pengantin & Orang Tua',
                    'Catering 300 Pax',
                ],
                'badges' => ['Popular Choice', 'Intimate Package'],
                'limited_offer' => false,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Paket Pernikahan Simple Bronze',
                'description' => '<p>Paket pernikahan hemat yang tetap berkualitas untuk acara intimate.</p>
<p><strong>Fasilitas yang didapatkan:</strong></p>
<ol>
<li>Wedding Coordinator</li>
<li>Dekorasi pelaminan simple & elegant</li>
<li>Dokumentasi foto (200 foto)</li>
<li>Make up pengantin</li>
<li>Catering 200 pax</li>
</ol>
<p><strong>Bonus:</strong></p>
<ul>
<li>Wedding cake 2 tier</li>
<li>Souvenir 200 pcs</li>
</ul>',
                'original_price' => 45000000,
                'price' => 38000000,
                'images' => [
                    'https://images.unsplash.com/photo-1522673607200-164d1b6ce486?w=800&h=800&fit=crop',
                    'https://images.unsplash.com/photo-1529636798458-92182e662485?w=800&h=800&fit=crop',
                ],
                'features' => [
                    'Wedding Coordinator',
                    'Dekorasi Simple & Elegant',
                    'Dokumentasi Foto',
                    'Make Up Pengantin',
                    'Catering 200 Pax',
                ],
                'badges' => ['Budget Friendly', 'Intimate'],
                'limited_offer' => true,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Paket Akad Nikah & Resepsi',
                'description' => '<p>Paket lengkap untuk acara akad nikah dan resepsi pernikahan.</p>
<p><strong>Fasilitas Akad Nikah:</strong></p>
<ol>
<li>Dekorasi akad nikah</li>
<li>Make up pengantin & orang tua</li>
<li>Dokumentasi foto & video akad</li>
<li>Hantaran pernikahan</li>
</ol>
<p><strong>Fasilitas Resepsi:</strong></p>
<ol>
<li>Dekorasi pelaminan & photo booth</li>
<li>Dokumentasi foto & video resepsi</li>
<li>Catering 400 pax</li>
<li>Entertainment & MC</li>
</ol>',
                'original_price' => 95000000,
                'price' => 85000000,
                'images' => [
                    'https://images.unsplash.com/photo-1519167758481-83f29da8c2b8?w=800&h=800&fit=crop',
                    'https://images.unsplash.com/photo-1516589178581-6cd7833ae3b2?w=800&h=800&fit=crop',
                ],
                'features' => [
                    'Akad Nikah & Resepsi Lengkap',
                    'Double Dokumentasi',
                    'Double Make Up',
                    'Catering 400 Pax',
                    'Entertainment & MC',
                ],
                'badges' => ['Complete Package', 'Special Offer'],
                'limited_offer' => true,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Paket Dekorasi & Dokumentasi',
                'description' => '<p>Paket khusus untuk dekorasi dan dokumentasi profesional.</p>
<p><strong>Fasilitas Dekorasi:</strong></p>
<ol>
<li>Dekorasi pelaminan premium</li>
<li>Dekorasi meja akad</li>
<li>Dekorasi photo booth</li>
<li>Backdrop Instagram-able</li>
</ol>
<p><strong>Fasilitas Dokumentasi:</strong></p>
<ol>
<li>2 Fotografer profesional</li>
<li>1 Videografer dengan drone</li>
<li>Unlimited foto HD</li>
<li>Video cinematic 10-15 menit</li>
<li>Same day edit</li>
</ol>',
                'original_price' => 35000000,
                'price' => 28000000,
                'images' => [
                    'https://images.unsplash.com/photo-1478146896981-b80fe463b330?w=800&h=800&fit=crop',
                    'https://images.unsplash.com/photo-1460978812857-470ed1c77af0?w=800&h=800&fit=crop',
                ],
                'features' => [
                    'Dekorasi Premium Complete',
                    'Tim Dokumentasi Lengkap',
                    'Unlimited Foto HD',
                    'Video Cinematic + Drone',
                    'Same Day Edit',
                ],
                'badges' => ['Decoration Expert', 'Professional Photo/Video'],
                'limited_offer' => false,
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        // Create products for each organizer (first 3 organizers get all products)
        foreach ($organizers->take(3) as $index => $organizer) {
            $this->command->info("Creating products for {$organizer->organizer_name}...");
            
            foreach ($products as $productIndex => $productData) {
                Product::create([
                    'wedding_organizer_id' => $organizer->id,
                    'name' => $productData['name'],
                    'slug' => \Illuminate\Support\Str::slug($productData['name']) . '-' . $organizer->id . '-' . $productIndex,
                    'description' => $productData['description'],
                    'original_price' => $productData['original_price'],
                    'price' => $productData['price'],
                    'images' => $productData['images'],
                    'features' => $productData['features'],
                    'badges' => $productData['badges'],
                    'limited_offer' => $productData['limited_offer'],
                    'is_active' => $productData['is_active'],
                    'sort_order' => $productData['sort_order'],
                ]);
            }
        }

        // Remaining organizers get 2-3 random products
        foreach ($organizers->skip(3) as $organizer) {
            $this->command->info("Creating random products for {$organizer->organizer_name}...");
            
            $randomProducts = collect($products)->random(rand(2, 3));
            
            foreach ($randomProducts as $productIndex => $productData) {
                Product::create([
                    'wedding_organizer_id' => $organizer->id,
                    'name' => $productData['name'],
                    'slug' => \Illuminate\Support\Str::slug($productData['name']) . '-' . $organizer->id . '-' . time() . '-' . rand(1000, 9999),
                    'description' => $productData['description'],
                    'original_price' => $productData['original_price'],
                    'price' => $productData['price'],
                    'images' => $productData['images'],
                    'features' => $productData['features'],
                    'badges' => $productData['badges'],
                    'limited_offer' => $productData['limited_offer'],
                    'is_active' => $productData['is_active'],
                    'sort_order' => $productData['sort_order'],
                ]);
            }
        }

        $this->command->info('Products seeded successfully!');
    }
}
