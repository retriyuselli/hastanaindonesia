<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class SyncLegacyRoles extends Command
{
    protected $signature = 'users:sync-legacy-roles
                            {--dry-run : Preview perubahan tanpa menyimpan ke database}
                            {--force : Assign ulang role meski user sudah punya Spatie role}';

    protected $description = 'Sync kolom role lama ke Spatie roles untuk semua user yang belum punya role';

    public function handle(): int
    {
        $isDryRun = $this->option('dry-run');
        $force = $this->option('force');

        $query = User::query();
        if (! $force) {
            $query->doesntHave('roles');
        }

        $users = $query->get(['id', 'name', 'email', 'role']);
        $total = $users->count();

        if ($total === 0) {
            $this->info('Semua user sudah punya Spatie role. Tidak ada yang perlu di-sync.');
            return self::SUCCESS;
        }

        $this->info("Ditemukan {$total} user yang akan di-sync" . ($isDryRun ? ' (DRY RUN)' : '') . ".\n");

        $synced = 0;
        $skipped = 0;

        $validRoles = ['super_admin', 'admin', 'member', 'customer', 'panel_user'];

        foreach ($users as $user) {
            $legacyRole = $user->role;

            if (! $legacyRole || ! in_array($legacyRole, $validRoles)) {
                $this->warn("  SKIP  [{$user->id}] {$user->email} — role '{$legacyRole}' tidak dikenali");
                $skipped++;
                continue;
            }

            $this->line("  SYNC  [{$user->id}] {$user->email} → role: {$legacyRole}");

            if (! $isDryRun) {
                $user->assignRole($legacyRole);
            }

            $synced++;
        }

        $this->newLine();
        $this->info("Selesai" . ($isDryRun ? ' (DRY RUN)' : '') . ": {$synced} user di-sync, {$skipped} di-skip.");

        if ($isDryRun) {
            $this->comment('Jalankan tanpa --dry-run untuk menyimpan perubahan.');
        }

        return self::SUCCESS;
    }
}
