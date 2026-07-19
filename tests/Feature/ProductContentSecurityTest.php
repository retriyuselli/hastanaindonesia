<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use App\Models\WeddingOrganizer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProductContentSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_existing_images_must_be_a_subset_of_the_products_current_images(): void
    {
        [$user, $weddingOrganizer, $product] = $this->createProduct();

        $response = $this->actingAs($user)->put(
            route('products.update', [$weddingOrganizer->slug, $product->id]),
            $this->validPayload([
                'existing_images' => ["products/original.webp');alert(1);//"],
            ]),
        );

        $response->assertSessionHasErrors('existing_images');
        $this->assertSame(['products/original.webp'], $product->fresh()->images);
    }

    public function test_product_description_is_sanitized_before_storage(): void
    {
        [$user, $weddingOrganizer, $product] = $this->createProduct();

        $response = $this->actingAs($user)->put(
            route('products.update', [$weddingOrganizer->slug, $product->id]),
            $this->validPayload([
                'description' => '<script>alert(1)</script><p onclick="alert(2)">Aman <strong>tebal</strong></p>',
                'existing_images' => ['products/original.webp'],
            ]),
        );

        $response->assertSessionHasNoErrors();
        $description = $product->fresh()->description;
        $this->assertStringNotContainsString('<script', $description);
        $this->assertStringNotContainsString('onclick', $description);
        $this->assertStringContainsString('<strong>tebal</strong>', $description);
    }

    private function createProduct(): array
    {
        $user = User::factory()->create();
        $regionId = DB::table('regions')->insertGetId([
            'region_name' => 'Jakarta',
            'province' => 'DKI Jakarta',
            'ketua_dpw' => $user->id,
            'wk_ketua_dpw' => $user->id,
            'sekretaris_dpw' => $user->id,
            'bendahara_dpw' => $user->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $weddingOrganizer = WeddingOrganizer::create([
            'user_id' => $user->id,
            'region_id' => $regionId,
            'organizer_name' => 'WO Aman',
            'slug' => 'wo-aman',
        ]);
        $product = Product::create([
            'wedding_organizer_id' => $weddingOrganizer->id,
            'name' => 'Produk Aman',
            'slug' => 'produk-aman',
            'original_price' => 200000,
            'price' => 150000,
            'images' => ['products/original.webp'],
        ]);

        return [$user, $weddingOrganizer, $product];
    }

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Produk Aman',
            'description' => '<p>Aman</p>',
            'features' => '',
            'original_price' => 200000,
            'price' => 150000,
            'badges' => '',
            'is_active' => '1',
        ], $overrides);
    }
}
