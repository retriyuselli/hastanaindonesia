<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing authors (handle foreign key constraints)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Author::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $authors = [
            [
                'name' => 'Admin Hastana Indonesia',
                'slug' => 'admin-hastana-indonesia',
                'email' => 'admin@hastanaindonesia.com',
                'bio' => 'Wedding planner profesional dengan pengalaman lebih dari 15 tahun di industri pernikahan Indonesia. Spesialis dalam budget planning, vendor management, dan koordinasi acara pernikahan yang memorable. Telah menangani lebih dari 500 pernikahan dengan berbagai konsep dan budget.',
                'avatar' => null,
                'website' => 'https://hastanaindonesia.com',
                'facebook' => 'https://facebook.com/hastanaindonesia',
                'twitter' => 'https://twitter.com/hastanaid',
                'instagram' => 'https://instagram.com/hastanaindonesia',
                'linkedin' => 'https://linkedin.com/company/hastana-indonesia',
                'is_active' => true,
            ],
            [
                'name' => 'Sarah Melinda',
                'slug' => 'sarah-melinda',
                'email' => 'sarah.melinda@hastanaindonesia.com',
                'bio' => 'Senior Wedding Consultant dengan expertise dalam vendor management dan negosiasi harga. Membantu ratusan pasangan mendapatkan vendor terbaik dengan harga terjangkau tanpa mengurangi kualitas. Spesialis wedding budget optimization dan timeline management.',
                'avatar' => null,
                'website' => 'https://sarahmelinda.com',
                'facebook' => 'https://facebook.com/sarah.melinda.wedding',
                'twitter' => 'https://twitter.com/sarahmelindawo',
                'instagram' => 'https://instagram.com/sarahmelinda_wedding',
                'linkedin' => 'https://linkedin.com/in/sarah-melinda',
                'is_active' => true,
            ],
            [
                'name' => 'Budi Santoso',
                'slug' => 'budi-santoso',
                'email' => 'budi.santoso@hastanaindonesia.com',
                'bio' => 'Creative Director dan spesialis dekorasi pernikahan dengan sentuhan modern dan tradisional Indonesia. Fokus pada pencahayaan artistik, tata ruang yang sempurna, dan konsep dekorasi yang Instagram-worthy. Portfolio mencakup wedding outdoor, indoor, dan destination wedding.',
                'avatar' => null,
                'website' => 'https://budisantoso-decor.com',
                'facebook' => 'https://facebook.com/budisantoso.decorator',
                'twitter' => null,
                'instagram' => 'https://instagram.com/budisantoso_decor',
                'linkedin' => 'https://linkedin.com/in/budi-santoso-decorator',
                'is_active' => true,
            ],
            [
                'name' => 'Maya Sari',
                'slug' => 'maya-sari',
                'email' => 'maya.sari@hastanaindonesia.com',
                'bio' => 'Wedding photographer dan content creator yang berpengalaman lebih dari 8 tahun. Spesialis dalam candid photography, pre-wedding, dan dokumentasi moment-moment berharga. Ahli dalam storytelling melalui visual dan social media content creation untuk wedding industry.',
                'avatar' => null,
                'website' => 'https://mayasari-photography.com',
                'facebook' => 'https://facebook.com/mayasari.photo',
                'twitter' => 'https://twitter.com/mayasariphoto',
                'instagram' => 'https://instagram.com/mayasari_photography',
                'linkedin' => 'https://linkedin.com/in/maya-sari-photographer',
                'is_active' => true,
            ],
            [
                'name' => 'Rizki Pratama',
                'slug' => 'rizki-pratama',
                'email' => 'rizki.pratama@hastanaindonesia.com',
                'bio' => 'Digital Marketing Specialist untuk wedding industry dengan fokus pada social media strategy dan online presence. Membantu wedding organizer meningkatkan brand awareness dan customer acquisition melalui platform digital. Expert dalam wedding trends dan customer behavior analysis.',
                'avatar' => null,
                'website' => 'https://rizkipratama-digital.com',
                'facebook' => 'https://facebook.com/rizki.pratama.digital',
                'twitter' => 'https://twitter.com/rizkipratama_dm',
                'instagram' => 'https://instagram.com/rizkipratama_digital',
                'linkedin' => 'https://linkedin.com/in/rizki-pratama-digital',
                'is_active' => true,
            ],
            [
                'name' => 'Anita Dewi',
                'slug' => 'anita-dewi',
                'email' => 'anita.dewi@hastanaindonesia.com',
                'bio' => 'Wedding stylist dan makeup artist dengan pengalaman internasional. Spesialis dalam bridal styling, makeup artistry, dan fashion coordination untuk wedding party. Mengikuti trend terbaru dalam bridal fashion dan beauty industry dengan sentuhan elegant dan timeless.',
                'avatar' => null,
                'website' => 'https://anitadewi-style.com',
                'facebook' => 'https://facebook.com/anita.dewi.stylist',
                'twitter' => null,
                'instagram' => 'https://instagram.com/anitadewi_stylist',
                'linkedin' => 'https://linkedin.com/in/anita-dewi-stylist',
                'is_active' => true,
            ],
        ];

        foreach ($authors as $authorData) {
            // Ensure slug is properly formatted
            $authorData['slug'] = Str::slug($authorData['name']);
            
            Author::create($authorData);
            
            $this->command->info("✅ Created author: {$authorData['name']}");
        }

        $this->command->info('🎉 Successfully seeded ' . count($authors) . ' authors with comprehensive profiles!');
        $this->command->info('📝 All authors have detailed bios, social media links, and are set as active.');
    }
}
