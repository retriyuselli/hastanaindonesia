<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Support\Auth\AdminMultiFactorSession;
use Illuminate\Console\Command;

class ResetUserMultiFactorAuthenticationCommand extends Command
{
    protected $signature = 'hastana:reset-mfa
                            {email : Email akun yang MFA-nya akan direset}
                            {--force : Lewati konfirmasi interaktif}';

    protected $description = 'Reset two-factor authentication (authenticator + recovery codes) untuk satu user';

    public function handle(): int
    {
        $email = strtolower(trim((string) $this->argument('email')));

        $user = User::query()
            ->whereRaw('LOWER(email) = ?', [$email])
            ->first();

        if (! $user) {
            $this->error("User dengan email [{$email}] tidak ditemukan.");

            return self::FAILURE;
        }

        $hasSecret = filled($user->getAppAuthenticationSecret());
        $hasRecovery = filled($user->getAppAuthenticationRecoveryCodes());

        if (! $hasSecret && ! $hasRecovery) {
            $this->warn("User [{$user->email}] tidak memiliki MFA yang aktif.");

            return self::SUCCESS;
        }

        if (! $this->option('force') && ! $this->confirm("Reset MFA untuk {$user->name} <{$user->email}>?", true)) {
            $this->info('Dibatalkan.');

            return self::SUCCESS;
        }

        $user->saveAppAuthenticationSecret(null);
        $user->saveAppAuthenticationRecoveryCodes(null);
        AdminMultiFactorSession::clear();

        $this->info("MFA untuk [{$user->email}] berhasil direset.");
        $this->line('User bisa login ulang lalu setup authenticator dari awal di /admin.');

        return self::SUCCESS;
    }
}
