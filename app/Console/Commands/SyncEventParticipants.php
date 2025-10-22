<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EventHastana;
use App\Models\EventParticipant;

class SyncEventParticipants extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:sync-participants {--event-id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync current_participants count from actual registrations (confirmed + attended only)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $eventId = $this->option('event-id');

        if ($eventId) {
            // Sync specific event
            $event = EventHastana::find($eventId);
            if (!$event) {
                $this->error("Event with ID {$eventId} not found!");
                return 1;
            }

            $this->syncEvent($event);
            $this->info("✓ Event '{$event->title}' synced successfully!");
        } else {
            // Sync all events
            $this->info('Syncing all events...');
            $events = EventHastana::all();
            $bar = $this->output->createProgressBar($events->count());
            $bar->start();

            foreach ($events as $event) {
                $this->syncEvent($event);
                $bar->advance();
            }

            $bar->finish();
            $this->newLine();
            $this->info("✓ {$events->count()} events synced successfully!");
        }

        return 0;
    }

    /**
     * Sync participants count for a single event
     */
    private function syncEvent(EventHastana $event): void
    {
        $count = EventParticipant::where('event_hastana_id', $event->id)
            ->whereIn('status', ['confirmed', 'attended'])
            ->count();

        $event->updateQuietly(['current_participants' => $count]);
    }
}
