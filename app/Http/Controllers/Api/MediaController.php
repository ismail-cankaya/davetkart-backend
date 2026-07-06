<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadMediaRequest;
use App\Services\MediaService;
use Illuminate\Http\JsonResponse;

class MediaController extends Controller
{
    public function __construct(
        private readonly MediaService $mediaService,
    ) {}

    public function upload(UploadMediaRequest $request): JsonResponse
    {
        $url = $this->mediaService->upload($request->file('file'));

        return response()->json(['url' => $url], 201);
    }
}
