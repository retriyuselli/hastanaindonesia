<?php

namespace App\Filament\Resources\EventParticipants\Pages;

use App\Filament\Resources\EventParticipants\EventParticipantResource;
use App\Filament\Resources\EventParticipants\Widgets\EventParticipantStatsOverview;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEventParticipants extends ListRecords
{
    protected static string $resource = EventParticipantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('previewRecap')
                ->label('Preview Rekapan')
                ->icon('heroicon-o-document-text')
                ->color('gray')
                ->url(fn () => route('admin.files.event-participants.recap'))
                ->openUrlInNewTab(),
            Action::make('downloadRecap')
                ->label('Download Rekapan')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('warning')
                ->url(fn () => route('admin.files.event-participants.recap') . '?download=1')
                ->openUrlInNewTab(),
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            EventParticipantStatsOverview::class,
        ];
    }
}
