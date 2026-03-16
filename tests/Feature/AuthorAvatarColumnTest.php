<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use Tests\TestCase;

class AuthorAvatarColumnTest extends TestCase
{
    public function test_authors_table_avatar_uses_existing_default_image_and_includes_basic_improvements(): void
    {
        $defaultAvatarPath = public_path('images/default-avatar.png');
        $this->assertFileExists($defaultAvatarPath);

        $tablePath = app_path('Filament/Resources/AuthorResource/Tables/AuthorsTable.php');
        $this->assertFileExists($tablePath);

        $contents = File::get($tablePath);

        $this->assertStringContainsString("asset('images/default-avatar.png')", $contents);
        $this->assertStringNotContainsString('default-avatar.jpg', $contents);
        $this->assertStringContainsString("Storage::disk('public')->exists", $contents);
        $this->assertStringContainsString("TextColumn::make('slug')", $contents);
        $this->assertStringContainsString("->copyMessage('Slug disalin!')", $contents);
        $this->assertStringContainsString("TernaryFilter::make('has_blogs')", $contents);
    }
}
