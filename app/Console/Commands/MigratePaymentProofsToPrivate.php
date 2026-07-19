<?php

namespace App\Console\Commands;

use App\Models\EventParticipant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MigratePaymentProofsToPrivate extends Command
{
    protected $signature = 'security:migrate-payment-proofs {--keep-public : Keep the old public copies after verification}';

    protected $description = 'Move existing event payment proofs from public to private storage';

    public function handle(): int
    {
        $migrated = 0;
        $alreadyPrivate = 0;
        $missing = 0;

        EventParticipant::query()
            ->whereNotNull('payment_proof')
            ->select(['id', 'payment_proof'])
            ->chunkById(100, function ($participants) use (&$migrated, &$alreadyPrivate, &$missing): void {
                foreach ($participants as $participant) {
                    $path = $participant->payment_proof;
                    if (! is_string($path)
                        || ! str_starts_with($path, 'payment_proofs/')
                        || str_contains($path, '..')) {
                        $missing++;

                        continue;
                    }

                    if (Storage::disk('private')->exists($path)) {
                        $alreadyPrivate++;
                        if (! $this->option('keep-public')) {
                            Storage::disk('public')->delete($path);
                        }

                        continue;
                    }

                    $stream = Storage::disk('public')->readStream($path);
                    if ($stream === null || $stream === false) {
                        $missing++;

                        continue;
                    }

                    try {
                        $copied = Storage::disk('private')->put($path, $stream);
                    } finally {
                        if (is_resource($stream)) {
                            fclose($stream);
                        }
                    }

                    if (! $copied) {
                        $missing++;

                        continue;
                    }

                    if (! $this->option('keep-public')) {
                        Storage::disk('public')->delete($path);
                    }
                    $migrated++;
                }
            });

        $this->table(
            ['Migrated', 'Already private', 'Missing/invalid'],
            [[$migrated, $alreadyPrivate, $missing]],
        );

        return $missing === 0 ? self::SUCCESS : self::FAILURE;
    }
}
