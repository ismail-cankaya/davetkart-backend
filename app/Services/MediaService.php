<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class MediaService
{
    private const DISK = 'public';
    private const DIRECTORY = 'uploads';

    /**
     * Store an uploaded file on the public disk and return its permanent,
     * absolute URL — the frontend media boundary persists exactly this URL
     * with the invitation/RSVP record.
     */
    public function upload(UploadedFile $file): string
    {
        $path = $file->store(self::DIRECTORY, self::DISK);

        if ($path === false) {
            throw new RuntimeException('Uploaded file could not be stored.');
        }

        // Absolute URL (APP_URL based) so it stays valid when rendered from
        // a different origin than the API.
        return url(Storage::disk(self::DISK)->url($path));
    }
}
