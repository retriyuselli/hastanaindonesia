<?php

namespace Tests\Feature;

use App\Models\HomeHeroImage;
use App\Models\User;
use App\Policies\HomeHeroImagePolicy;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HomeHeroImageSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_super_admin_can_mutate_home_banners(): void
    {
        $this->seed(RoleSeeder::class);

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $superAdmin = User::factory()->create();
        $superAdmin->assignRole(config('filament-shield.super_admin.name', 'super_admin'));

        $banner = new HomeHeroImage;
        $policy = app(HomeHeroImagePolicy::class);

        $this->assertFalse($policy->create($admin));
        $this->assertFalse($policy->update($admin, $banner));
        $this->assertTrue($policy->create($superAdmin));
        $this->assertTrue($policy->update($superAdmin, $banner));
    }

    public function test_banner_only_exposes_existing_local_image_and_allowed_link(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('home-hero/safe.webp', 'image');
        config()->set('content_security.hero_allowed_link_hosts', ['hastana.test']);

        $banner = new HomeHeroImage([
            'image' => 'home-hero/safe.webp',
            'link' => 'https://hastana.test/events',
        ]);

        $this->assertNotNull($banner->image_url);
        $this->assertSame('https://hastana.test/events', $banner->safe_link);

        $banner->image = 'https://attacker.test/banner.webp';
        $banner->link = 'https://attacker.test/phishing';

        $this->assertNull($banner->image_url);
        $this->assertNull($banner->safe_link);
    }

    public function test_banner_changes_are_audited_and_home_cache_is_cleared(): void
    {
        Cache::put('home:hero_images', 'cached');

        $banner = HomeHeroImage::create([
            'image' => 'home-hero/banner.webp',
            'alt' => 'Banner resmi',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $this->assertFalse(Cache::has('home:hero_images'));
        $this->assertDatabaseHas('home_hero_image_audits', [
            'home_hero_image_id' => $banner->id,
            'action' => 'created',
        ]);
    }
}
