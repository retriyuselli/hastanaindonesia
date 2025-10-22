#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\EventHastana;
use App\Models\EventParticipant;
use App\Models\User;

echo "═══════════════════════════════════════════════════════\n";
echo "  TEST: Current Participants Auto-Update System\n";
echo "═══════════════════════════════════════════════════════\n\n";

$event = EventHastana::where('slug', 'surabaya-wedding-festival-2025')->first();
$user = User::first();

if (!$event) {
    echo "❌ Event not found!\n";
    exit(1);
}

if (!$user) {
    echo "❌ User not found! Create user first.\n";
    exit(1);
}

echo "📅 Event: {$event->title}\n";
echo "👤 Test User: {$user->name}\n\n";

echo "──────────────────────────────────────────────────────\n";
echo "BEFORE: Current Participants = {$event->current_participants}\n";
echo "──────────────────────────────────────────────────────\n\n";

echo "🔄 Creating participants...\n";

// Participant 1: Confirmed (will be counted)
$p1 = EventParticipant::create([
    'event_hastana_id' => $event->id,
    'user_id' => $user->id,
    'name' => 'Budi Santoso',
    'email' => 'budi@example.com',
    'phone' => '081234567890',
    'status' => 'confirmed',
    'payment_status' => 'paid',
    'registration_date' => now(),
]);
echo "  ✓ Created: Budi (confirmed) - COUNTED\n";

// Participant 2: Attended (will be counted)
$p2 = EventParticipant::create([
    'event_hastana_id' => $event->id,
    'user_id' => $user->id,
    'name' => 'Siti Aminah',
    'email' => 'siti@example.com',
    'phone' => '081234567891',
    'status' => 'attended',
    'payment_status' => 'paid',
    'registration_date' => now()->subDays(2),
    'attended_at' => now()->subDay(),
]);
echo "  ✓ Created: Siti (attended) - COUNTED\n";

// Participant 3: Pending (NOT counted)
$p3 = EventParticipant::create([
    'event_hastana_id' => $event->id,
    'user_id' => $user->id,
    'name' => 'Joko Widodo',
    'email' => 'joko@example.com',
    'phone' => '081234567892',
    'status' => 'pending',
    'payment_status' => 'pending',
    'registration_date' => now(),
]);
echo "  ✓ Created: Joko (pending) - NOT COUNTED\n";

// Participant 4: Cancelled (NOT counted)
$p4 = EventParticipant::create([
    'event_hastana_id' => $event->id,
    'user_id' => $user->id,
    'name' => 'Dewi Lestari',
    'email' => 'dewi@example.com',
    'phone' => '081234567893',
    'status' => 'cancelled',
    'payment_status' => 'refunded',
    'registration_date' => now()->subDays(5),
]);
echo "  ✓ Created: Dewi (cancelled) - NOT COUNTED\n\n";

echo "──────────────────────────────────────────────────────\n";

// Refresh event
$event->refresh();

echo "AFTER: Current Participants = {$event->current_participants}\n";
echo "Expected: 2 (confirmed + attended only)\n";
echo "──────────────────────────────────────────────────────\n\n";

// Verification
echo "📊 Breakdown:\n";
echo "  • Confirmed: " . $event->participants()->where('status', 'confirmed')->count() . "\n";
echo "  • Attended: " . $event->participants()->where('status', 'attended')->count() . "\n";
echo "  • Pending: " . $event->participants()->where('status', 'pending')->count() . "\n";
echo "  • Cancelled: " . $event->participants()->where('status', 'cancelled')->count() . "\n";
echo "  • TOTAL: " . $event->participants()->count() . "\n\n";

// Test status change
echo "🔄 Testing status change...\n";
echo "  Changing Joko from pending → confirmed\n";
$p3->update(['status' => 'confirmed', 'payment_status' => 'paid']);

$event->refresh();
echo "  Current Participants: {$event->current_participants} (should be 3)\n\n";

// Show event stats
echo "📈 Event Stats:\n";
echo "  • Capacity: {$event->capacity}\n";
echo "  • Current: {$event->current_participants}\n";
echo "  • Remaining: {$event->remaining_quota}\n";
echo "  • Percentage: " . number_format($event->capacity_percentage, 2) . "%\n";
echo "  • Is Full: " . ($event->is_full ? 'YES' : 'NO') . "\n\n";

echo "═══════════════════════════════════════════════════════\n";
if ($event->current_participants == 3) {
    echo "  ✅ AUTO-UPDATE SYSTEM WORKING CORRECTLY!\n";
} else {
    echo "  ❌ SYSTEM ERROR: Expected 3, got {$event->current_participants}\n";
}
echo "═══════════════════════════════════════════════════════\n";
