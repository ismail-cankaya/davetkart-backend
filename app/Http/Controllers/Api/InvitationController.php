<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveInvitationRequest;
use App\Http\Resources\InvitationResource;
use App\Services\InvitationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function __construct(
        private readonly InvitationService $invitationService,
    ) {}

    /** The user's saved invitation, or JSON null when none exists yet. */
    public function show(Request $request): JsonResponse
    {
        $invitation = $this->invitationService->getForUser($request->user());

        return response()->json(
            $invitation !== null ? new InvitationResource($invitation) : null,
        );
    }

    /** Upsert from the full invitation object (handles both POST and PUT). */
    public function save(SaveInvitationRequest $request): InvitationResource
    {
        $invitation = $this->invitationService->saveForUser(
            $request->user(),
            $request->validated(),
        );

        return new InvitationResource($invitation);
    }
}
