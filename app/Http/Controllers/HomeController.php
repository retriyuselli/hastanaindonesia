<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Portfolio;

class HomeController extends Controller
{
    /**
     * Display the homepage
     */
    public function index()
    {
        // Get featured portfolios
        $featuredPortfolios = Portfolio::featured()
            ->with('weddingOrganizer')
            ->limit(4)
            ->get();

        // Data dummy untuk demo - nanti bisa diganti dengan data dari database
        $data = [
            'featured_members' => [
                [
                    'name' => 'Elegant Wedding Organizer',
                    'location' => 'Jakarta Selatan',
                    'membership' => 'Premium Member',
                    'rating' => 5,
                    'icon' => 'crown',
                    'color' => 'blue'
                ],
                [
                    'name' => 'Bali Dream Wedding',
                    'location' => 'Bali',
                    'membership' => 'Gold Member',
                    'rating' => 5,
                    'icon' => 'heart',
                    'color' => 'red'
                ],
                [
                    'name' => 'Surabaya Modern Wedding',
                    'location' => 'Surabaya',
                    'membership' => 'Silver Member',
                    'rating' => 4,
                    'icon' => 'gem',
                    'color' => 'purple'
                ],
                [
                    'name' => 'Yogya Traditional Event',
                    'location' => 'Yogyakarta',
                    'membership' => 'Silver Member',
                    'rating' => 4,
                    'icon' => 'leaf',
                    'color' => 'green'
                ]
            ],
            'upcoming_events' => [
                [
                    'title' => 'Workshop Fotografi Pernikahan Modern',
                    'date' => '25 Agustus 2025',
                    'location' => 'Jakarta',
                    'description' => 'Pelatihan intensif fotografi pernikahan dengan teknik modern dan equipment terbaru. Dipandu oleh fotografer profesional dengan pengalaman internasional.',
                    'type' => 'workshop',
                    'color' => 'blue'
                ],
                [
                    'title' => 'HASTANA Annual Networking Gala',
                    'date' => '2 September 2025',
                    'location' => 'Bali',
                    'description' => 'Acara networking tahunan HASTANA yang mempertemukan wedding organizer dari seluruh Indonesia. Kesempatan emas untuk membangun relasi profesional.',
                    'type' => 'networking',
                    'color' => 'red'
                ]
            ],
            'latest_articles' => [
                [
                    'title' => 'Tren Pernikahan 2025: Sustainable Wedding',
                    'date' => '15 Agustus 2025',
                    'excerpt' => 'Eksplorasi tren pernikahan ramah lingkungan yang semakin populer di kalangan milenial Indonesia...',
                    'color' => 'pink'
                ],
                [
                    'title' => 'Tips Manajemen Budget Wedding yang Efektif',
                    'date' => '12 Agustus 2025',
                    'excerpt' => 'Strategi jitu untuk wedding organizer dalam membantu klien mengelola budget pernikahan...',
                    'color' => 'indigo'
                ],
                [
                    'title' => 'Digital Marketing untuk Wedding Organizer',
                    'date' => '10 Agustus 2025',
                    'excerpt' => 'Panduan lengkap memanfaatkan media sosial dan digital marketing untuk bisnis wedding organizer...',
                    'color' => 'emerald'
                ]
            ]
        ];

        return view('front.home', compact('data', 'featuredPortfolios'));
    }
}
