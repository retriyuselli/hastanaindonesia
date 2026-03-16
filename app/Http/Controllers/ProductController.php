<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\WeddingOrganizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected function canManageWeddingOrganizerProducts(WeddingOrganizer $weddingOrganizer): bool
    {
        if ($weddingOrganizer->user_id === Auth::id()) {
            return true;
        }

        $user = Auth::user();

        if (! $user instanceof User) {
            return false;
        }

        $superAdminRole = config('filament-shield.super_admin.name', 'super_admin');

        return $user->hasRole($superAdminRole);
    }

    /**
     * Display a listing of products for the authenticated user's wedding organizer
     */
    public function index($slug)
    {
        $weddingOrganizer = WeddingOrganizer::where('slug', $slug)->firstOrFail();

        // Verify ownership
        if (! $this->canManageWeddingOrganizerProducts($weddingOrganizer)) {
            abort(403, 'Unauthorized access.');
        }

        $products = Product::where('wedding_organizer_id', $weddingOrganizer->id)
            ->latest()
            ->get();

        return view('products.index', compact('weddingOrganizer', 'products'));
    }

    /**
     * Show the form for creating a new product
     */
    public function create($slug)
    {
        $weddingOrganizer = WeddingOrganizer::where('slug', $slug)->firstOrFail();

        // Verify ownership
        if (! $this->canManageWeddingOrganizerProducts($weddingOrganizer)) {
            abort(403, 'Unauthorized access.');
        }

        return view('products.create', compact('weddingOrganizer'));
    }

    /**
     * Store a newly created product in storage
     */
    public function store(Request $request, $slug)
    {
        $weddingOrganizer = WeddingOrganizer::where('slug', $slug)->firstOrFail();

        // Verify ownership
        if (! $this->canManageWeddingOrganizerProducts($weddingOrganizer)) {
            abort(403, 'Unauthorized access.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'features' => 'nullable|string',
            'original_price' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'limited_offer' => 'boolean',
            'badges' => 'nullable|string',
            'images.*' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
            'is_active' => 'boolean',
        ]);

        // Handle badges as comma-separated string
        if ($request->filled('badges')) {
            $validated['badges'] = array_map('trim', explode(',', $request->badges));
        }

        if ($request->filled('features')) {
            $validated['features'] = array_values(array_filter(
                array_map('trim', preg_split("/\r\n|\r|\n/", $request->features) ?: []),
                fn (string $value): bool => $value !== ''
            ));
        }

        // Handle multiple images upload
        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('products', 'public');
            }
            $validated['images'] = $imagePaths;
        }

        $validated['wedding_organizer_id'] = $weddingOrganizer->id;
        $validated['limited_offer'] = $request->has('limited_offer');
        $validated['is_active'] = $request->has('is_active') ? true : false;

        Product::create($validated);

        return redirect()->route('products.manage', $slug)
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified product
     */
    public function edit($slug, $id)
    {
        $weddingOrganizer = WeddingOrganizer::where('slug', $slug)->firstOrFail();

        // Verify ownership
        if (! $this->canManageWeddingOrganizerProducts($weddingOrganizer)) {
            abort(403, 'Unauthorized access.');
        }

        $product = Product::where('wedding_organizer_id', $weddingOrganizer->id)
            ->findOrFail($id);

        return view('products.edit', compact('weddingOrganizer', 'product'));
    }

    /**
     * Update the specified product in storage
     */
    public function update(Request $request, $slug, $id)
    {
        $weddingOrganizer = WeddingOrganizer::where('slug', $slug)->firstOrFail();

        // Verify ownership
        if (! $this->canManageWeddingOrganizerProducts($weddingOrganizer)) {
            abort(403, 'Unauthorized access.');
        }

        $product = Product::where('wedding_organizer_id', $weddingOrganizer->id)
            ->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'features' => 'nullable|string',
            'original_price' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'limited_offer' => 'boolean',
            'badges' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'existing_images' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        // Handle badges as comma-separated string
        if ($request->filled('badges')) {
            $validated['badges'] = array_map('trim', explode(',', $request->badges));
        }

        if ($request->filled('features')) {
            $validated['features'] = array_values(array_filter(
                array_map('trim', preg_split("/\r\n|\r|\n/", $request->features) ?: []),
                fn (string $value): bool => $value !== ''
            ));
        } else {
            $validated['features'] = [];
        }

        // Handle images: keep existing + add new
        $finalImages = [];

        // Keep existing images that weren't deleted
        if ($request->has('existing_images')) {
            $finalImages = $request->existing_images;
        }

        // Add new uploaded images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $finalImages[] = $image->store('products', 'public');
            }
        }

        // Delete images that are in database but not in existing_images (user deleted them)
        if ($product->images && is_array($product->images)) {
            $deletedImages = array_diff($product->images, $finalImages);
            foreach ($deletedImages as $deletedImage) {
                if (! str_starts_with($deletedImage, 'http') && Storage::disk('public')->exists($deletedImage)) {
                    Storage::disk('public')->delete($deletedImage);
                }
            }
        }

        $validated['images'] = $finalImages;
        $validated['limited_offer'] = $request->has('limited_offer');
        $validated['is_active'] = $request->has('is_active') ? true : false;

        $product->update($validated);

        return redirect()->route('products.manage', $slug)
            ->with('success', 'Produk berhasil diupdate!');
    }

    /**
     * Remove the specified product from storage
     */
    public function destroy($slug, $id)
    {
        $weddingOrganizer = WeddingOrganizer::where('slug', $slug)->firstOrFail();

        // Verify ownership
        if (! $this->canManageWeddingOrganizerProducts($weddingOrganizer)) {
            abort(403, 'Unauthorized access.');
        }

        $product = Product::where('wedding_organizer_id', $weddingOrganizer->id)
            ->findOrFail($id);

        // Delete image if exists
        if ($product->main_image && Storage::disk('public')->exists($product->main_image)) {
            Storage::disk('public')->delete($product->main_image);
        }

        $product->delete();

        return redirect()->route('products.manage', $slug)
            ->with('success', 'Produk berhasil dihapus!');
    }
}
