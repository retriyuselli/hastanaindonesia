<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use Tests\TestCase;

class EventSlugAutoUpdateTest extends TestCase
{
    public function test_event_form_always_generates_read_only_slug_from_title(): void
    {
        $formPath = app_path('Filament/Resources/EventHastanas/Schemas/EventHastanaForm.php');
        $this->assertFileExists($formPath);

        $contents = File::get($formPath);

        $this->assertStringContainsString("TextInput::make('title')", $contents);
        $this->assertStringContainsString('->live(onBlur: true)', $contents);
        $this->assertStringContainsString(
            "->afterStateUpdated(fn (\$state, callable \$set) => \$set('slug', Str::slug(\$state)))",
            $contents,
        );
        $this->assertMatchesRegularExpression(
            "/TextInput::make\\('slug'\\).*?->readOnly\\(\\)/s",
            $contents,
        );
        $this->assertStringNotContainsString("if (! \$get('slug')", $contents);
    }
}
