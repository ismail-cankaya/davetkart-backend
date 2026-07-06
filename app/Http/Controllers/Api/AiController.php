<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GenerateAiRequest;
use App\Services\AiService;
use Illuminate\Http\JsonResponse;

class AiController extends Controller
{
    public function __construct(
        private readonly AiService $aiService,
    ) {}

    public function generate(GenerateAiRequest $request): JsonResponse
    {
        $text = $this->aiService->generate($request->validated('prompt'));

        return response()->json(['text' => $text]);
    }
}
