<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProductionCheck extends Command
{
    protected $signature = 'app:production-check';

    protected $description = 'Validate critical production configuration and generated assets';

    public function handle(): int
    {
        $checks = [
            'Environment production' => app()->isProduction(),
            'Debug dinonaktifkan' => config('app.debug') === false,
            'Application key tersedia' => filled(config('app.key')),
            'APP_URL menggunakan HTTPS' => parse_url((string) config('app.url'), PHP_URL_SCHEME) === 'https',
            'Queue bukan sync' => config('queue.default') !== 'sync',
            'Session terenkripsi' => config('session.encrypt') === true,
            'Cookie session HTTPS-only' => config('session.secure') === true,
            'Cookie session HttpOnly' => config('session.http_only') === true,
            'Build manifest tersedia' => is_file(public_path('build/manifest.json')),
            'Public storage link tersedia' => is_link(public_path('storage')),
            'Database dapat diakses' => $this->databaseIsAvailable(),
        ];

        $this->table(
            ['Pemeriksaan', 'Status'],
            collect($checks)
                ->map(fn (bool $passed, string $name) => [$name, $passed ? 'OK' : 'GAGAL'])
                ->values()
                ->all(),
        );

        if (in_array(false, $checks, true)) {
            $this->error('Konfigurasi production belum siap.');

            return self::FAILURE;
        }

        $this->info('Konfigurasi production siap.');

        return self::SUCCESS;
    }

    private function databaseIsAvailable(): bool
    {
        try {
            DB::connection()->getPdo();

            return true;
        } catch (Throwable) {
            return false;
        }
    }
}
