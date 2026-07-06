<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\RsvpStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/** Validates the RsvpDraft object submitted from the guest response form. */
class StoreRsvpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'guestName' => ['required', 'string', 'max:255'],
            'guestCount' => ['required', 'integer', 'min:1', 'max:20'],
            'menuPreference' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::enum(RsvpStatus::class)],
            'message' => ['nullable', 'string', 'max:2000'],
            'photoUrl' => ['nullable', 'string', 'max:2048'],
            'videoUrl' => ['nullable', 'string', 'max:2048'],
        ];
    }
}
