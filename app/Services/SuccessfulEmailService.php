<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\SuccessfulEmail;
use App\Utility\ParseRawEmailUtility;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Throwable;

class SuccessfulEmailService
{
    public function getAllRecords(bool $paginate, int $page, int $limit): LengthAwarePaginator|Collection
    {
        /** @var \Closure(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Contracts\Pagination\LengthAwarePaginator $paginateCallback */
        $paginateCallback = fn (Builder $query) => $query->paginate(
            perPage: $limit,
            page: $page,
        );

        /** @var \Closure(\Illuminate\Database\Eloquent\Builder $query) */
        $getCallback = fn (Builder $query) => $query->take($limit)->get();

        return SuccessfulEmail::query()->latest('id')->when(
            value: $paginate,
            callback: $paginateCallback,
            default: $getCallback
        );
    }

    public function create(array $payload): SuccessfulEmail
    {
        DB::beginTransaction();

        try {
            /** @var SuccessfulEmail $record */
            $record = SuccessfulEmail::create($this->getPayload($payload));
            DB::commit();
        } catch (Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return $record;
    }

    public function update(array $payload, SuccessfulEmail $source): SuccessfulEmail
    {
        DB::beginTransaction();

        try {
            $source->update($this->getPayload($payload));
            DB::commit();
        } catch (Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return $source;
    }

    private function getPayload(array $payload): array
    {
        return [
            ...$payload,
            'raw_text' => $payload['raw_text'] ?? ParseRawEmailUtility::normalizeRawText($payload['email']),
            'timestamp' => now()->getTimestamp(),
        ];
    }
}
