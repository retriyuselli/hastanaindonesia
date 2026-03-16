<?php

namespace Tests\Feature;

use App\Models\EventCategory;
use App\Models\EventHastana;
use App\Models\EventParticipant;
use App\Models\Region;
use App\Models\User;
use App\Models\WeddingOrganizer;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminFileDownloadTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_download_private_files(): void
    {
        $response = $this->get('/admin/files/wedding-organizers/1/legal/0');

        $response->assertStatus(302);
        $this->assertStringContainsString('/login', (string) $response->headers->get('Location'));
    }

    public function test_non_admin_cannot_download_private_files(): void
    {
        Storage::fake('private');

        $this->seed(RoleSeeder::class);

        /** @var User $user */
        $user = User::factory()->create();
        $user->assignRole('member');

        /** @var User $ketua */
        $ketua = User::factory()->create();
        /** @var User $wk */
        $wk = User::factory()->create();
        /** @var User $sekretaris */
        $sekretaris = User::factory()->create();
        /** @var User $bendahara */
        $bendahara = User::factory()->create();

        $region = Region::create([
            'region_name' => 'Test Region',
            'province' => 'Test Province',
            'ketua_dpw' => $ketua->id,
            'wk_ketua_dpw' => $wk->id,
            'sekretaris_dpw' => $sekretaris->id,
            'bendahara_dpw' => $bendahara->id,
        ]);

        /** @var User $owner */
        $owner = User::factory()->create();

        $path = 'wedding-organizer-documents/legal.pdf';
        Storage::disk('private')->put($path, 'dummy');

        $weddingOrganizer = WeddingOrganizer::create([
            'user_id' => $owner->id,
            'region_id' => $region->id,
            'organizer_name' => 'WO Test',
            'legal_documents' => [$path],
        ]);

        $response = $this->actingAs($user)->get("/admin/files/wedding-organizers/{$weddingOrganizer->id}/legal/0");

        $response->assertStatus(403);
    }

    public function test_admin_can_download_wedding_organizer_legal_document_from_private_disk(): void
    {
        Storage::fake('private');

        $this->seed(RoleSeeder::class);

        /** @var User $admin */
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        /** @var User $ketua */
        $ketua = User::factory()->create();
        /** @var User $wk */
        $wk = User::factory()->create();
        /** @var User $sekretaris */
        $sekretaris = User::factory()->create();
        /** @var User $bendahara */
        $bendahara = User::factory()->create();

        $region = Region::create([
            'region_name' => 'Test Region',
            'province' => 'Test Province',
            'ketua_dpw' => $ketua->id,
            'wk_ketua_dpw' => $wk->id,
            'sekretaris_dpw' => $sekretaris->id,
            'bendahara_dpw' => $bendahara->id,
        ]);

        /** @var User $owner */
        $owner = User::factory()->create();

        $path = 'wedding-organizer-documents/legal.pdf';

        Storage::disk('private')->put($path, 'dummy');

        $weddingOrganizer = WeddingOrganizer::create([
            'user_id' => $owner->id,
            'region_id' => $region->id,
            'organizer_name' => 'WO Test',
            'legal_documents' => [$path],
        ]);

        $response = $this->actingAs($admin)->get("/admin/files/wedding-organizers/{$weddingOrganizer->id}/legal/0");

        $response->assertOk();
    }

    public function test_admin_can_download_event_participant_payment_proof_from_private_disk(): void
    {
        Storage::fake('private');

        $this->seed(RoleSeeder::class);

        /** @var User $admin */
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $category = EventCategory::create([
            'name' => 'Seminar',
            'slug' => 'seminar',
            'is_active' => true,
            'sort_order' => 0,
        ]);

        $event = EventHastana::create([
            'event_category_id' => $category->id,
            'title' => 'Event Test',
            'slug' => 'event-test',
            'description' => 'desc',
            'location' => 'loc',
            'city' => 'city',
            'start_date' => now()->addDay(),
            'end_date' => now()->addDays(2),
            'event_type' => 'internal',
            'status' => 'published',
            'is_active' => true,
        ]);

        $path = 'payment_proofs/proof.png';
        Storage::disk('private')->put($path, 'dummy');

        $participant = EventParticipant::create([
            'event_hastana_id' => $event->id,
            'name' => 'User',
            'email' => 'user@example.com',
            'phone' => '0800000000',
            'payment_proof' => $path,
            'payment_status' => 'paid',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->get("/admin/files/event-participants/{$participant->id}/payment-proof");

        $response->assertOk();
    }
}
