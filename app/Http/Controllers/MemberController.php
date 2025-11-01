<?php

namespace App\Http\Controllers;

use App\Models\WeddingOrganizer;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    /**
     * Display a listing of wedding organizer members
     */
    public function index(Request $request)
    {
        $query = WeddingOrganizer::with(['region', 'user'])
            ->verified()
            ->active();

        // Filter by region
        if ($request->filled('region')) {
            $query->where('region_id', $request->region);
        }

        // Filter by province
        if ($request->filled('province')) {
            $query->where('province', $request->province);
        }

        // Filter by city
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        // Filter by certification level
        if ($request->filled('certification')) {
            $query->where('certification_level', $request->certification);
        }

        // Search by name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('organizer_name', 'like', "%{$search}%")
                  ->orWhere('brand_name', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        // Sort options
        $sort = $request->get('sort', 'name');
        switch ($sort) {
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'events':
                $query->orderBy('completed_events', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('organizer_name', 'asc');
        }

        // Get featured members separately
        $featuredMembers = WeddingOrganizer::with(['region', 'user'])
            ->verified()
            ->active()
            ->featured()
            ->inRandomOrder()
            ->limit(3)
            ->get();

        // Paginate results
        $members = $query->paginate(12);

        // Get filter options
        $regions = Region::orderBy('region_name')->get();
        $provinces = config('indonesia.provinces', []);
        $certificationLevels = config('indonesia.certification_levels', []);

        return view('front.members', compact(
            'members',
            'featuredMembers',
            'regions',
            'provinces',
            'certificationLevels'
        ));
    }

    /**
     * Display the specified wedding organizer member
     */
    public function show($slug)
    {
        $member = WeddingOrganizer::with(['region', 'user', 'verifier', 'activeProducts'])
            ->where('slug', $slug)
            ->verified()
            ->active()
            ->firstOrFail();

        // Get related members from same region
        $relatedMembers = WeddingOrganizer::with(['region'])
            ->where('region_id', $member->region_id)
            ->where('id', '!=', $member->id)
            ->verified()
            ->active()
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('front.member-detail', compact('member', 'relatedMembers'));
    }

    /**
     * Display product detail page
     */
    public function showProduct($slug, $productId)
    {
        $member = WeddingOrganizer::with(['region', 'user'])
            ->where('slug', $slug)
            ->verified()
            ->active()
            ->firstOrFail();

        // Get product from database
        $productModel = \App\Models\Product::where('id', $productId)
            ->where('wedding_organizer_id', $member->id)
            ->where('is_active', true)
            ->firstOrFail();

        // Process images to use storage URL
        $images = $productModel->images;
        if (!empty($images) && is_array($images)) {
            $images = array_map(function($image) {
                // If image is already a full URL, return as is
                if (str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) {
                    return $image;
                }
                // Convert to storage URL and check if file exists
                $storagePath = storage_path('app/public/' . $image);
                if (file_exists($storagePath)) {
                    return Storage::url($image);
                }
                // Return placeholder if file doesn't exist
                return 'https://images.unsplash.com/photo-1519741497674-611481863552?w=800&h=800&fit=crop';
            }, $images);
        } else {
            // Default fallback image
            $images = [
                'https://images.unsplash.com/photo-1519741497674-611481863552?w=800&h=800&fit=crop',
            ];
        }

        // Convert to array format for the view
        $product = [
            'id' => $productModel->id,
            'name' => $productModel->name,
            'description' => $productModel->description,
            'original_price' => $productModel->original_price,
            'price' => $productModel->price,
            'discount' => $productModel->discount,
            'images' => $images,
            'features' => $productModel->features ?? [],
            'badges' => $productModel->badges ?? [],
            'limited_offer' => $productModel->limited_offer,
        ];

        // Get related members (same region or random)
        $relatedMembers = WeddingOrganizer::with(['region'])
            ->where('id', '!=', $member->id)
            ->verified()
            ->active()
            ->when($member->region_id, function($query) use ($member) {
                $query->where('region_id', $member->region_id);
            })
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('front.product-detail', compact('member', 'product', 'relatedMembers'));
    }
}
