<?php

namespace Tests\Feature;

use App\Models\EventParticipant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PaymentProofPrivacyTest extends TestCase
{
    use RefreshDatabase;

    public function test_existing_public_payment_proofs_can_be_migrated_to_private_storage(): void
    {
        Storage::fake('public');
        Storage::fake('private');
        $participant = $this->createParticipant();
        Storage::disk('public')->put($participant->payment_proof, 'proof');

        $this->artisan('security:migrate-payment-proofs')->assertSuccessful();

        Storage::disk('private')->assertExists($participant->payment_proof);
        Storage::disk('public')->assertMissing($participant->payment_proof);
    }

    public function test_only_owner_can_view_private_payment_proof_without_caching(): void
    {
        Storage::fake('private');
        $owner = User::factory()->create();
        $participant = $this->createParticipant($owner);
        Storage::disk('private')->put($participant->payment_proof, 'proof');

        $this->actingAs(User::factory()->create())
            ->get(route('files.event-participants.payment-proof', $participant))
            ->assertForbidden();

        $this->actingAs($owner)
            ->get(route('files.event-participants.payment-proof', $participant))
            ->assertOk()
            ->assertHeader('Cache-Control', 'max-age=0, no-store, private')
            ->assertHeader('X-Content-Type-Options', 'nosniff');
    }

    private function createParticipant(?User $user = null): EventParticipant
    {
        $categoryId = DB::table('event_categories')->insertGetId([
            'name' => 'Workshop',
            'slug' => 'workshop',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $eventId = DB::table('event_hastanas')->insertGetId([
            'event_category_id' => $categoryId,
            'title' => 'Event Aman',
            'slug' => 'event-aman',
            'description' => 'Deskripsi',
            'location' => 'Jakarta',
            'city' => 'Jakarta',
            'start_date' => now()->addDay(),
            'end_date' => now()->addDays(2),
            'event_type' => 'internal',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return EventParticipant::create([
            'event_hastana_id' => $eventId,
            'user_id' => $user?->id,
            'name' => 'Peserta',
            'email' => 'peserta@example.com',
            'phone' => '08123456789',
            'registration_code' => 'REG-PRIVATETEST',
            'payment_proof' => 'payment_proofs/proof.png',
        ]);
    }
}
