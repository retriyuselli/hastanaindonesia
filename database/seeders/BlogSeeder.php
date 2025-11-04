<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\Author;
use App\Models\BlogCategory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing blogs (handle foreign key constraints)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Blog::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Get categories and authors
        $categories = BlogCategory::all();
        $authors = Author::where('is_active', true)->get();

        if ($categories->isEmpty() || $authors->isEmpty()) {
            $this->command->error('❌ Please run BlogCategorySeeder and AuthorSeeder first!');
            return;
        }

        $blogs = [
            [
                'title' => '10 Tips Budget Wedding yang Elegan dan Berkesan',
                'featured_image' => 'https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'excerpt' => 'Merencanakan pernikahan impian dengan budget terbatas? Temukan tips dan trik dari wedding planner profesional untuk menciptakan pernikahan yang elegan tanpa menguras kantong.',
                'content' => '<h2>Pentingnya Perencanaan Budget Wedding</h2>
                <p>Merencanakan pernikahan dengan budget terbatas memang tantangan tersendiri. Namun, dengan strategi yang tepat, Anda tetap bisa mengadakan acara pernikahan yang berkesan dan elegan.</p>
                
                <h3>1. Tentukan Prioritas Utama</h3>
                <p>Buatlah daftar elemen pernikahan yang paling penting bagi Anda. Apakah itu venue, makanan, dekorasi, atau dokumentasi? Alokasikan budget lebih besar untuk prioritas utama.</p>
                
                <h3>2. Manfaatkan Vendor Lokal</h3>
                <p>Vendor lokal umumnya menawarkan harga lebih kompetitif dibanding vendor ternama. Plus, Anda membantu ekonomi lokal!</p>
                
                <h3>3. Pilih Waktu Off-Season</h3>
                <p>Mengadakan pernikahan di luar musim ramai (seperti hari kerja atau bulan tertentu) dapat menghemat budget hingga 30%.</p>
                
                <h2>Tips Dekorasi Hemat</h2>
                <p>Dekorasi tidak harus mahal untuk terlihat mewah. Gunakan bunga musiman, DIY centerpiece, dan pencahayaan yang tepat untuk menciptakan suasana romantis.</p>',
                'meta_title' => '10 Tips Budget Wedding Elegan - Panduan Lengkap 2024',
                'meta_description' => 'Panduan lengkap merencanakan pernikahan budget dengan tips dari wedding planner profesional. Hemat hingga 50% tanpa mengurangi kemewahan!',
                'tags' => ['budget wedding', 'tips pernikahan', 'wedding planning', 'hemat budget'],
                'seo_keywords' => ['budget wedding indonesia', 'tips pernikahan murah', 'wedding planner budget'],
                'read_time' => 8,
                'is_published' => true,
                'is_featured' => true,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(2),
            ],
            [
                'title' => 'Trend Dekorasi Pernikahan 2024: Minimalis dan Sustainable',
                'featured_image' => 'https://images.unsplash.com/photo-1520854221256-17451cc331bf?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'excerpt' => 'Discover the hottest wedding decoration trends for 2024! From minimalist designs to eco-friendly sustainable decorations that are both beautiful and environmentally conscious.',
                'content' => '<h2>Minimalis is The New Luxury</h2>
                <p>Tahun 2024 menjadi momen di mana "less is more" benar-benar diterapkan dalam dekorasi pernikahan. Konsep minimalis tidak berarti sederhana, melainkan elegant simplicity.</p>
                
                <h3>Color Palette Netral</h3>
                <p>Warna-warna earth tone seperti sage green, dusty pink, dan cream menjadi pilihan utama. Kombinasi ini menciptakan atmosfer yang tenang dan timeless.</p>
                
                <h3>Sustainable Wedding Decor</h3>
                <p>Kesadaran lingkungan mendorong trend penggunaan bahan-bahan ramah lingkungan seperti:</p>
                <ul>
                <li>Bunga lokal dan organik</li>
                <li>Dekorasi yang dapat didaur ulang</li>
                <li>Centerpiece dari bahan alami</li>
                <li>LED lighting untuk efisiensi energi</li>
                </ul>
                
                <h2>Geometric Shapes & Clean Lines</h2>
                <p>Bentuk geometris dengan garis-garis bersih menjadi signature 2024. Arch minimalis, table setting dengan bentuk angular, dan backdrop dengan desain geometric sangat populer.</p>',
                'meta_title' => 'Trend Dekorasi Pernikahan 2024 - Minimalis & Sustainable',
                'meta_description' => 'Temukan trend dekorasi pernikahan terbaru 2024! Konsep minimalis dan sustainable yang akan membuat pernikahan Anda memorable dan eco-friendly.',
                'tags' => ['trend 2024', 'dekorasi minimalis', 'sustainable wedding', 'wedding decor'],
                'seo_keywords' => ['trend dekorasi pernikahan 2024', 'wedding minimalis', 'sustainable wedding indonesia'],
                'read_time' => 6,
                'is_published' => true,
                'is_featured' => true,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(5),
            ],
            [
                'title' => 'Panduan Lengkap Memilih Wedding Photographer yang Tepat',
                'featured_image' => 'https://images.unsplash.com/photo-1606216794074-735e91aa2c92?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'excerpt' => 'Tips memilih wedding photographer yang sesuai dengan style dan budget Anda. Pelajari hal-hal penting yang harus diperhatikan sebelum booking photographer pernikahan.',
                'content' => '<h2>Mengapa Wedding Photography Begitu Penting?</h2>
                <p>Fotografi pernikahan bukan sekadar dokumentasi, melainkan investasi untuk kenangan seumur hidup. Foto dan video pernikahan akan menjadi warisan yang akan Anda tunjukkan kepada anak cucu.</p>
                
                <h3>Tentukan Style Photography Anda</h3>
                <p>Setiap photographer memiliki style yang berbeda:</p>
                <ul>
                <li><strong>Classic/Traditional:</strong> Pose formal dan komposisi tradisional</li>
                <li><strong>Photojournalistic:</strong> Candid, natural, storytelling</li>
                <li><strong>Fine Art:</strong> Artistic, dramatic, dengan komposisi unik</li>
                <li><strong>Vintage:</strong> Warm tone, nostalgic feel</li>
                </ul>
                
                <h3>Budget vs Quality</h3>
                <p>Jangan hanya fokus pada harga termurah. Pertimbangkan:</p>
                <ul>
                <li>Portfolio dan konsistensi hasil</li>
                <li>Package yang ditawarkan</li>
                <li>Jam kerja dan coverage</li>
                <li>Post-processing dan delivery time</li>
                </ul>
                
                <h2>Questions to Ask Your Potential Photographer</h2>
                <p>Siapkan pertanyaan penting seperti backup plan, hak cipta foto, dan timeline pengerjaan sebelum meeting dengan photographer.</p>',
                'meta_title' => 'Panduan Memilih Wedding Photographer Terbaik - Tips & Checklist',
                'meta_description' => 'Panduan lengkap memilih wedding photographer yang tepat. Tips, checklist, dan pertanyaan penting sebelum booking photographer pernikahan Anda.',
                'tags' => ['wedding photography', 'tips memilih photographer', 'photography tips', 'wedding planning'],
                'seo_keywords' => ['wedding photographer indonesia', 'tips pilih photographer', 'photography pernikahan'],
                'read_time' => 10,
                'is_published' => true,
                'is_featured' => false,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(7),
            ],
            [
                'title' => 'Digital Wedding Invitation: Trend Modern yang Ramah Lingkungan',
                'featured_image' => 'https://images.unsplash.com/photo-1586953208448-b95a79798f07?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'excerpt' => 'Era digital mengubah cara kita mengundang tamu pernikahan. Pelajari keuntungan digital invitation dan bagaimana membuatnya menarik dan berkesan.',
                'content' => '<h2>Mengapa Digital Invitation Semakin Populer?</h2>
                <p>Digital wedding invitation bukan hanya tentang mengikuti trend teknologi, melainkan solusi praktis yang memberikan banyak keuntungan bagi pasangan modern.</p>
                
                <h3>Keuntungan Digital Invitation</h3>
                <ul>
                <li><strong>Ramah Lingkungan:</strong> Mengurangi penggunaan kertas</li>
                <li><strong>Cost Effective:</strong> Hemat budget printing dan distribusi</li>
                <li><strong>Instant Delivery:</strong> Sampai ke tamu dalam hitungan detik</li>
                <li><strong>Easy RSVP:</strong> Tamu bisa konfirmasi kehadiran langsung</li>
                <li><strong>Multimedia:</strong> Bisa include video, musik, dan animasi</li>
                </ul>
                
                <h3>Desain yang Menarik</h3>
                <p>Digital invitation memberikan kebebasan kreativitas yang tidak terbatas:</p>
                <ul>
                <li>Animasi dan transisi yang smooth</li>
                <li>Background music yang personal</li>
                <li>Video pre-wedding teaser</li>
                <li>Interactive elements</li>
                </ul>
                
                <h2>Best Practices untuk Digital Invitation</h2>
                <p>Meskipun digital, tetap perhatikan etika dan formalitas dalam wedding invitation. Pastikan desain tetap elegant dan informasi lengkap.</p>',
                'meta_title' => 'Digital Wedding Invitation - Trend Modern & Ramah Lingkungan',
                'meta_description' => 'Pelajari keuntungan digital wedding invitation dan tips membuatnya menarik. Solusi modern yang cost-effective dan environmentally friendly.',
                'tags' => ['digital invitation', 'wedding technology', 'eco wedding', 'modern wedding'],
                'seo_keywords' => ['digital wedding invitation', 'undangan digital pernikahan', 'wedding technology'],
                'read_time' => 7,
                'is_published' => true,
                'is_featured' => false,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(10),
            ],
            [
                'title' => 'Venue Pernikahan Indoor vs Outdoor: Mana yang Tepat untuk Anda?',
                'featured_image' => 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'excerpt' => 'Bingung memilih venue indoor atau outdoor untuk pernikahan? Pelajari kelebihan dan kekurangan masing-masing serta faktor-faktor yang harus dipertimbangkan dalam memilih venue impian.',
                'content' => '<h2>Pertimbangan Utama Memilih Venue</h2>
                <p>Memilih venue adalah salah satu keputusan terpenting dalam perencanaan pernikahan. Venue tidak hanya menentukan suasana acara, tetapi juga mempengaruhi budget, jumlah tamu, dan konsep dekorasi secara keseluruhan.</p>
                
                <h3>Venue Indoor: Klasik dan Terkendali</h3>
                <p>Kelebihan venue indoor:</p>
                <ul>
                <li><strong>Weather Protection:</strong> Tidak tergantung cuaca</li>
                <li><strong>Controlled Environment:</strong> AC, lighting, dan audio terjamin</li>
                <li><strong>Privacy:</strong> Lebih private dan intimate</li>
                <li><strong>Flexible Timing:</strong> Bisa digunakan kapan saja</li>
                </ul>
                
                <h3>Venue Outdoor: Natural dan Romantic</h3>
                <p>Kelebihan venue outdoor:</p>
                <ul>
                <li><strong>Natural Beauty:</strong> Pemandangan alam yang menawan</li>
                <li><strong>Photo Opportunities:</strong> Background natural yang Instagram-worthy</li>
                <li><strong>Fresh Air:</strong> Suasana yang segar dan natural</li>
                <li><strong>Spacious:</strong> Umumnya lebih luas untuk tamu banyak</li>
                </ul>
                
                <h2>Faktor Budget dan Logistik</h2>
                <p>Venue outdoor mungkin memerlukan biaya tambahan untuk tenda, generator, toilet portable, sedangkan venue indoor sudah include fasilitas dasar. Pertimbangkan juga aksesibilitas untuk tamu elderly dan persiapan plan B jika cuaca tidak mendukung.</p>',
                'meta_title' => 'Venue Indoor vs Outdoor - Panduan Memilih Venue Pernikahan',
                'meta_description' => 'Panduan lengkap memilih venue pernikahan indoor vs outdoor. Kelebihan, kekurangan, dan tips memilih venue yang tepat untuk pernikahan impian Anda.',
                'tags' => ['venue pernikahan', 'indoor outdoor', 'wedding venue', 'tips venue'],
                'seo_keywords' => ['venue pernikahan indoor outdoor', 'tips pilih venue wedding', 'wedding venue indonesia'],
                'read_time' => 8,
                'is_published' => true,
                'is_featured' => false,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(15),
            ],
            [
                'title' => 'Wedding Catering: Panduan Menu dan Estimasi Budget',
                'featured_image' => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'excerpt' => 'Perencanaan catering pernikahan yang tepat bisa menghemat budget hingga 40%. Pelajari tips memilih menu, vendor catering, dan strategi negosiasi harga terbaik.',
                'content' => '<h2>Catering: 30-40% dari Total Budget Wedding</h2>
                <p>Catering biasanya mengambil porsi terbesar dari budget pernikahan. Dengan perencanaan yang matang, Anda bisa mendapatkan menu berkualitas tanpa overspending.</p>
                
                <h3>Jenis Package Catering</h3>
                <ul>
                <li><strong>Buffet:</strong> Lebih ekonomis, variasi menu banyak</li>
                <li><strong>Plated Dinner:</strong> Lebih formal, presentasi elegant</li>
                <li><strong>Family Style:</strong> Intimate, cocok untuk acara kecil</li>
                <li><strong>Cocktail Style:</strong> Modern, finger food dan drinks</li>
                </ul>
                
                <h3>Menu Planning Strategy</h3>
                <p>Pertimbangkan waktu acara, demografi tamu, dan dietary restrictions. Menu siang berbeda dengan menu malam. Sediakan opsi vegetarian dan halal food.</p>
                
                <h2>Tips Negosiasi dengan Vendor Catering</h2>
                <ul>
                <li>Bandingkan minimal 3-5 vendor</li>
                <li>Tasting session untuk ensure quality</li>
                <li>Nego untuk complimentary items</li>
                <li>Perhatikan hidden cost (service charge, tax)</li>
                <li>Contract clear tentang menu substitution</li>
                </ul>
                
                <h3>Budget Saving Tips</h3>
                <p>Pilih menu seasonal, kurangi item premium yang tidak essential, dan pertimbangkan hybrid catering (sebagian DIY untuk dessert atau welcome drink).</p>',
                'meta_title' => 'Wedding Catering Guide - Menu Planning & Budget Tips',
                'meta_description' => 'Panduan lengkap wedding catering: tips memilih menu, vendor catering terbaik, dan strategi hemat budget hingga 40% tanpa mengurangi kualitas.',
                'tags' => ['wedding catering', 'menu pernikahan', 'budget catering', 'wedding food'],
                'seo_keywords' => ['catering pernikahan murah', 'tips wedding catering', 'menu pernikahan budget'],
                'read_time' => 9,
                'is_published' => true,
                'is_featured' => true,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(18),
            ],
            [
                'title' => 'Tradisi Pernikahan Adat Indonesia yang Wajib Dilestarikan',
                'featured_image' => 'https://images.unsplash.com/photo-1583939003579-730e3918a45a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'excerpt' => 'Indonesia kaya akan tradisi pernikahan yang unik dan bermakna. Kenali berbagai tradisi adat dari Sabang sampai Merauke yang bisa diintegrasikan dalam pernikahan modern.',
                'content' => '<h2>Kekayaan Tradisi Pernikahan Nusantara</h2>
                <p>Indonesia memiliki lebih dari 300 suku dengan tradisi pernikahan yang unik. Mengintegrasikan tradisi adat dalam pernikahan modern bukan hanya melestarikan budaya, tetapi juga memberikan makna spiritual yang mendalam.</p>
                
                <h3>Tradisi Jawa: Siraman dan Midodareni</h3>
                <p>Siraman adalah ritual pembersihan diri sebelum pernikahan, dilakukan oleh 7 orang yang dituakan. Midodareni adalah malam terakhir sebelum akad, simbolisasi persiapan mental dan spiritual calon pengantin.</p>
                
                <h3>Tradisi Sunda: Sungkeman dan Sawer</h3>
                <p>Sungkeman adalah permintaan restu kepada orangtua, sedangkan sawer adalah tradisi melempar beras kuning, permen, dan uang receh sebagai simbol kemakmuran.</p>
                
                <h3>Tradisi Batak: Ulos dan Gondang</h3>
                <p>Ulos adalah kain tradisional yang diberikan sebagai berkah, sementara Gondang adalah musik tradisional yang mengiringi upacara adat Batak.</p>
                
                <h2>Integrasi Tradisi dalam Pernikahan Modern</h2>
                <p>Anda bisa mengadaptasi tradisi adat tanpa harus full traditional. Misalnya, menggunakan busana adat hanya untuk sesi foto, atau incorporate musik tradisional dalam resepsi modern.</p>
                
                <h3>Tips Menggabungkan Tradisi dan Modern</h3>
                <ul>
                <li>Konsultasi dengan tetua adat</li>
                <li>Pilih tradisi yang paling meaningful</li>
                <li>Explain significance kepada tamu non-adat</li>
                <li>Dokumentasi dengan baik untuk kenangan</li>
                </ul>',
                'meta_title' => 'Tradisi Pernikahan Adat Indonesia - Warisan Budaya Nusantara',
                'meta_description' => 'Jelajahi kekayaan tradisi pernikahan adat Indonesia dari berbagai suku. Tips mengintegrasikan tradisi dalam pernikahan modern yang meaningful.',
                'tags' => ['tradisi pernikahan', 'adat indonesia', 'pernikahan tradisional', 'budaya nusantara'],
                'seo_keywords' => ['tradisi pernikahan indonesia', 'adat pernikahan nusantara', 'pernikahan tradisional modern'],
                'read_time' => 11,
                'is_published' => true,
                'is_featured' => false,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(20),
            ],
            [
                'title' => 'Honeymoon Planning: Destinasi Romantis dalam dan luar Negeri',
                'featured_image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'excerpt' => 'Honeymoon adalah momen special untuk memulai kehidupan baru. Temukan destinasi honeymoon romantis, tips budget travel, dan panduan planning honeymoon yang memorable.',
                'content' => '<h2>Honeymoon: The Perfect Start</h2>
                <p>Honeymoon bukan sekadar liburan, melainkan quality time untuk memulai kehidupan pernikahan dengan romantic memories yang akan dikenang seumur hidup.</p>
                
                <h3>Destinasi Honeymoon Domestik</h3>
                <p>Indonesia memiliki banyak destinasi romantis yang tidak kalah dengan luar negeri:</p>
                <ul>
                <li><strong>Bali:</strong> Ubud untuk nature lovers, Seminyak untuk beach vibes</li>
                <li><strong>Yogyakarta:</strong> Culture, history, dan romantic ambiance</li>
                <li><strong>Raja Ampat:</strong> Underwater paradise untuk adventurous couple</li>
                <li><strong>Flores:</strong> Pink beach dan komodo, unique experience</li>
                <li><strong>Belitung:</strong> White sand beaches yang Instagram-worthy</li>
                </ul>
                
                <h3>Destinasi Honeymoon Internasional</h3>
                <ul>
                <li><strong>Maldives:</strong> Overwater villa, crystal clear water</li>
                <li><strong>Santorini:</strong> Sunset views dan Greek architecture</li>
                <li><strong>Paris:</strong> City of love dengan romantic atmosphere</li>
                <li><strong>Kyoto:</strong> Traditional Japanese culture dan cherry blossom</li>
                <li><strong>Tuscany:</strong> Wine country dengan rolling hills</li>
                </ul>
                
                <h2>Honeymoon Budget Planning</h2>
                <p>Alokasikan 10-15% dari total wedding budget untuk honeymoon. Book early untuk dapatkan early bird discount, dan consider shoulder season untuk harga lebih murah.</p>
                
                <h3>Honeymoon Planning Timeline</h3>
                <ul>
                <li><strong>6 bulan sebelum:</strong> Research destinasi dan book flights</li>
                <li><strong>3-4 bulan:</strong> Book accommodation dan activities</li>
                <li><strong>1 bulan:</strong> Finalize itinerary dan prepare documents</li>
                </ul>',
                'meta_title' => 'Honeymoon Planning Guide - Destinasi Romantis & Budget Tips',
                'meta_description' => 'Panduan lengkap honeymoon planning: destinasi romantis dalam & luar negeri, tips budget travel, dan timeline persiapan honeymoon yang sempurna.',
                'tags' => ['honeymoon planning', 'destinasi romantis', 'honeymoon budget', 'travel tips'],
                'seo_keywords' => ['honeymoon indonesia', 'destinasi honeymoon romantis', 'honeymoon planning tips'],
                'read_time' => 10,
                'is_published' => true,
                'is_featured' => false,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(25),
            ],
            [
                'title' => 'Wedding Entertainment: Musik, MC, dan Hiburan yang Memorable',
                'featured_image' => 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'excerpt' => 'Entertainment yang tepat bisa membuat wedding reception unforgettable. Pelajari tips memilih MC, band, DJ, dan konsep hiburan yang sesuai dengan personality dan budget Anda.',
                'content' => '<h2>Entertainment: Soul of the Party</h2>
                <p>Wedding entertainment menentukan mood dan energy sepanjang resepsi. Investment yang tepat untuk entertainment akan menciptakan memorable moments untuk semua tamu.</p>
                
                <h3>Master of Ceremony (MC)</h3>
                <p>MC yang baik bisa make or break your reception:</p>
                <ul>
                <li><strong>Professional MC:</strong> Experienced, tahu flow acara, good public speaking</li>
                <li><strong>Friend/Family MC:</strong> Personal touch, tahu couple dengan baik</li>
                <li><strong>Bilingual MC:</strong> Penting jika ada tamu internasional</li>
                </ul>
                
                <h3>Musik dan Performance</h3>
                <p>Pilihan entertainment music:</p>
                <ul>
                <li><strong>Live Band:</strong> Interactive, energetic, bisa request lagu</li>
                <li><strong>DJ:</strong> Variety musik luas, bisa mix dan remix</li>
                <li><strong>Acoustic Duo:</strong> Intimate, cocok untuk garden party</li>
                <li><strong>Traditional Performers:</strong> Gamelan, angklung untuk cultural touch</li>
                </ul>
                
                <h2>Interactive Entertainment Ideas</h2>
                <ul>
                <li>Photo booth dengan props unik</li>
                <li>Live painting atau live sketch artist</li>
                <li>Magic show atau mentalist</li>
                <li>Dance floor games dan couple quiz</li>
                <li>Surprise flash mob dari wedding party</li>
                </ul>
                
                <h3>Budget Allocation untuk Entertainment</h3>
                <p>Alokasikan 8-12% dari total budget untuk entertainment. Prioritaskan MC dan musik utama, kemudian tambahkan extra entertainment sesuai remaining budget.</p>
                
                <h2>Timeline dan Koordinasi</h2>
                <p>Brief entertainment team tentang running order, special moments, dan song requests. Pastikan soundcheck dilakukan sebelum tamu datang.</p>',
                'meta_title' => 'Wedding Entertainment Guide - MC, Musik & Hiburan Memorable',
                'meta_description' => 'Tips memilih wedding entertainment yang tepat: MC profesional, band/DJ terbaik, dan konsep hiburan unik yang membuat resepsi unforgettable.',
                'tags' => ['wedding entertainment', 'wedding MC', 'wedding music', 'reception entertainment'],
                'seo_keywords' => ['wedding entertainment indonesia', 'MC pernikahan', 'hiburan wedding'],
                'read_time' => 9,
                'is_published' => true,
                'is_featured' => false,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(30),
            ],
            [
                'title' => 'Post-Wedding: Mengawali Kehidupan Pernikahan yang Bahagia',
                'featured_image' => 'https://images.unsplash.com/photo-1522673607200-164d1b6ce486?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'excerpt' => 'Setelah euphoria wedding day, saatnya fokus pada kehidupan pernikahan yang sesungguhnya. Tips komunikasi, finansial planning, dan membangun keluarga yang harmonis.',
                'content' => '<h2>From Wedding Day to Married Life</h2>
                <p>Wedding day hanya satu hari, tapi pernikahan adalah seumur hidup. Transisi dari planning wedding ke building marriage memerlukan mindset dan strategy yang berbeda.</p>
                
                <h3>Post-Wedding Blues: Normal dan Temporary</h3>
                <p>Merasa empty atau sad setelah wedding adalah normal. Setelah berbulan-bulan planning dan excitement, tiba-tiba semuanya selesai. Tips mengatasinya:</p>
                <ul>
                <li>Focus pada honeymoon dan quality time bersama</li>
                <li>Mulai hobi atau project baru bersama</li>
                <li>Express gratitude untuk support dari family dan friends</li>
                <li>Plan regular date nights untuk maintain romance</li>
                </ul>
                
                <h3>Financial Planning sebagai Married Couple</h3>
                <p>Merge finances atau tetap separate? Tidak ada right or wrong, yang penting transparansi:</p>
                <ul>
                <li><strong>Joint Account:</strong> Untuk shared expenses (household, savings)</li>
                <li><strong>Individual Account:</strong> Untuk personal spending</li>
                <li><strong>Emergency Fund:</strong> 6-12 bulan living expenses</li>
                <li><strong>Investment Planning:</strong> House, children education, retirement</li>
                </ul>
                
                <h2>Communication: Foundation of Strong Marriage</h2>
                <p>Wedding planning mungkin stressful, tapi real life marriage challenges lebih complex. Develop healthy communication patterns:</p>
                <ul>
                <li>Weekly check-ins tentang feelings dan concerns</li>
                <li>Learn each other love languages</li>
                <li>Conflict resolution skills</li>
                <li>Appreciate small gestures daily</li>
                </ul>
                
                <h3>Building Traditions dan Memories</h3>
                <p>Create your own couple traditions: anniversary celebration style, holiday traditions, atau monthly adventure bersama. Document journey pernikahan Anda through photos, journal, atau video.</p>',
                'meta_title' => 'Post-Wedding Guide - Membangun Kehidupan Pernikahan Bahagia',
                'meta_description' => 'Panduan lengkap post-wedding: mengatasi post-wedding blues, financial planning married couple, dan tips membangun pernikahan yang harmonis dan bahagia.',
                'tags' => ['post wedding', 'married life', 'marriage tips', 'newlywed advice'],
                'seo_keywords' => ['kehidupan setelah menikah', 'tips pernikahan bahagia', 'married life indonesia'],
                'read_time' => 12,
                'is_published' => true,
                'is_featured' => false,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(35),
            ],
        ];

        foreach ($blogs as $blogData) {
            // Assign random category and author
            $category = $categories->random();
            $author = $authors->random();
            
            // Ensure slug is properly formatted
            $blogData['slug'] = Str::slug($blogData['title']);
            $blogData['blog_category_id'] = $category->id;
            $blogData['author_id'] = $author->id;
            
            // Calculate engagement metrics
            $blogData['views_count'] = rand(150, 2500);
            $blogData['likes_count'] = rand(10, 150);
            $blogData['comments_count'] = rand(2, 25);
            $blogData['engagement_score'] = round(
                ($blogData['likes_count'] + $blogData['comments_count'] * 2) / 
                max($blogData['views_count'], 1) * 100, 2
            );
            
            Blog::create($blogData);
            
            $this->command->info("✅ Created blog: {$blogData['title']}");
        }

        $this->command->info('🎉 Successfully seeded ' . count($blogs) . ' blog posts!');
        $this->command->info('📊 All blogs have realistic engagement metrics and are published.');
        $this->command->info('🏷️ Blogs are randomly assigned to categories and authors.');
    }
}
