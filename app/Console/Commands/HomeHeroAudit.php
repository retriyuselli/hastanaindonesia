<?php

namespace App\Console\Commands;

use App\Models\HomeHeroImageAudit;
use App\Models\User;
use Illuminate\Console\Command;

class HomeHeroAudit extends Command
{
    protected $signature = 'security:hero-audit {--limit=50 : Number of latest changes to display}';

    protected $description = 'Display the latest home banner changes for incident review';

    public function handle(): int
    {
        $limit = min(max((int) $this->option('limit'), 1), 200);
        $audits = HomeHeroImageAudit::query()
            ->latest('created_at')
            ->limit($limit)
            ->get();
        $users = User::query()
            ->whereIn('id', $audits->pluck('user_id')->filter()->unique()->all())
            ->pluck('email', 'id');

        $this->table(
            ['Waktu', 'Banner', 'Aksi', 'Akun', 'IP', 'Sebelum', 'Sesudah'],
            $audits->map(fn (HomeHeroImageAudit $audit): array => [
                $audit->created_at?->toDateTimeString(),
                $audit->home_hero_image_id,
                $audit->action,
                $users[$audit->user_id] ?? 'system/unknown',
                $audit->ip_address ?? '-',
                $this->summarize($audit->before),
                $this->summarize($audit->after),
            ])->all(),
        );

        return self::SUCCESS;
    }

    private function summarize(?array $snapshot): string
    {
        if ($snapshot === null) {
            return '-';
        }

        return json_encode([
            'image' => $snapshot['image'] ?? null,
            'link' => $snapshot['link'] ?? null,
            'active' => $snapshot['is_active'] ?? null,
        ], JSON_UNESCAPED_SLASHES) ?: '-';
    }
}
