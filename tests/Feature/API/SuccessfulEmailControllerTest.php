<?php

declare(strict_types=1);

namespace Tests\Feature\API;

use App\Http\Controllers\API\SuccessfulEmailController;
use App\Models\SuccessfulEmail;
use App\Models\User;
use App\Utility\ParseRawEmailUtility;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SuccessfulEmailControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        /** @var User $user */
        $user = User::factory()->create();
        Sanctum::actingAs($user);
    }

    public function testAuthenticatedUserCanGetAllTheRecordsOnPaginatedWithResponseOk(): void
    {
        $limit = 20;

        $uri = action([SuccessfulEmailController::class, 'index'], ['paginate' => true, 'limit' => $limit]);

        $this->json('GET', $uri)
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) => $json->has('data', $limit)
                ->etc()
            );
    }

    public function testAuthenticatedUserCanStoreNewSuccessfulEmailRecordWithResponseCreated(): void
    {
        $uri = action([SuccessfulEmailController::class, 'store']);

        $response = $this->json('POST', $uri, $this->payload());
        $response->assertCreated();
        /** @var array $responseData */
        $responseData = $response->decodeResponseJson();

        $this->assertTrue($responseData['raw_text'] !== strip_tags($responseData['raw_text']));
    }

    public function testAuthenticatedUserCanUpdateCurrentSelectedSuccessfulEmailWithResponseOk(): void
    {
        $payload = $this->payload();

        /** @var SuccessfulEmail $record */
        $record = SuccessfulEmail::factory()->create([
            ...$payload,
            'raw_text' => ParseRawEmailUtility::normalizeRawText($payload['email']),
            'timestamp' => now()->getTimestamp(),
        ]);

        $payload['from'] = 'example@mail.com';

        $uri = action([SuccessfulEmailController::class, 'update'], ['source' => $record->id]);

        $this->json('PUT', $uri, $payload)
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) => $json->where('from', $payload['from'])
                ->etc()
            );
    }

    public function testAuthenticatedUserCanSoftDeleteSuccessfulEmailRecordWithNoResponse(): void
    {
        $payload = $this->payload();

        /** @var SuccessfulEmail $record */
        $record = SuccessfulEmail::factory()->create([
            ...$payload,
            'raw_text' => ParseRawEmailUtility::normalizeRawText($payload['email']),
            'timestamp' => now()->getTimestamp(),
        ]);

        $uri = action([SuccessfulEmailController::class, 'destroy'], ['source' => $record->id]);

        $this->json('DELETE', $uri)->assertNoContent();
    }

    private function payload(): array
    {
        $file = 'tests/Unit/example-raw-email.txt';

        return [
            'affiliate_id' => 99,
            'envelope' => 'envelope',
            'from' => 'johnsnow@hotmail.com',
            'subject' => 'Application form',
            'dkim' => null,
            'SPF' => 'pass',
            'spam_score' => 0,
            'email' => file_get_contents($file),
            'raw_text' => '',
            'sender_ip' => '127.0.0.1',
            'to' => 'target@yahoo.com',
        ];
    }
}
