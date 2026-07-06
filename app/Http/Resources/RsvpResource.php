<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Wire format of the frontend `RSVPResponse` interface.
 *
 * @mixin \App\Models\Rsvp
 */
class RsvpResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (string) $this->id, // frontend types id as string
            'guestName' => $this->guest_name,
            'guestCount' => $this->guest_count,
            'menuPreference' => $this->menu_preference ?? '',
            'status' => $this->status->value,
            'message' => $this->message,
            'photoUrl' => $this->photo_url,
            'videoUrl' => $this->video_url,
            'createdAt' => $this->created_at->toISOString(),
        ];
    }
}
