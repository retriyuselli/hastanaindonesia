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
                ->visible(fn (): bool => $this->canAccessRecap())
                ->openUrlInNewTab(),
            Action::make('downloadRecap')
                ->label('Download PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('warning')
                ->url(fn () => route('admin.files.event-participants.recap', ['download' => 1]))
                ->visible(fn (): bool => $this->canAccessRecap()),
            Action::make('downloadRecapExcel')
                ->label('Download Excel')
                ->icon('heroicon-o-table-cells')
                ->color('success')
                ->url(fn () => route('admin.files.event-participants.recap-excel'))
                ->visible(fn (): bool => $this->canAccessRecap()),
            CreateAction::make(),
        ];
    }

    private function canAccessRecap(): bool
    {
        return auth()->user()?->hasAnyRole([
            'admin',
            config('filament-shield.super_admin.name', 'super_admin'),
        ]) === true;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            EventParticipantStatsOverview::class,
        ];
    }
}
