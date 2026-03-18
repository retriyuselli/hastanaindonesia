<?php

namespace Database\Seeders;

use App\Models\EventHastana;
use App\Models\EventParticipant;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class EventParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (app()->environment('production') && ! ($this->command?->option('force') ?? false)) {
            $this->command?->warn('EventParticipantSeeder dilewati di production. Jalankan dengan --force jika benar-benar dibutuhkan.');

            return;
        }

        $faker = Faker::create('id_ID');

        // Get available events and users
        $events = EventHastana::query()->get(['id', 'is_free', 'created_at', 'start_date', 'end_date']);
        $users = User::pluck('id')->toArray();

        if (empty($events)) {
            $this->command->error('No events found! Please run EventHastanaSeeder first.');

            return;
        }

        if (empty($users)) {
            $this->command->error('No users found! Please run AdminUserSeeder first.');

            return;
        }

        $participants = [];
        $paymentProofPaths = [];

        $eventIds = $events->pluck('id')->all();
        EventParticipant::query()
            ->whereIn('event_hastana_id', $eventIds)
            ->where(function ($query) {
                $query
                    ->where('registration_code', 'like', 'EVT-%')
                    ->orWhere('registration_code', 'like', 'VIP-%');
            })
            ->delete();

        // Create participants for each event
        foreach ($events as $event) {
            $participantCount = 6;

            for ($i = 0; $i < $participantCount; $i++) {
                $registrationDate = $faker->dateTimeBetween($event->created_at ?? '-1 month', 'now');
                $isConfirmed = $faker->boolean(70); // 70% chance of being confirmed
                $isAttended = $isConfirmed ? $faker->boolean(80) : false; // 80% of confirmed participants attend

                // Determine payment status based on event
                $paymentStatus = $event->is_free ? 'free' : $faker->randomElement(['pending', 'paid', 'refunded']);
                if ($paymentStatus === 'paid') {
                    $isConfirmed = true; // Paid participants are automatically confirmed
                }

                $registrationCode = 'EVT-'.$event->id.'-'.str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT);

                $participants[] = [
                    'event_hastana_id' => $event->id,
                    'user_id' => $faker->optional(0.6)->randomElement($users), // 60% have user accounts
                    'name' => $faker->name(),
                    'email' => $faker->unique()->safeEmail(),
                    'phone' => $faker->phoneNumber(),
                    'company' => $faker->optional(0.7)->company(), // 70% have company
                    'position' => $faker->optional(0.7)->randomElement([
                        'Wedding Organizer',
                        'Wedding Planner',
                        'Event Coordinator',
                        'Decoration Specialist',
                        'Photography Specialist',
                        'Catering Manager',
                        'Venue Manager',
                        'Marketing Manager',
                        'Business Owner',
                        'Freelancer',
                        'Student',
                        'Consultant',
                    ]),
                    'notes' => $faker->optional(0.3)->sentence(10), // 30% have notes
                    'payment_method' => $event->is_free ? null : $faker->randomElement([
                        'bank_transfer',
                        'credit_card',
                        'e_wallet',
                        'cash',
                    ]),
                    'payment_proof' => ($paymentStatus === 'paid') ? 'payment_proofs/proof_'.$faker->uuid().'.png' : null,
                    'status' => $isConfirmed ? 'confirmed' : 'pending',
                    'payment_status' => $paymentStatus,
                    'registration_code' => $registrationCode,
                    'confirmed_at' => $isConfirmed ? $faker->dateTimeBetween($registrationDate, 'now') : null,
                    'attended_at' => $isAttended ? $faker->dateTimeBetween($event->event_date ?? 'now', 'now') : null,
                    'created_at' => $registrationDate,
                    'updated_at' => $faker->dateTimeBetween($registrationDate, 'now'),
                ];

                if ($paymentStatus === 'paid') {
                    $paymentProofPaths[] = $participants[array_key_last($participants)]['payment_proof'];
                }
            }
        }

        $allParticipants = $participants;

        // Insert/update participants in batches for better performance
        $chunks = array_chunk($allParticipants, 50);
        foreach ($chunks as $chunk) {
            EventParticipant::upsert(
                $chunk,
                ['registration_code'],
                [
                    'event_hastana_id',
                    'user_id',
                    'name',
                    'email',
                    'phone',
                    'company',
                    'position',
                    'notes',
                    'payment_method',
                    'payment_proof',
                    'status',
                    'payment_status',
                    'confirmed_at',
                    'attended_at',
                    'created_at',
                    'updated_at',
                ]
            );
        }

        $dummyPng = base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO8G6jQAAAAASUVORK5CYII='
        );
        $uniqueProofs = array_values(array_unique(array_filter($paymentProofPaths)));
        foreach ($uniqueProofs as $path) {
            if (! Storage::disk('private')->exists($path)) {
                Storage::disk('private')->put($path, $dummyPng);
            }
        }

        $this->command->info('EventParticipant seeder completed! Created '.count($allParticipants).' event participants across all events.');
        $this->command->info('Statistics:');
        $this->command->info('- Regular participants: '.count($participants));
        $this->command->info('- VIP participants: 0');
        $this->command->info('- Events covered: '.count($eventIds));

        // Display some statistics
        $totalConfirmed = collect($allParticipants)->where('status', 'confirmed')->count();
        $totalPaid = collect($allParticipants)->where('payment_status', 'paid')->count();
        $totalAttended = collect($allParticipants)->whereNotNull('attended_at')->count();

        $this->command->info('- Confirmed participants: '.$totalConfirmed);
        $this->command->info('- Paid participants: '.$totalPaid);
        $this->command->info('- Attended participants: '.$totalAttended);
    }
}
