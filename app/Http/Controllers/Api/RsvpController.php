<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRsvpRequest;
use App\Http\Resources\RsvpResource;
use App\Services\RsvpService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RsvpController extends Controller
{
    public function __construct(
        private readonly RsvpService $rsvpService,
    ) {}

    /** All guest responses, newest first. */
    public function index(Request $request): AnonymousResourceCollection
    {
        return RsvpResource::collection(
            $this->rsvpService->listForUser($request->user()),
        );
    }

    public function store(StoreRsvpRequest $request): JsonResponse
    {
        $rsvp = $this->rsvpService->createForUser(
            $request->user(),
            $request->validated(),
        );

        return (new RsvpResource($rsvp))->response()->setStatusCode(201);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $this->rsvpService->deleteForUser($request->user(), $id);

        return response()->json(null, 204);
    }
}
