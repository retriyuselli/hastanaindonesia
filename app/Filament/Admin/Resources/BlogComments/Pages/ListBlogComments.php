<?php

namespace App\Filament\Admin\Resources\BlogComments\Pages;

use App\Filament\Admin\Resources\BlogComments\BlogCommentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBlogComments extends ListRecords
{
    protected static string $resource = BlogCommentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
