<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;
use Illuminate\Support\Str;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = [
            [
                'name' => 'Admin Hastana',
                'slug' => 'admin-hastana',
                'email' => 'admin@hastanaindonesia.com',
                'bio' => 'Wedding planner profesional dengan pengalaman lebih dari 10 tahun di industri pernikahan. Spesialis dalam budget planning dan dekorasi pernikahan.',
                'avatar' => null,
                'website' => 'https://hastanaindonesia.com',
                'facebook' => 'https://facebook.com/hastanaindonesia',
                'twitter' => null,
                'instagram' => 'https://instagram.com/hastanaindonesia',
                'linkedin' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Sarah Wedding Expert',
                'slug' => 'sarah-wedding-expert',
                'email' => 'sarah@hastanaindonesia.com',
                'bio' => 'Expert dalam vendor management dan negosiasi harga. Membantu ratusan pasangan mendapatkan vendor terbaik dengan harga terjangkau.',
                'avatar' => null,
                'website' => null,
                'facebook' => null,
                'twitter' => null,
                'instagram' => 'https://instagram.com/sarahweddingexpert',
                'linkedin' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Budi Decorator',
                'slug' => 'budi-decorator',
                'email' => 'budi@hastanaindonesia.com',
                'bio' => 'Spesialis dekorasi pernikahan dengan sentuhan modern dan tradisional. Fokus pada pencahayaan dan tata ruang yang sempurna.',
                'avatar' => null,
                'website' => null,
                'facebook' => null,
                'twitter' => null,
                'instagram' => null,
                'linkedin' => null,
                'is_active' => true,
            ],
        ];

        foreach ($authors as $author) {
            Author::create($author);
        }

        $this->command->info('✅ ' . count($authors) . ' authors seeded successfully!');
    }
}
