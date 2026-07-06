<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validates the complete Invitation object the SPA sends on every save.
 * Field names mirror the frontend `Invitation` interface (camelCase); the
 * InvitationService owns the mapping to database columns.
 */
class SaveInvitationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // route is behind auth:sanctum; the record is scoped to the user
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'names' => ['nullable', 'string', 'max:255'],
            'date' => ['nullable', 'string', 'max:255'],
            'venue' => ['nullable', 'string', 'max:255'],
            'mapUrl' => ['nullable', 'string', 'max:2048'],
            'phoneBackground' => ['nullable', 'string', 'max:65535'],
            'imageTheme' => ['nullable', 'string', 'max:255'],
            'categoryId' => ['nullable', 'string', 'max:64'],
            'palette' => ['nullable', 'string', Rule::in(['midnight', 'stone'])],

            'showEnvelope' => ['nullable', 'boolean'],
            'showTimer' => ['nullable', 'boolean'],
            'showTimeline' => ['nullable', 'boolean'],
            'showGallery' => ['nullable', 'boolean'],
            'showGift' => ['nullable', 'boolean'],
            'showRSVP' => ['nullable', 'boolean'],

            'bankName' => ['nullable', 'string', 'max:255'],
            'accountHolder' => ['nullable', 'string', 'max:255'],
            'iban' => ['nullable', 'string', 'max:34'],
            'giftOptions' => ['nullable', 'array', 'max:20'],
            'giftOptions.*' => ['numeric', 'min:0'],

            'rsvpDeadline' => ['nullable', 'string', 'max:10'],
            'askMenuPreference' => ['nullable', 'boolean'],

            'timelineEvents' => ['nullable', 'array', 'max:50'],
            'timelineEvents.*.id' => ['required', 'string', 'max:64'],
            'timelineEvents.*.time' => ['nullable', 'string', 'max:32'],
            'timelineEvents.*.title' => ['nullable', 'string', 'max:255'],
            'timelineEvents.*.description' => ['nullable', 'string', 'max:1000'],

            'galleryImages' => ['nullable', 'array', 'max:50'],
            'galleryImages.*' => ['string', 'max:2048'],
        ];
    }
}
