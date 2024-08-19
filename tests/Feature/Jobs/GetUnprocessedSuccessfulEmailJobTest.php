<?php

declare(strict_types=1);

namespace Tests\Feature\Jobs;

use App\Jobs\GetUnprocessedSuccessfulEmailJob;
use App\Models\SuccessfulEmail;
use Tests\TestCase;

class GetUnprocessedSuccessfulEmailJobTest extends TestCase
{
    public function testUnprocessedSuccessfulEmailJobShouldFillUpRawText(): void
    {
        $totalBeforeRunningTheJob = SuccessfulEmail::query()->where('raw_text', '')->count();

        (new GetUnprocessedSuccessfulEmailJob)->handle();

        $this->assertNotEquals(
            expected: $totalBeforeRunningTheJob,
            actual: SuccessfulEmail::query()->where('raw_text', '')->count()
        );
    }
}
