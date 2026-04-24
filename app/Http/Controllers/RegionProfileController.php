<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\WeddingOrganizer;
use Illuminate\Http\Request;

class RegionProfileController extends Controller
{
    public function index(Request $request)
    {
        $query = Region::query()
            ->orderBy('region_name');

        if ($request->filled('active')) {
            $query->where('is_active', filter_var($request->input('active'), FILTER_VALIDATE_BOOL));
        } else {
            $query->where('is_active', true);
        }

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();
            $query->where(function ($q) use ($search) {
                $q->where('region_name', 'like', "%{$search}%")
                    ->orWhere('dpc_name', 'like', "%{$search}%")
                    ->orWhere('province', 'like', "%{$search}%");
            });
        }

        if ($request->filled('province')) {
            $query->where('province', $request->string('province')->toString());
        }

        $regions = $query->paginate(12)->withQueryString();

        $provinces = Region::query()
            ->where('is_active', true)
            ->whereNotNull('province')
            ->distinct()
            ->orderBy('province')
            ->pluck('province');

        return view('front.regions.index', compact('regions', 'provinces'));
    }

    public function show(Region $region)
    {
        $region->load(['ketuaDpw', 'wkKetuaDpw', 'wkKetua2Dpw', 'sekretarisDpw', 'bendaharaDpw']);

        $members = WeddingOrganizer::query()
            ->with(['user'])
            ->where('region_id', $region->id)
            ->verified()
            ->active()
            ->orderBy('organizer_name')
            ->paginate(12)
            ->withQueryString();

        return view('front.regions.show', compact('region', 'members'));
    }
}
