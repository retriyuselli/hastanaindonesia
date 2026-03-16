<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Tests\TestCase;

class GroupActionLabelTest extends TestCase
{
    public function test_all_filament_table_action_groups_have_label_aksi(): void
    {
        $tablesRoot = app_path('Filament/Resources');
        $this->assertDirectoryExists($tablesRoot);

        $tableFiles = collect(File::allFiles($tablesRoot))
            ->filter(fn ($file) => Str::endsWith($file->getRealPath(), 'Table.php'))
            ->filter(fn ($file) => str_contains($file->getRealPath(), DIRECTORY_SEPARATOR.'Tables'.DIRECTORY_SEPARATOR));

        $this->assertNotEmpty($tableFiles->all(), 'No Filament table configuration files found.');

        foreach ($tableFiles as $file) {
            $path = $file->getRealPath();
            $contents = File::get($path);

            $actionGroupCount = preg_match_all('/ActionGroup::make\\(\\[/', $contents);
            $actionGroupWithLabelCount = preg_match_all("/ActionGroup::make\\(\\[[\\s\\S]*?\\]\\)\\s*->label\\('Aksi'\\)/", $contents);
            $this->assertSame(
                $actionGroupCount,
                $actionGroupWithLabelCount,
                "Missing ->label('Aksi') for ActionGroup in {$path}"
            );

            $bulkActionGroupCount = preg_match_all('/BulkActionGroup::make\\(\\[/', $contents);
            $bulkActionGroupWithLabelCount = preg_match_all("/BulkActionGroup::make\\(\\[[\\s\\S]*?\\]\\)\\s*->label\\('Aksi'\\)/", $contents);
            $this->assertSame(
                $bulkActionGroupCount,
                $bulkActionGroupWithLabelCount,
                "Missing ->label('Aksi') for BulkActionGroup in {$path}"
            );
        }
    }
}
