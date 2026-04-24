<?php

namespace Tests\Feature;

use App\Models\EventCategory;
use App\Models\EventHastana;
use App\Models\EventParticipant;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PrivateFileDownloadTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_view_event_participant_payment_proof_from_private_disk(): void
    {
        Storage::fake('private');

        $this->seed(RoleSeeder::class);

        /** @var User $user */
        $user = User::factory()->create();
        $user->assignRole('member');

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
            'user_id' => $user->id,
            'name' => 'User',
            'email' => 'user@example.com',
            'phone' => '0800000000',
            'payment_proof' => $path,
            'payment_status' => 'paid',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user)->get("/files/event-participants/{$participant->id}/payment-proof");

        $response->assertOk();
    }

    public function test_non_owner_cannot_view_event_participant_payment_proof(): void
    {
        Storage::fake('private');

        $this->seed(RoleSeeder::class);

        /** @var User $owner */
        $owner = User::factory()->create();
        $owner->assignRole('member');

        /** @var User $other */
        $other = User::factory()->create();
        $other->assignRole('member');

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
            'user_id' => $owner->id,
            'name' => 'User',
            'email' => 'user@example.com',
            'phone' => '0800000000',
            'payment_proof' => $path,
            'payment_status' => 'paid',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($other)->get("/files/event-participants/{$participant->id}/payment-proof");

        $response->assertStatus(403);
    }
}
