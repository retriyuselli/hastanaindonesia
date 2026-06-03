<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use App\Models\EventHastana;
use App\Models\Region;
use App\Models\WeddingOrganizer;

class AboutController extends Controller
{
    /**
     * Display the about page
     */
    public function index()
    {
        // Get active about page data
        $about = AboutPage::getActive();

        // If no data exists, create default message
        if (! $about) {
            $about = (object) [
                'history' => '<p>Halaman tentang kami sedang dalam pengembangan.</p>',
                'vision' => 'Visi kami sedang disusun.',
                'mission' => '<p>Misi kami sedang disusun.</p>',
                'values' => [],
                'programs' => [],
            ];
        }

        // Get statistics
        $totalMembers = WeddingOrganizer::count();
        $totalRegions = Region::count();
        $totalEvents = EventHastana::where('status', 'finished')->count();

        return view('front.about.index', compact('about', 'totalMembers', 'totalRegions', 'totalEvents'));
    }
}
