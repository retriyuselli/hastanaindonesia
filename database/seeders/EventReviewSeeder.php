<?php

namespace Database\Seeders;

use App\Models\EventHastana;
use App\Models\EventReview;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all events
        $events = EventHastana::all();

        if ($events->isEmpty()) {
            $this->command->warn('No events found. Please seed EventHastana first.');
            return;
        }

        $this->command->info('Seeding reviews for ' . $events->count() . ' events...');

        foreach ($events as $event) {
            // Generate random number of reviews per event (5-20)
            $reviewCount = rand(5, 20);

            // Create regular reviews (70%)
            $regularCount = (int)($reviewCount * 0.7);
            EventReview::factory($regularCount)->create([
                'event_hastana_id' => $event->id,
            ]);

            // Create verified participant reviews (20%)
            $verifiedCount = (int)($reviewCount * 0.2);
            EventReview::factory($verifiedCount)->verified()->create([
                'event_hastana_id' => $event->id,
            ]);

            // Create featured reviews (10%)
            $featuredCount = (int)($reviewCount * 0.1);
            EventReview::factory($featuredCount)->featured()->create([
                'event_hastana_id' => $event->id,
            ]);

            $this->command->info("Created {$reviewCount} reviews for event: {$event->title}");
        }

        // Update all event ratings
        $this->command->info('Updating event ratings...');
        foreach ($events as $event) {
            $event->updateRating();
        }

        $totalReviews = EventReview::count();
        $this->command->info("✓ Successfully seeded {$totalReviews} event reviews!");
        $this->command->info('✓ Event ratings updated!');
    }
}
