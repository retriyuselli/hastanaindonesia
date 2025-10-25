<?php

namespace App\Filament\Admin\Resources\BlogComments\Pages;

use App\Filament\Admin\Resources\BlogComments\BlogCommentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBlogComment extends CreateRecord
{
    protected static string $resource = BlogCommentResource::class;
}
