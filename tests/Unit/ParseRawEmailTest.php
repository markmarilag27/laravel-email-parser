<?php

namespace Tests\Unit;

use App\Utility\ParseRawEmailUtility;
use PHPUnit\Framework\TestCase;

class ParseRawEmailTest extends TestCase
{
    public function testExampleRawEmailSuccessfullyParseAndDoesNotContainsHtmlTags(): void
    {
        $file = 'tests/Unit/example-raw-email.txt';

        $rawEmailText = file_get_contents($file);
        $result = ParseRawEmailUtility::normalizeRawText($rawEmailText);

        $this->assertTrue($result != strip_tags($result));
    }
}
