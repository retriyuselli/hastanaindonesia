<?php

namespace Tests\Feature;

use App\Models\Region;
use App\Models\User;
use App\Models\WeddingOrganizer;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberDetailEditProductButtonTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_can_see_edit_product_button_on_member_detail(): void
    {
        $this->seed(RoleSeeder::class);

        $regionUser = User::factory()->createOne();
        $region = Region::create([
            'region_name' => 'DPW Test',
            'province' => 'Bali',
            'ketua_dpw' => $regionUser->id,
            'wk_ketua_dpw' => $regionUser->id,
            'sekretaris_dpw' => $regionUser->id,
            'bendahara_dpw' => $regionUser->id,
        ]);

        $owner = User::query()->findOrFail(User::factory()->createOne(['role' => 'member'])->id);
        $superAdmin = User::query()->findOrFail(User::factory()->createOne(['role' => 'super_admin'])->id);
        $superAdmin->assignRole(config('filament-shield.super_admin.name', 'super_admin'));

        $member = WeddingOrganizer::create([
            'user_id' => $owner->id,
            'region_id' => $region->id,
            'organizer_name' => 'Bali Dream Wedding',
            'slug' => 'bali-dream-wedding',
            'verification_status' => 'verified',
            'status' => 'active',
        ]);

        $response = $this->actingAs($superAdmin)->get(route('members.show', $member->slug));

        $response->assertOk();
        $response->assertSee('Edit Produk');
        $response->assertSee(route('products.manage', $member->slug));
    }

    public function test_super_admin_can_access_product_management_for_any_member(): void
    {
        $this->seed(RoleSeeder::class);

        $regionUser = User::factory()->createOne();
        $region = Region::create([
            'region_name' => 'DPW Test',
            'province' => 'Bali',
            'ketua_dpw' => $regionUser->id,
            'wk_ketua_dpw' => $regionUser->id,
            'sekretaris_dpw' => $regionUser->id,
            'bendahara_dpw' => $regionUser->id,
        ]);

        $owner = User::query()->findOrFail(User::factory()->createOne(['role' => 'member'])->id);
        $superAdmin = User::query()->findOrFail(User::factory()->createOne(['role' => 'super_admin'])->id);
        $superAdmin->assignRole(config('filament-shield.super_admin.name', 'super_admin'));

        $member = WeddingOrganizer::create([
            'user_id' => $owner->id,
            'region_id' => $region->id,
            'organizer_name' => 'Bali Dream Wedding',
            'slug' => 'bali-dream-wedding',
            'verification_status' => 'verified',
            'status' => 'active',
        ]);

        $response = $this->actingAs($superAdmin)->get(route('products.manage', $member->slug));

        $response->assertOk();
    }

    public function test_non_owner_non_super_admin_cannot_see_edit_product_button_or_access_management(): void
    {
        $this->seed(RoleSeeder::class);

        $regionUser = User::factory()->createOne();
        $region = Region::create([
            'region_name' => 'DPW Test',
            'province' => 'Bali',
            'ketua_dpw' => $regionUser->id,
            'wk_ketua_dpw' => $regionUser->id,
            'sekretaris_dpw' => $regionUser->id,
            'bendahara_dpw' => $regionUser->id,
        ]);

        $owner = User::query()->findOrFail(User::factory()->createOne(['role' => 'member'])->id);
        $otherUser = User::query()->findOrFail(User::factory()->createOne(['role' => 'member'])->id);

        $member = WeddingOrganizer::create([
            'user_id' => $owner->id,
            'region_id' => $region->id,
            'organizer_name' => 'Bali Dream Wedding',
            'slug' => 'bali-dream-wedding',
            'verification_status' => 'verified',
            'status' => 'active',
        ]);

        $detailResponse = $this->actingAs($otherUser)->get(route('members.show', $member->slug));
        $detailResponse->assertOk();
        $detailResponse->assertDontSee('Edit Produk');

        $manageResponse = $this->actingAs($otherUser)->get(route('products.manage', $member->slug));
        $manageResponse->assertForbidden();
    }
}
