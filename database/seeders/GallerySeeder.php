<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create specific featured galleries
        $featuredGalleries = [
            [
                'title' => 'Setup Ballroom Mewah',
                'description' => 'Dekorasi ballroom untuk resepsi pernikahan dengan tema mewah dan elegan. Setup lengkap dengan lighting profesional dan dekorasi bunga segar.',
                'image' => 'https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=800&h=800&fit=crop',
                'category' => 'Resepsi',
                'date' => '2025-08-15',
                'location' => 'Jakarta',
                'photographer' => 'HASTANA Photography Team',
                'is_featured' => true,
                'is_published' => true,
                'tags' => ['wedding', 'ballroom', 'elegant', 'mewah'],
            ],
            [
                'title' => 'Akad Nikah Tradisional Jawa',
                'description' => 'Upacara akad nikah yang khidmat dengan nuansa tradisional Jawa lengkap dengan adat istiadat yang sakral.',
                'image' => 'https://images.unsplash.com/photo-1519741497674-611481863552?w=800&h=800&fit=crop',
                'category' => 'Akad Nikah',
                'date' => '2025-08-10',
                'location' => 'Yogyakarta',
                'photographer' => 'HASTANA Photography Team',
                'is_featured' => true,
                'is_published' => true,
                'tags' => ['wedding', 'traditional', 'jawa', 'akad'],
            ],
            [
                'title' => 'Garden Wedding Ceremony',
                'description' => 'Pernikahan outdoor di taman yang indah dengan dekorasi natural dan suasana romantis di tengah alam.',
                'image' => 'https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?w=800&h=800&fit=crop',
                'category' => 'Outdoor Wedding',
                'date' => '2025-08-05',
                'location' => 'Bali',
                'photographer' => 'HASTANA Photography Team',
                'is_featured' => true,
                'is_published' => true,
                'tags' => ['wedding', 'outdoor', 'garden', 'natural'],
            ],
            [
                'title' => 'Behind The Scenes Wedding Setup',
                'description' => 'Proses persiapan dekorasi pernikahan oleh tim wedding organizer profesional dari awal hingga siap digunakan.',
                'image' => 'https://images.unsplash.com/photo-1606800052052-a08af7148866?w=800&h=800&fit=crop',
                'category' => 'Behind The Scenes',
                'date' => '2025-08-01',
                'location' => 'Surabaya',
                'photographer' => 'HASTANA Photography Team',
                'is_featured' => true,
                'is_published' => true,
                'tags' => ['wedding', 'behind-the-scenes', 'setup', 'preparation'],
            ],
            [
                'title' => 'Table Setting Elegan',
                'description' => 'Penataan meja untuk perjamuan pernikahan dengan detail yang memukau dan sentuhan kemewahan.',
                'image' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?w=800&h=800&fit=crop',
                'category' => 'Dekorasi',
                'date' => '2025-07-28',
                'location' => 'Bandung',
                'photographer' => 'HASTANA Photography Team',
                'is_featured' => true,
                'is_published' => true,
                'tags' => ['wedding', 'table-setting', 'elegant', 'dekorasi'],
            ],
            [
                'title' => 'Busana Pengantin Tradisional',
                'description' => 'Pengantin dengan busana adat Indonesia yang memukau dengan detail bordir dan aksesoris tradisional.',
                'image' => 'https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=800&h=800&fit=crop',
                'category' => 'Fashion',
                'date' => '2025-07-25',
                'location' => 'Solo',
                'photographer' => 'HASTANA Photography Team',
                'is_featured' => false,
                'is_published' => true,
                'tags' => ['wedding', 'fashion', 'traditional', 'busana'],
            ],
            [
                'title' => 'Konsultasi Wedding Planning',
                'description' => 'Sesi planning dengan wedding organizer profesional untuk persiapan pernikahan yang sempurna.',
                'image' => 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?w=800&h=800&fit=crop',
                'category' => 'Planning',
                'date' => '2025-07-20',
                'location' => 'Jakarta',
                'photographer' => 'HASTANA Photography Team',
                'is_featured' => false,
                'is_published' => true,
                'tags' => ['wedding', 'planning', 'konsultasi', 'preparation'],
            ],
            [
                'title' => 'Dekorasi Venue Modern Minimalis',
                'description' => 'Setup dekorasi venue pernikahan dengan tema modern minimalis yang elegan dan timeless.',
                'image' => 'https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?w=800&h=800&fit=crop',
                'category' => 'Dekorasi',
                'date' => '2025-07-15',
                'location' => 'Semarang',
                'photographer' => 'HASTANA Photography Team',
                'is_featured' => false,
                'is_published' => true,
                'tags' => ['wedding', 'modern', 'minimalis', 'dekorasi'],
            ],
            [
                'title' => 'Wedding Cake Design Premium',
                'description' => 'Kue pengantin dengan desain yang unik dan mewah, dibuat oleh pastry chef profesional.',
                'image' => 'https://images.unsplash.com/photo-1535254973040-607b474cb50d?w=800&h=800&fit=crop',
                'category' => 'Catering',
                'date' => '2025-07-10',
                'location' => 'Jakarta',
                'photographer' => 'HASTANA Photography Team',
                'is_featured' => false,
                'is_published' => true,
                'tags' => ['wedding', 'cake', 'catering', 'premium'],
            ],
            [
                'title' => 'Beach Wedding Ceremony at Sunset',
                'description' => 'Upacara pernikahan di tepi pantai dengan sunset yang romantis dan suasana yang magis.',
                'image' => 'https://images.unsplash.com/photo-1537633552985-df8429e8048b?w=800&h=800&fit=crop',
                'category' => 'Outdoor Wedding',
                'date' => '2025-07-05',
                'location' => 'Lombok',
                'photographer' => 'HASTANA Photography Team',
                'is_featured' => true,
                'is_published' => true,
                'tags' => ['wedding', 'beach', 'outdoor', 'sunset'],
            ],
            [
                'title' => 'Floral Decoration Premium',
                'description' => 'Dekorasi bunga segar yang indah untuk pelaminan pengantin dengan rangkaian bunga impor.',
                'image' => 'https://images.unsplash.com/photo-1522673607200-164d1b6ce486?w=800&h=800&fit=crop',
                'category' => 'Dekorasi',
                'date' => '2025-06-30',
                'location' => 'Medan',
                'photographer' => 'HASTANA Photography Team',
                'is_featured' => false,
                'is_published' => true,
                'tags' => ['wedding', 'floral', 'flower', 'dekorasi'],
            ],
            [
                'title' => 'Live Music Entertainment',
                'description' => 'Hiburan live music dengan band profesional untuk acara resepsi pernikahan yang meriah.',
                'image' => 'https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?w=800&h=800&fit=crop',
                'category' => 'Entertainment',
                'date' => '2025-06-25',
                'location' => 'Bali',
                'photographer' => 'HASTANA Photography Team',
                'is_featured' => false,
                'is_published' => true,
                'tags' => ['wedding', 'music', 'entertainment', 'live'],
            ],
            [
                'title' => 'Professional Lighting Setup',
                'description' => 'Tata cahaya profesional yang menawan untuk menciptakan suasana romantis dan dramatis.',
                'image' => 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=800&h=800&fit=crop',
                'category' => 'Technical',
                'date' => '2025-06-20',
                'location' => 'Jakarta',
                'photographer' => 'HASTANA Photography Team',
                'is_featured' => false,
                'is_published' => true,
                'tags' => ['wedding', 'lighting', 'technical', 'professional'],
            ],
            [
                'title' => 'Traditional Javanese Ceremony',
                'description' => 'Upacara adat Jawa dengan ritual tradisional yang sakral dan penuh makna.',
                'image' => 'https://images.unsplash.com/photo-1591604129939-f1efa4d9f7fa?w=800&h=800&fit=crop',
                'category' => 'Akad Nikah',
                'date' => '2025-06-15',
                'location' => 'Yogyakarta',
                'photographer' => 'HASTANA Photography Team',
                'is_featured' => false,
                'is_published' => true,
                'tags' => ['wedding', 'traditional', 'jawa', 'ceremony'],
            ],
            [
                'title' => 'Bride Preparation & Makeup',
                'description' => 'Persiapan pengantin wanita dengan makeup dan styling profesional oleh MUA berpengalaman.',
                'image' => 'https://images.unsplash.com/photo-1519741497674-611481863552?w=800&h=800&fit=crop',
                'category' => 'Preparation',
                'date' => '2025-06-10',
                'location' => 'Surabaya',
                'photographer' => 'HASTANA Photography Team',
                'is_featured' => false,
                'is_published' => true,
                'tags' => ['wedding', 'bride', 'makeup', 'preparation'],
            ],
            [
                'title' => 'Intimate Wedding Gathering',
                'description' => 'Pernikahan intimate dengan keluarga dekat dan sahabat dalam suasana yang hangat dan personal.',
                'image' => 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=800&h=800&fit=crop',
                'category' => 'Intimate Wedding',
                'date' => '2025-06-05',
                'location' => 'Bandung',
                'photographer' => 'HASTANA Photography Team',
                'is_featured' => false,
                'is_published' => true,
                'tags' => ['wedding', 'intimate', 'small', 'gathering'],
            ],
        ];

        foreach ($featuredGalleries as $gallery) {
            Gallery::create($gallery);
        }

        // Create additional random galleries using factory
        Gallery::factory()
            ->count(30)
            ->create();

        $this->command->info('Gallery seeded successfully!');
        $this->command->info('Total galleries: ' . Gallery::count());
        $this->command->info('Featured galleries: ' . Gallery::featured()->count());
        $this->command->info('Published galleries: ' . Gallery::published()->count());
    }
}
