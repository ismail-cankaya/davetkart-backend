<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // The SPA expects plain payloads ({ user, token }, [...rsvps]) rather
        // than Laravel's default { data: ... } envelope.
        JsonResource::withoutWrapping();
    }
}
