<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use Tests\TestCase;

class BlogSlugAutoUpdateTest extends TestCase
{
    public function test_blog_form_updates_slug_when_title_changes_even_on_edit(): void
    {
        $formPath = app_path('Filament/Resources/Blogs/Schemas/BlogForm.php');
        $this->assertFileExists($formPath);

        $contents = File::get($formPath);

        $this->assertStringContainsString("TextInput::make('title')", $contents);
        $this->assertStringContainsString('->live(onBlur: true)', $contents);
        $this->assertStringContainsString("->afterStateUpdated(fn (\$state, callable \$set) => \$set('slug', Str::slug(\$state)))", $contents);
        $this->assertStringNotContainsString("if (empty(\$get('slug')))", $contents);
    }
}
