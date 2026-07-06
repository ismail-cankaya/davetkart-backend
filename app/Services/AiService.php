<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Server-side proxy in front of Google GenAI so the API key never reaches the
 * browser. Skeleton implementation: one prompt in, generated text out.
 * Extend with system instructions, safety settings and streaming as needed.
 */
class AiService
{
    private const ENDPOINT = 'https://generativelanguage.googleapis.com/v1beta/models/%s:generateContent';

    public function generate(string $prompt): string
    {
        $apiKey = config('services.google_genai.key');

        if (empty($apiKey)) {
            throw new HttpException(501, 'AI servisi henüz yapılandırılmadı (GOOGLE_GENAI_API_KEY).');
        }

        try {
            $response = Http::timeout(30)
                ->withHeaders(['x-goog-api-key' => $apiKey])
                ->post(sprintf(self::ENDPOINT, config('services.google_genai.model')), [
                    'contents' => [
                        ['parts' => [['text' => $prompt]]],
                    ],
                ]);
        } catch (ConnectionException) {
            throw new HttpException(504, 'AI servisine ulaşılamadı.');
        }

        if ($response->failed()) {
            throw new HttpException(502, 'AI servisi bir hata döndürdü.');
        }

        return (string) data_get($response->json(), 'candidates.0.content.parts.0.text', '');
    }
}
