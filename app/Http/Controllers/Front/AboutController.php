<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use Illuminate\Http\Request;

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
        if (!$about) {
            $about = (object) [
                'history' => '<p>Halaman tentang kami sedang dalam pengembangan.</p>',
                'vision' => 'Visi kami sedang disusun.',
                'mission' => '<p>Misi kami sedang disusun.</p>',
                'values' => [],
                'programs' => [],
            ];
        }
        
        return view('front.about', compact('about'));
    }
}
