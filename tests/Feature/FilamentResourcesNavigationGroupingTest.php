<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Tests\TestCase;

class FilamentResourcesNavigationGroupingTest extends TestCase
{
    public function test_resources_do_not_use_clusters_and_have_navigation_group(): void
    {
        $providerPath = app_path('Providers/Filament/AdminPanelProvider.php');
        $this->assertFileExists($providerPath);

        $providerContents = File::get($providerPath);
        $this->assertStringNotContainsString('discoverClusters(', $providerContents);

        $resourcesRoot = app_path('Filament/Resources');
        $this->assertDirectoryExists($resourcesRoot);

        $resourceFiles = collect(File::allFiles($resourcesRoot))
            ->filter(fn ($file) => Str::endsWith($file->getRealPath(), 'Resource.php'));

        $this->assertNotEmpty($resourceFiles->all(), 'No Filament Resource files found.');

        $allowedGroups = ['Content', 'Events', 'Organization', 'Users'];

        foreach ($resourceFiles as $file) {
            $path = $file->getRealPath();
            $contents = File::get($path);

            $this->assertStringNotContainsString('App\\Filament\\Clusters', $contents, "Clusters reference found in {$path}");
            $this->assertDoesNotMatchRegularExpression('/\\$cluster\\s*=/', $contents, "Cluster property found in {$path}");

            $this->assertDoesNotMatchRegularExpression('/protected\\s+static\\s+\\?string\\s+\\$navigationGroup\\s*=/', $contents, "navigationGroup must not be typed as ?string in {$path}");
            $this->assertDoesNotMatchRegularExpression('/protected\\s+static\\s+\\?string\\s+\\$cluster\\s*=/', $contents, "cluster must not be typed as ?string in {$path}");

            $this->assertMatchesRegularExpression("/\\\$navigationGroup\\s*=\\s*'[^']+'\\s*;/", $contents, "Missing navigationGroup assignment in {$path}");

            preg_match("/\\\$navigationGroup\\s*=\\s*'([^']+)'\\s*;/", $contents, $matches);
            $group = $matches[1] ?? null;

            $this->assertNotNull($group, "Unable to read navigationGroup value in {$path}");
            $this->assertContains($group, $allowedGroups, "Unexpected navigationGroup '{$group}' in {$path}");
        }
    }
}
