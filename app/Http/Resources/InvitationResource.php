<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Wire format of the frontend `Invitation` interface (camelCase, no nulls on
 * string fields).
 *
 * @mixin \App\Models\Invitation
 */
class InvitationResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title ?? '',
            'subtitle' => $this->subtitle ?? '',
            'names' => $this->names ?? '',
            'date' => $this->event_date ?? '',
            'venue' => $this->venue ?? '',
            'mapUrl' => $this->map_url ?? '',
            'phoneBackground' => $this->phone_background ?? '',
            'imageTheme' => $this->image_theme ?? '',
            'categoryId' => $this->category_id ?? '',
            'palette' => $this->palette,

            'showEnvelope' => $this->show_envelope,
            'showTimer' => $this->show_timer,
            'showTimeline' => $this->show_timeline,
            'showGallery' => $this->show_gallery,
            'showGift' => $this->show_gift,
            'showRSVP' => $this->show_rsvp,

            'bankName' => $this->bank_name ?? '',
            'accountHolder' => $this->account_holder ?? '',
            'iban' => $this->iban ?? '',
            'giftOptions' => $this->gift_options ?? [],

            'rsvpDeadline' => $this->rsvp_deadline ?? '',
            'askMenuPreference' => $this->ask_menu_preference,

            'timelineEvents' => $this->timeline_events ?? [],
            'galleryImages' => $this->gallery_images ?? [],
        ];
    }
}
