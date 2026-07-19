<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    public function dpp(): View
    {
        $dpp = Company::with([
            'ownerUser',
            'sekretarisUmum',
            'bendaharaUmum',
            'bidOrganisasi',
            'bidPengembangan',
            'bidHumas1',
            'bidHumas2',
            'bidSosial',
            'bidBisnis',
            'bidHukum',
        ])->first();

        return view('front.dpp', compact('dpp'));
    }
}
