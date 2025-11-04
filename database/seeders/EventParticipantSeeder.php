<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EventParticipant;
use App\Models\EventHastana;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;

class EventParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        // Get available events and users
        $events = EventHastana::pluck('id')->toArray();
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
        
        // Create participants for each event
        foreach ($events as $eventId) {
            $event = EventHastana::find($eventId);
            $participantCount = $faker->numberBetween(5, 25); // Random participants per event
            
            for ($i = 0; $i < $participantCount; $i++) {
                $registrationDate = $faker->dateTimeBetween($event->created_at ?? '-1 month', 'now');
                $isConfirmed = $faker->boolean(70); // 70% chance of being confirmed
                $isAttended = $isConfirmed ? $faker->boolean(80) : false; // 80% of confirmed participants attend
                
                // Determine payment status based on event
                $paymentStatus = $event->is_free ? 'free' : $faker->randomElement(['pending', 'paid', 'refunded']);
                if ($paymentStatus === 'paid') {
                    $isConfirmed = true; // Paid participants are automatically confirmed
                }
                
                $participants[] = [
                    'event_hastana_id' => $eventId,
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
                        'Consultant'
                    ]),
                    'notes' => $faker->optional(0.3)->sentence(10), // 30% have notes
                    'payment_method' => $event->is_free ? null : $faker->randomElement([
                        'bank_transfer',
                        'credit_card',
                        'e_wallet',
                        'cash'
                    ]),
                    'payment_proof' => ($paymentStatus === 'paid') ? 'payment_proofs/proof_' . $faker->uuid() . '.jpg' : null,
                    'status' => $isConfirmed ? 'confirmed' : 'pending',
                    'payment_status' => $paymentStatus,
                    'registration_code' => strtoupper($faker->bothify('EVT-####-???')),
                    'confirmed_at' => $isConfirmed ? $faker->dateTimeBetween($registrationDate, 'now') : null,
                    'attended_at' => $isAttended ? $faker->dateTimeBetween($event->event_date ?? 'now', 'now') : null,
                    'created_at' => $registrationDate,
                    'updated_at' => $faker->dateTimeBetween($registrationDate, 'now'),
                ];
            }
        }

        // Add some VIP participants with special characteristics
        $vipParticipants = [
            [
                'event_hastana_id' => $faker->randomElement($events),
                'user_id' => $faker->randomElement($users),
                'name' => 'Dr. Sari Wulandari, S.E., M.M.',
                'email' => 'sari.wulandari@hastanaindonesia.id',
                'phone' => '+62-21-55443322',
                'company' => 'PT Elegant Wedding Indonesia',
                'position' => 'CEO & Founder',
                'notes' => 'VIP member, wedding industry expert dengan 15+ tahun pengalaman',
                'payment_method' => 'bank_transfer',
                'payment_proof' => 'payment_proofs/vip_proof_001.jpg',
                'status' => 'confirmed',
                'payment_status' => 'paid',
                'registration_code' => 'VIP-2024-001',
                'confirmed_at' => Carbon::now()->subDays(10),
                'attended_at' => null,
                'created_at' => Carbon::now()->subDays(15),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'event_hastana_id' => $faker->randomElement($events),
                'user_id' => $faker->randomElement($users),
                'name' => 'Bambang Sutrisno',
                'email' => 'bambang.sutrisno@gmail.com',
                'phone' => '+62-274-88776655',
                'company' => 'Jogja Traditional Wedding',
                'position' => 'Wedding Planner Senior',
                'notes' => 'Spesialis pernikahan adat Jawa, aktif di komunitas wedding organizer Yogyakarta',
                'payment_method' => 'e_wallet',
                'payment_proof' => 'payment_proofs/vip_proof_002.jpg',
                'status' => 'confirmed',
                'payment_status' => 'paid',
                'registration_code' => 'VIP-2024-002',
                'confirmed_at' => Carbon::now()->subDays(8),
                'attended_at' => Carbon::now()->subDays(2),
                'created_at' => Carbon::now()->subDays(12),
                'updated_at' => Carbon::now()->subDays(1),
            ],
            [
                'event_hastana_id' => $faker->randomElement($events),
                'user_id' => null, // Non-member participant
                'name' => 'Maria Christina',
                'email' => 'maria.christina@balidream.com',
                'phone' => '+62-361-99887766',
                'company' => 'Bali Dream Wedding',
                'position' => 'Creative Director',
                'notes' => 'International wedding specialist, fokus destination wedding di Bali',
                'payment_method' => 'credit_card',
                'payment_proof' => 'payment_proofs/vip_proof_003.jpg',
                'status' => 'confirmed',
                'payment_status' => 'paid',
                'registration_code' => 'VIP-2024-003',
                'confirmed_at' => Carbon::now()->subDays(6),
                'attended_at' => null,
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subDays(3),
            ],
        ];

        // Merge regular and VIP participants
        $allParticipants = array_merge($participants, $vipParticipants);

        // Insert participants in batches for better performance
        $chunks = array_chunk($allParticipants, 50);
        foreach ($chunks as $chunk) {
            EventParticipant::insert($chunk);
        }

        $this->command->info('EventParticipant seeder completed! Created ' . count($allParticipants) . ' event participants across all events.');
        $this->command->info('Statistics:');
        $this->command->info('- Regular participants: ' . count($participants));
        $this->command->info('- VIP participants: ' . count($vipParticipants));
        $this->command->info('- Events covered: ' . count($events));
        
        // Display some statistics
        $totalConfirmed = collect($allParticipants)->where('status', 'confirmed')->count();
        $totalPaid = collect($allParticipants)->where('payment_status', 'paid')->count();
        $totalAttended = collect($allParticipants)->whereNotNull('attended_at')->count();
        
        $this->command->info('- Confirmed participants: ' . $totalConfirmed);
        $this->command->info('- Paid participants: ' . $totalPaid);
        $this->command->info('- Attended participants: ' . $totalAttended);
    }
}
