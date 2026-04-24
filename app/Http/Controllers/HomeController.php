<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\EventHastana;
use App\Models\Portfolio;
use App\Models\Product;
use App\Models\Region;
use App\Models\WeddingOrganizer;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Display the homepage
     */
    public function index()
    {
        // Get featured portfolios
        $featuredPortfolios = Cache::remember('home:featured_portfolios', now()->addMinutes(10), function () {
            return Portfolio::featured()
                ->with('weddingOrganizer')
                ->limit(4)
                ->get();
        });

        // Get featured wedding organizers (verified and active)
        $featuredWeddingOrganizers = Cache::remember('home:featured_wedding_organizers', now()->addMinutes(10), function () {
            return WeddingOrganizer::query()
                ->verified()
                ->active()
                ->with(['region', 'user'])
                ->inRandomOrder()
                ->limit(10)
                ->get();
        });

        // Get featured products with their wedding organizer
        $featuredProducts = Cache::remember('home:featured_products', now()->addMinutes(10), function () {
            return Product::query()
                ->active()
                ->with(['weddingOrganizer.region'])
                ->inRandomOrder()
                ->limit(10)
                ->get();
        });

        $totalWeddingOrganizers = Cache::remember('home:total_wedding_organizers_with_name', now()->addMinutes(30), function () {
            return WeddingOrganizer::query()
                ->whereNotNull('organizer_name')
                ->where('organizer_name', '!=', '')
                ->count();
        });

        $totalRegions = Cache::remember('home:total_regions', now()->addMinutes(30), function () {
            return Region::query()->count();
        });

        // Get upcoming events (active and future events)
        $upcomingEvents = Cache::remember('home:upcoming_events', now()->addMinutes(5), function () {
            return EventHastana::query()
                ->active()
                ->published()
                ->where('start_date', '>=', now())
                ->with('eventCategory')
                ->orderBy('start_date', 'asc')
                ->limit(4)
                ->get();
        });

        // Get latest blog articles (featured or latest published)
        $latestBlogs = Cache::remember('home:latest_blogs', now()->addMinutes(5), function () {
            return Blog::query()
                ->where('status', 'published')
                ->published()
                ->with(['category', 'author'])
                ->orderBy('published_at', 'desc')
                ->limit(3)
                ->get();
        });

        // Data dummy untuk demo - nanti bisa diganti dengan data dari database
        $data = [
            'featured_members' => [
                [
                    'name' => 'Elegant Wedding Organizer',
                    'location' => 'Jakarta Selatan',
                    'membership' => 'Premium Member',
                    'rating' => 5,
                    'icon' => 'crown',
                    'color' => 'blue',
                ],
                [
                    'name' => 'Bali Dream Wedding',
                    'location' => 'Bali',
                    'membership' => 'Gold Member',
                    'rating' => 5,
                    'icon' => 'heart',
                    'color' => 'red',
                ],
                [
                    'name' => 'Surabaya Modern Wedding',
                    'location' => 'Surabaya',
                    'membership' => 'Silver Member',
                    'rating' => 4,
                    'icon' => 'gem',
                    'color' => 'purple',
                ],
                [
                    'name' => 'Yogya Traditional Event',
                    'location' => 'Yogyakarta',
                    'membership' => 'Silver Member',
                    'rating' => 4,
                    'icon' => 'leaf',
                    'color' => 'green',
                ],
            ],
            'upcoming_events' => [
                [
                    'title' => 'Workshop Fotografi Pernikahan Modern',
                    'date' => '25 Agustus 2025',
                    'location' => 'Jakarta',
                    'description' => 'Pelatihan intensif fotografi pernikahan dengan teknik modern dan equipment terbaru. Dipandu oleh fotografer profesional dengan pengalaman internasional.',
                    'type' => 'workshop',
                    'color' => 'blue',
                ],
                [
                    'title' => 'HASTANA Annual Networking Gala',
                    'date' => '2 September 2025',
                    'location' => 'Bali',
                    'description' => 'Acara networking tahunan HASTANA yang mempertemukan wedding organizer dari seluruh Indonesia. Kesempatan emas untuk membangun relasi profesional.',
                    'type' => 'networking',
                    'color' => 'red',
                ],
            ],
            'latest_articles' => [
                [
                    'title' => 'Tren Pernikahan 2025: Sustainable Wedding',
                    'date' => '15 Agustus 2025',
                    'excerpt' => 'Eksplorasi tren pernikahan ramah lingkungan yang semakin populer di kalangan milenial Indonesia...',
                    'color' => 'pink',
                ],
                [
                    'title' => 'Tips Manajemen Budget Wedding yang Efektif',
                    'date' => '12 Agustus 2025',
                    'excerpt' => 'Strategi jitu untuk wedding organizer dalam membantu klien mengelola budget pernikahan...',
                    'color' => 'indigo',
                ],
                [
                    'title' => 'Digital Marketing untuk Wedding Organizer',
                    'date' => '10 Agustus 2025',
                    'excerpt' => 'Panduan lengkap memanfaatkan media sosial dan digital marketing untuk bisnis wedding organizer...',
                    'color' => 'emerald',
                ],
            ],
        ];

        return view('front.home.modern', compact('data', 'featuredPortfolios', 'featuredWeddingOrganizers', 'featuredProducts', 'totalWeddingOrganizers', 'totalRegions', 'upcomingEvents', 'latestBlogs'));
    }
}
