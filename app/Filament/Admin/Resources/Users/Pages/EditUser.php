<?php

namespace App\Filament\Admin\Resources\Users\Pages;

use App\Filament\Admin\Resources\Users\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Models\WeddingOrganizer;
use Filament\Notifications\Notification;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        unset($data['wedding_organizer_id']);
        return $data;
    }

    protected function afterSave(): void
    {
        $woId = $this->form->getState()['wedding_organizer_id'] ?? null;

        // Unlink previous organizer if different
        WeddingOrganizer::where('user_id', $this->record->id)
            ->where('id', '!=', $woId)
            ->update(['user_id' => null]);

        if ($woId) {
            $wo = WeddingOrganizer::find($woId);
            if ($wo && ($wo->user_id === null || $wo->user_id === $this->record->id)) {
                $wo->update(['user_id' => $this->record->id]);
            } else {
                Notification::make()
                    ->title('Wedding Organizer sudah terhubung dengan pengguna lain')
                    ->body('Silakan pilih WO yang belum terhubung atau lepaskan relasi terlebih dahulu.')
                    ->danger()
                    ->send();
            }
        }
    }
}
