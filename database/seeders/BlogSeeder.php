<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Creates 5 blog posts for each of the 8 categories (40 posts total)
     */
    public function run(): void
    {
        // Get all categories
        $categories = BlogCategory::all();
        
        // Authors pool
        $authors = [
            ['name' => 'Sarah Putri', 'avatar' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=40&h=40&fit=crop&crop=face&auto=format'],
            ['name' => 'Budi Santoso', 'avatar' => 'https://images.unsplash.com/photo-1566492031773-4f4e44671d66?w=40&h=40&fit=crop&crop=face&auto=format'],
            ['name' => 'Maya Sari', 'avatar' => 'https://images.unsplash.com/photo-1594736797933-d0401ba2fe65?w=40&h=40&fit=crop&crop=face&auto=format'],
            ['name' => 'Andi Pratama', 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=40&h=40&fit=crop&crop=face&auto=format'],
            ['name' => 'Lisa Amanda', 'avatar' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=40&h=40&fit=crop&crop=face&auto=format'],
            ['name' => 'Rudi Hermawan', 'avatar' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=40&h=40&fit=crop&crop=face&auto=format'],
            ['name' => 'Diana Putri', 'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=40&h=40&fit=crop&crop=face&auto=format'],
            ['name' => 'Farhan Malik', 'avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=40&h=40&fit=crop&crop=face&auto=format'],
        ];
        
        // Featured images pool
        $images = [
            'https://images.unsplash.com/photo-1519741497674-611481863552?w=800&h=450&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=800&h=450&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1469371670807-013ccf25f16a?w=800&h=450&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=800&h=450&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&h=450&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=800&h=450&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=800&h=450&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1478146896981-b80fe463b330?w=800&h=450&fit=crop&auto=format',
        ];
        
        // Blog posts data for each category
        $blogTemplates = [
            'tips-tutorial' => [
                [
                    'title' => '10 Tips Mengelola Budget Wedding untuk Klien',
                    'excerpt' => 'Mengelola budget pernikahan adalah tantangan terbesar wedding organizer. Berikut 10 tips efektif untuk membantu klien mengoptimalkan budget tanpa mengurangi kualitas.',
                    'tags' => ['budget management', 'tips', 'wedding planning', 'keuangan'],
                ],
                [
                    'title' => 'Panduan Lengkap Koordinasi Tim Wedding Organizer',
                    'excerpt' => 'Koordinasi tim yang baik adalah kunci kesuksesan acara pernikahan. Pelajari cara efektif mengelola dan mengkoordinasi tim WO profesional.',
                    'tags' => ['koordinasi', 'team management', 'tips', 'wedding organizer'],
                ],
                [
                    'title' => '15 Checklist Penting untuk Persiapan Wedding Day',
                    'excerpt' => 'Jangan sampai ada yang terlewat di hari H! Checklist lengkap dari pagi hingga malam untuk memastikan acara pernikahan berjalan sempurna.',
                    'tags' => ['checklist', 'persiapan', 'wedding day', 'panduan'],
                ],
                [
                    'title' => 'Cara Menangani Klien yang Sulit: Tips untuk WO Pemula',
                    'excerpt' => 'Setiap wedding organizer pasti pernah menghadapi klien yang challenging. Berikut strategi komunikasi efektif untuk menangani berbagai tipe klien.',
                    'tags' => ['client management', 'komunikasi', 'tips', 'profesional'],
                ],
                [
                    'title' => 'Tutorial: Membuat Timeline Pernikahan yang Perfect',
                    'excerpt' => 'Timeline yang baik membuat acara terasa smooth dan natural. Panduan step-by-step membuat timeline pernikahan yang efektif dan realistis.',
                    'tags' => ['timeline', 'tutorial', 'wedding planning', 'rundown'],
                ],
            ],
            'tren-pernikahan' => [
                [
                    'title' => 'Tren Pernikahan 2025: Sustainable Wedding',
                    'excerpt' => 'Sustainable wedding menjadi tren populer di kalangan milenial dan Gen-Z. Panduan lengkap mengorganisir pernikahan ramah lingkungan yang tetap indah dan berkesan.',
                    'tags' => ['sustainable wedding', 'eco-friendly', 'tren 2025', 'ramah lingkungan'],
                ],
                [
                    'title' => 'Micro Wedding: Tren Pernikahan Intimate yang Semakin Populer',
                    'excerpt' => 'Micro wedding dengan 50 tamu atau kurang menjadi pilihan favorit. Eksplorasi keuntungan dan cara mengorganisir micro wedding yang berkesan.',
                    'tags' => ['micro wedding', 'intimate wedding', 'tren', 'modern'],
                ],
                [
                    'title' => 'Garden Wedding: Konsep Outdoor yang Timeless',
                    'excerpt' => 'Garden wedding tidak pernah kehilangan pesonanya. Inspirasi dan tips mengorganisir pernikahan outdoor dengan tema garden yang elegan.',
                    'tags' => ['garden wedding', 'outdoor', 'tren', 'dekorasi'],
                ],
                [
                    'title' => 'Virtual Wedding: Solusi Modern untuk Tamu Jarak Jauh',
                    'excerpt' => 'Live streaming dan virtual attendance menjadi normal baru di industri pernikahan. Panduan teknologi dan setup virtual wedding profesional.',
                    'tags' => ['virtual wedding', 'live streaming', 'teknologi', 'modern'],
                ],
                [
                    'title' => 'Minimalist Wedding: Less is More dalam Pernikahan Modern',
                    'excerpt' => 'Tren minimalis dengan fokus pada kualitas daripada kuantitas. Ide dan inspirasi untuk mengadakan pernikahan minimalis yang elegan dan berkesan.',
                    'tags' => ['minimalist', 'modern wedding', 'simple', 'elegant'],
                ],
            ],
            'teknologi-aplikasi' => [
                [
                    'title' => 'Digital Transformation dalam Industri Wedding Organizer 2025',
                    'excerpt' => 'Perkembangan teknologi digital mengubah cara wedding organizer bekerja. Strategi transformasi digital yang efektif untuk meningkatkan efisiensi dan kualitas layanan.',
                    'tags' => ['digital transformation', 'teknologi', 'wedding organizer', 'efisiensi'],
                ],
                [
                    'title' => '5 Aplikasi Wajib untuk Wedding Organizer Modern',
                    'excerpt' => 'Di era digital ini, wedding organizer membutuhkan tools yang tepat. Berikut 5 aplikasi wajib yang akan meningkatkan produktivitas dan memberikan service terbaik.',
                    'tags' => ['aplikasi', 'produktivitas', 'wedding organizer', 'teknologi'],
                ],
                [
                    'title' => 'CRM untuk Wedding Organizer: Pilih yang Terbaik',
                    'excerpt' => 'Customer Relationship Management adalah kunci sukses bisnis WO. Review lengkap CRM terbaik untuk wedding organizer di Indonesia.',
                    'tags' => ['CRM', 'software', 'manajemen klien', 'bisnis'],
                ],
                [
                    'title' => 'Automasi Marketing untuk Wedding Organizer',
                    'excerpt' => 'Hemat waktu dengan marketing automation. Panduan setup email marketing, social media scheduling, dan follow-up otomatis untuk WO.',
                    'tags' => ['automation', 'marketing', 'email', 'efisiensi'],
                ],
                [
                    'title' => 'Cloud Storage Solutions untuk Dokumentasi Wedding',
                    'excerpt' => 'Kelola ribuan foto dan video klien dengan aman. Perbandingan cloud storage terbaik untuk wedding organizer profesional.',
                    'tags' => ['cloud storage', 'dokumentasi', 'backup', 'teknologi'],
                ],
            ],
            'bisnis-marketing' => [
                [
                    'title' => 'Strategi Marketing Digital untuk Wedding Organizer Pemula',
                    'excerpt' => 'Membangun bisnis wedding organizer dari nol membutuhkan strategi marketing yang tepat. Panduan lengkap digital marketing untuk WO pemula.',
                    'tags' => ['digital marketing', 'strategi bisnis', 'wedding organizer', 'pemula'],
                ],
                [
                    'title' => 'Instagram Marketing untuk Wedding Organizer: Strategi Jitu',
                    'excerpt' => 'Instagram adalah platform paling powerful untuk wedding organizer. Tips dan trik membangun presence Instagram yang engaging dan menghasilkan leads.',
                    'tags' => ['instagram', 'social media', 'marketing', 'konten'],
                ],
                [
                    'title' => 'Membangun Brand Identity untuk Wedding Organizer',
                    'excerpt' => 'Brand yang kuat membedakan Anda dari kompetitor. Panduan step-by-step membangun brand identity yang konsisten dan memorable.',
                    'tags' => ['branding', 'brand identity', 'marketing', 'bisnis'],
                ],
                [
                    'title' => 'Pricing Strategy: Cara Menentukan Harga Jasa WO yang Tepat',
                    'excerpt' => 'Menentukan harga yang kompetitif namun profitable adalah tantangan. Strategi pricing yang efektif untuk wedding organizer di berbagai segmen pasar.',
                    'tags' => ['pricing', 'strategi bisnis', 'profitabilitas', 'revenue'],
                ],
                [
                    'title' => 'Networking untuk Wedding Organizer: Membangun Koneksi Bisnis',
                    'excerpt' => 'Network yang luas adalah aset berharga dalam bisnis wedding. Tips membangun dan maintain relasi dengan vendor, venue, dan sesama WO.',
                    'tags' => ['networking', 'bisnis', 'relasi', 'partnership'],
                ],
            ],
            'inspirasi-dekorasi' => [
                [
                    'title' => 'Inspirasi Dekorasi Pernikahan Minimalis Modern',
                    'excerpt' => 'Dekorasi minimalis yang elegan dan instagramable. Koleksi inspirasi dekorasi dengan konsep less is more yang tetap memukau.',
                    'tags' => ['dekorasi', 'minimalis', 'modern', 'inspirasi'],
                ],
                [
                    'title' => '20 Ide Dekorasi Meja Tamu yang Unik dan Berkesan',
                    'excerpt' => 'Table setting yang cantik membuat pengalaman tamu semakin special. Inspirasi dekorasi meja dengan berbagai tema dan budget.',
                    'tags' => ['table setting', 'dekorasi', 'kreatif', 'unik'],
                ],
                [
                    'title' => 'Photobooth Wedding: Ide Kreatif untuk Menghibur Tamu',
                    'excerpt' => 'Photobooth menjadi hiburan favorit di acara pernikahan. Ide-ide photobooth kreatif dan tips setup yang mudah namun impressive.',
                    'tags' => ['photobooth', 'entertainment', 'dekorasi', 'fun'],
                ],
                [
                    'title' => 'Dekorasi Lighting: Ciptakan Atmosfer Pernikahan yang Magis',
                    'excerpt' => 'Lighting adalah elemen penting yang often overlooked. Panduan menggunakan lighting untuk menciptakan suasana romantic dan dramatic.',
                    'tags' => ['lighting', 'dekorasi', 'atmosfer', 'romantic'],
                ],
                [
                    'title' => 'DIY Dekorasi Wedding: Hemat Budget Tanpa Kurangi Estetika',
                    'excerpt' => 'Dekorasi cantik tidak harus mahal. Tutorial DIY dekorasi pernikahan yang mudah dibuat dan tetap terlihat profesional.',
                    'tags' => ['DIY', 'dekorasi', 'budget friendly', 'kreatif'],
                ],
            ],
            'event-management' => [
                [
                    'title' => 'Manajemen Vendor: Kunci Kesuksesan Acara Pernikahan',
                    'excerpt' => 'Koordinasi vendor yang efektif menentukan kelancaran acara. Strategi memilih, mengelola, dan berkoordinasi dengan berbagai vendor pernikahan.',
                    'tags' => ['vendor management', 'koordinasi', 'event', 'manajemen'],
                ],
                [
                    'title' => 'Crisis Management di Hari H: Siap Hadapi Skenario Terburuk',
                    'excerpt' => 'Persiapkan plan B untuk berbagai kemungkinan masalah. Panduan crisis management dan problem solving di hari pernikahan.',
                    'tags' => ['crisis management', 'problem solving', 'plan B', 'profesional'],
                ],
                [
                    'title' => 'Rundown Acara Pernikahan: Template dan Best Practices',
                    'excerpt' => 'Rundown yang detail dan realistis adalah blueprint kesuksesan. Template rundown lengkap dengan tips timing yang perfect.',
                    'tags' => ['rundown', 'timeline', 'event management', 'template'],
                ],
                [
                    'title' => 'Sound System dan Technical Setup untuk Wedding',
                    'excerpt' => 'Audio visual yang sempurna membuat momen lebih berkesan. Panduan setup technical requirements untuk berbagai jenis venue.',
                    'tags' => ['sound system', 'technical', 'audio visual', 'setup'],
                ],
                [
                    'title' => 'Logistik Pernikahan: Checklist Lengkap untuk WO',
                    'excerpt' => 'Detail logistik yang terorganisir mencegah chaos di lapangan. Checklist komprehensif untuk manajemen logistik pernikahan.',
                    'tags' => ['logistik', 'checklist', 'manajemen', 'organisasi'],
                ],
            ],
            'vendor-partnership' => [
                [
                    'title' => 'Memilih Vendor Catering yang Tepat untuk Klien',
                    'excerpt' => 'Catering adalah aspek penting yang directly impact kepuasan tamu. Kriteria pemilihan vendor catering yang reliable dan berkualitas.',
                    'tags' => ['catering', 'vendor', 'food', 'quality'],
                ],
                [
                    'title' => 'Kerjasama dengan Photographer: Tips Win-Win Partnership',
                    'excerpt' => 'Photographer adalah partner penting wedding organizer. Cara membangun kerjasama yang saling menguntungkan dan profesional.',
                    'tags' => ['photographer', 'partnership', 'vendor', 'kerjasama'],
                ],
                [
                    'title' => 'Vendor Decoration: Cara Memilih Dekorator yang Sesuai Style',
                    'excerpt' => 'Setiap dekorator memiliki signature style berbeda. Panduan matching dekorator dengan preferensi dan budget klien.',
                    'tags' => ['decoration', 'vendor', 'style', 'matching'],
                ],
                [
                    'title' => 'MUA dan Busana: Vendor Kecantikan untuk Hari Istimewa',
                    'excerpt' => 'Make up artist dan busana pengantin adalah investment penting. Tips memilih MUA dan vendor busana yang profesional dan terpercaya.',
                    'tags' => ['MUA', 'makeup', 'busana', 'vendor'],
                ],
                [
                    'title' => 'Entertainment Vendor: Pilihan untuk Berbagai Budget',
                    'excerpt' => 'Entertainment membuat acara lebih hidup dan memorable. Review vendor entertainment dari band, DJ, hingga traditional performers.',
                    'tags' => ['entertainment', 'vendor', 'music', 'performance'],
                ],
            ],
            'budget-finance' => [
                [
                    'title' => 'Financial Planning untuk Wedding Organizer Business',
                    'excerpt' => 'Kelola keuangan bisnis WO dengan profesional. Panduan financial planning, cash flow management, dan profit optimization.',
                    'tags' => ['finance', 'business', 'cash flow', 'profit'],
                ],
                [
                    'title' => 'Sistem Pembayaran dan Invoice untuk Klien Wedding',
                    'excerpt' => 'Payment system yang jelas mencegah konflik. Template invoice, payment terms, dan cara professional handling payment dari klien.',
                    'tags' => ['payment', 'invoice', 'billing', 'finance'],
                ],
                [
                    'title' => 'Cost Breakdown: Estimasi Budget Pernikahan Lengkap',
                    'excerpt' => 'Bantu klien memahami kemana uang mereka pergi. Cost breakdown detail untuk berbagai kategori budget pernikahan.',
                    'tags' => ['budget', 'cost breakdown', 'estimasi', 'planning'],
                ],
                [
                    'title' => 'Nego dengan Vendor: Strategi Mendapatkan Harga Terbaik',
                    'excerpt' => 'Skill negosiasi yang baik menghemat budget tanpa sacrifice quality. Tips dan strategi nego yang efektif dengan berbagai jenis vendor.',
                    'tags' => ['negosiasi', 'vendor', 'budget', 'strategy'],
                ],
                [
                    'title' => 'Asuransi Wedding: Proteksi untuk Event Besar',
                    'excerpt' => 'Asuransi melindungi investasi besar klien dari risiko. Panduan memilih dan menjelaskan wedding insurance kepada klien.',
                    'tags' => ['asuransi', 'insurance', 'proteksi', 'risk management'],
                ],
            ],
        ];
        
        $counter = 1;
        $totalDays = 60; // Posts spread across 60 days
        
        foreach ($categories as $category) {
            $templates = $blogTemplates[$category->slug] ?? [];
            
            foreach ($templates as $index => $template) {
                $author = $authors[array_rand($authors)];
                $image = $images[array_rand($images)];
                
                $blog = [
                    'title' => $template['title'],
                    'slug' => Str::slug($template['title']),
                    'excerpt' => $template['excerpt'],
                    'summary' => Str::limit($template['excerpt'], 150),
                    'content' => $this->generateContent($template['title'], $template['excerpt']),
                    'featured_image' => $image,
                    'blog_category_id' => $category->id,
                    'author_name' => $author['name'],
                    'author_avatar' => $author['avatar'],
                    'meta_title' => $template['title'] . ' - HASTANA Indonesia',
                    'meta_description' => $template['excerpt'],
                    'seo_keywords' => $template['tags'],
                    'tags' => $template['tags'],
                    'read_time' => rand(8, 20),
                    'views_count' => rand(100, 5000),
                    'likes_count' => rand(10, 500),
                    'comments_count' => rand(0, 50),
                    'engagement_score' => 0,
                    'is_published' => true,
                    'status' => 'published',
                    'is_featured' => $index === 0, // First article of each category is featured
                    'published_at' => now()->subDays($totalDays - ($counter * 1.5))
                ];
                
                Blog::updateOrCreate(
                    ['slug' => $blog['slug']],
                    $blog
                );
                
                $counter++;
            }
        }
        
        $this->command->info('Created ' . ($counter - 1) . ' blog posts across ' . $categories->count() . ' categories');
    }
    
    /**
     * Generate sample content for blog post
     */
    private function generateContent($title, $excerpt)
    {
        return <<<HTML
<p>{$excerpt}</p>

<h2>Pendahuluan</h2>
<p>Dalam dunia wedding organizer yang dinamis, {$title} menjadi topik yang sangat relevan untuk dibahas. Artikel ini akan memberikan panduan lengkap dan praktis untuk Anda.</p>

<h2>Mengapa Ini Penting?</h2>
<p>Sebagai wedding organizer profesional, memahami aspek ini akan membantu Anda:</p>
<ul>
    <li>Meningkatkan kualitas layanan kepada klien</li>
    <li>Mengoptimalkan proses kerja dan efisiensi</li>
    <li>Membangun reputasi sebagai WO yang kompeten</li>
    <li>Meningkatkan kepuasan klien dan referral bisnis</li>
</ul>

<h2>Tips dan Strategi</h2>
<p>Berikut beberapa poin penting yang perlu Anda perhatikan:</p>

<h3>1. Persiapan yang Matang</h3>
<p>Persiapan adalah kunci kesuksesan. Pastikan Anda memiliki checklist lengkap dan timeline yang jelas untuk setiap tahapan.</p>

<h3>2. Komunikasi Efektif</h3>
<p>Jaga komunikasi yang baik dengan klien dan semua pihak terkait. Respon yang cepat dan profesional mencerminkan kredibilitas Anda.</p>

<h3>3. Fleksibilitas dan Adaptasi</h3>
<p>Setiap klien dan situasi berbeda. Kemampuan beradaptasi dan memberikan solusi kreatif sangat penting.</p>

<h2>Kesimpulan</h2>
<p>Menguasai aspek ini akan membawa bisnis wedding organizer Anda ke level yang lebih tinggi. Terus belajar, berinovasi, dan berikan yang terbaik untuk setiap klien.</p>

<p>Untuk tips dan artikel menarik lainnya seputar wedding organizer, ikuti terus blog HASTANA Indonesia!</p>
HTML;
    }
}
