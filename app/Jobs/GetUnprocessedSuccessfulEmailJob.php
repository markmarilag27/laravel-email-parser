<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\SuccessfulEmail;
use App\Utility\ParseRawEmailUtility;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GetUnprocessedSuccessfulEmailJob implements ShouldBeEncrypted, ShouldBeUnique, ShouldQueue
{
    use Queueable;

    public function __construct() {}

    public function handle(): void
    {
        $callback = function (SuccessfulEmail $successfulEmail) {
            $successfulEmail->updateQuietly([
                'raw_text' => ParseRawEmailUtility::normalizeRawText($successfulEmail->email),
            ]);
        };

        SuccessfulEmail::query()->where('raw_text', '')->each($callback);
    }
}
