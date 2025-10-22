<?php

namespace App\Observers;

use App\Models\EventParticipant;
use App\Models\EventHastana;

class EventParticipantObserver
{
    /**
     * Handle the EventParticipant "created" event.
     */
    public function created(EventParticipant $eventParticipant): void
    {
        $this->updateEventParticipantsCount($eventParticipant->event_hastana_id);
    }

    /**
     * Handle the EventParticipant "updated" event.
     */
    public function updated(EventParticipant $eventParticipant): void
    {
        // Update count if status changed
        if ($eventParticipant->isDirty('status')) {
            $this->updateEventParticipantsCount($eventParticipant->event_hastana_id);
        }
    }

    /**
     * Handle the EventParticipant "deleted" event.
     */
    public function deleted(EventParticipant $eventParticipant): void
    {
        $this->updateEventParticipantsCount($eventParticipant->event_hastana_id);
    }

    /**
     * Handle the EventParticipant "restored" event.
     */
    public function restored(EventParticipant $eventParticipant): void
    {
        $this->updateEventParticipantsCount($eventParticipant->event_hastana_id);
    }

    /**
     * Handle the EventParticipant "force deleted" event.
     */
    public function forceDeleted(EventParticipant $eventParticipant): void
    {
        $this->updateEventParticipantsCount($eventParticipant->event_hastana_id);
    }

    /**
     * Update current_participants count in EventHastana
     */
    private function updateEventParticipantsCount(?int $eventHastanaId): void
    {
        if (!$eventHastanaId) {
            return;
        }

        $event = EventHastana::find($eventHastanaId);
        if (!$event) {
            return;
        }

        // Count only confirmed and attended participants
        $count = EventParticipant::where('event_hastana_id', $eventHastanaId)
            ->whereIn('status', ['confirmed', 'attended'])
            ->count();

        // Update without triggering events
        $event->updateQuietly(['current_participants' => $count]);
    }
}
