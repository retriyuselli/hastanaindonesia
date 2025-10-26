<?php

namespace Database\Seeders;

use App\Models\AboutPage;
use Illuminate\Database\Seeder;

class AboutPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AboutPage::create([
            'history' => '<p>HASTANA Indonesia didirikan dengan visi untuk menjadi wadah bagi para profesional wedding organizer di Indonesia. Berawal dari keprihatinan akan minimnya standardisasi dalam industri wedding organizer, kami hadir untuk memberikan solusi melalui pelatihan, sertifikasi, dan pembinaan berkelanjutan.</p><p>Sejak berdiri, HASTANA telah melatih ribuan wedding organizer di seluruh Indonesia dan terus berkomitmen untuk meningkatkan profesionalisme industri pernikahan Indonesia.</p>',
            
            'vision' => 'Menjadi organisasi terdepan dalam mengembangkan profesionalisme Wedding Organizer di Indonesia yang berkelas dunia.',
            
            'mission' => '<ul><li>Menyelenggarakan pelatihan dan sertifikasi berkualitas tinggi untuk Wedding Organizer</li><li>Membangun jaringan profesional Wedding Organizer di seluruh Indonesia</li><li>Menetapkan standar industri Wedding Organizer yang profesional</li><li>Memberikan dukungan berkelanjutan kepada anggota melalui berbagai program pengembangan</li><li>Memfasilitasi kolaborasi antara Wedding Organizer dengan vendor dan stakeholder industri pernikahan</li></ul>',
            
            'values' => [
                [
                    'title' => 'Profesionalisme',
                    'description' => 'Kami berkomitmen untuk menjalankan setiap kegiatan dengan standar profesional tertinggi, memberikan pelayanan terbaik kepada seluruh anggota dan mitra kami.'
                ],
                [
                    'title' => 'Integritas',
                    'description' => 'Kejujuran dan transparansi adalah fondasi dalam setiap tindakan kami. Kami menjunjung tinggi etika bisnis dan kepercayaan yang diberikan.'
                ],
                [
                    'title' => 'Inovasi',
                    'description' => 'Kami terus berinovasi dalam mengembangkan program pelatihan dan layanan yang relevan dengan perkembangan industri pernikahan modern.'
                ],
                [
                    'title' => 'Kolaborasi',
                    'description' => 'Kami percaya bahwa kekuatan terletak pada kerja sama. Kami memfasilitasi kolaborasi yang saling menguntungkan antar anggota dan stakeholder.'
                ],
                [
                    'title' => 'Keunggulan',
                    'description' => 'Kami selalu berupaya mencapai hasil terbaik dalam setiap aspek, dari pelatihan hingga layanan kepada anggota dan mitra bisnis.'
                ],
            ],
            
            'programs' => [
                [
                    'title' => 'Sertifikasi Wedding Organizer Profesional',
                    'description' => 'Program sertifikasi komprehensif yang dirancang untuk memberikan kompetensi dan kredensial profesional kepada wedding organizer. Program ini mencakup pelatihan mendalam tentang manajemen acara, koordinasi vendor, budgeting, dan customer service excellence.'
                ],
                [
                    'title' => 'Pelatihan dan Workshop Berkelanjutan',
                    'description' => 'Rangkaian workshop dan seminar yang diselenggarakan secara berkala untuk meningkatkan keterampilan dan pengetahuan anggota. Topik mencakup tren pernikahan terkini, digital marketing, teknologi dalam wedding organizer, dan pengembangan bisnis.'
                ],
                [
                    'title' => 'Networking dan Business Matching',
                    'description' => 'Platform untuk mempertemukan wedding organizer dengan vendor, venue, dan mitra bisnis potensial. Kami menyelenggarakan acara networking reguler untuk memperluas jaringan profesional anggota.'
                ],
                [
                    'title' => 'Konsultasi Bisnis Wedding Organizer',
                    'description' => 'Layanan konsultasi profesional untuk membantu anggota dalam mengembangkan bisnis wedding organizer mereka, mulai dari strategi marketing, operasional, hingga pengembangan tim.'
                ],
                [
                    'title' => 'Direktori Wedding Organizer Bersertifikat',
                    'description' => 'Platform online yang menghubungkan calon pengantin dengan wedding organizer bersertifikat HASTANA. Ini memberikan eksposur lebih bagi anggota dan membantu calon klien menemukan wedding organizer profesional.'
                ],
            ],
            
            'is_active' => true,
        ]);
    }
}
