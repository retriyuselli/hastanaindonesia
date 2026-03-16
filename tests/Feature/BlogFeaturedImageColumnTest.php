<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use Tests\TestCase;

class BlogFeaturedImageColumnTest extends TestCase
{
    public function test_blogs_table_featured_image_uses_public_disk_and_existing_fallback_image(): void
    {
        $fallbackPath = public_path('images/hastana_logo.png');
        $this->assertFileExists($fallbackPath);

        $tablePath = app_path('Filament/Resources/Blogs/Tables/BlogsTable.php');
        $this->assertFileExists($tablePath);

        $contents = File::get($tablePath);

        $this->assertStringContainsString("ImageColumn::make('featured_image')", $contents);
        $this->assertStringContainsString("->disk('public')", $contents);
        $this->assertStringContainsString("asset('images/hastana_logo.png')", $contents);
        $this->assertStringContainsString("Storage::disk('public')->exists", $contents);
        $this->assertStringNotContainsString('placeholder-blog.png', $contents);
    }
}
