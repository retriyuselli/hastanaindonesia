<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use Tests\TestCase;

class AuthorSlugAutoUpdateTest extends TestCase
{
    public function test_author_form_updates_slug_when_name_changes_even_on_edit(): void
    {
        $formPath = app_path('Filament/Resources/AuthorResource/Schemas/AuthorForm.php');
        $this->assertFileExists($formPath);

        $contents = File::get($formPath);

        $this->assertStringContainsString("TextInput::make('name')", $contents);
        $this->assertStringContainsString('->live(onBlur: true)', $contents);
        $this->assertStringContainsString("->afterStateUpdated(fn (\$state, callable \$set) => \$set('slug', Str::slug(\$state)))", $contents);
        $this->assertStringNotContainsString("if (empty(\$get('slug')))", $contents);
    }
}
