<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\SuccessfulEmailRequest;
use App\Models\SuccessfulEmail;
use App\Services\SuccessfulEmailService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class SuccessfulEmailController extends Controller
{
    public function __construct(private readonly SuccessfulEmailService $successfulEmailService) {}

    public function index(Request $request): JsonResponse
    {
        $result = $this->successfulEmailService->getAllRecords(
            paginate: $request->filled('paginate'),
            page: (int) $request->input('page', 1),
            limit: (int) $request->input('limit', 10),
        );

        return response()->json($result);
    }

    public function store(SuccessfulEmailRequest $request): JsonResponse
    {
        /** @var array $payload */
        $payload = $request->validated();

        $result = $this->successfulEmailService->create($payload);

        return response()->json($result, HttpFoundationResponse::HTTP_CREATED);
    }

    public function show(SuccessfulEmail $source): JsonResponse
    {
        return response()->json($source);
    }

    public function update(SuccessfulEmailRequest $request, SuccessfulEmail $source): JsonResponse
    {
        /** @var array $payload */
        $payload = $request->validated();

        $source = $this->successfulEmailService->update($payload, $source);

        return response()->json($source);
    }

    public function destroy(SuccessfulEmail $source): Response
    {
        $source->delete();

        return response()->noContent();
    }
}
