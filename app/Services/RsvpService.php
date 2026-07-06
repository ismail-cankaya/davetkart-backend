<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Rsvp;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class RsvpService
{
    /**
     * All responses for the user's invitation, newest first.
     *
     * @return Collection<int, Rsvp>
     */
    public function listForUser(User $user): Collection
    {
        return $user->rsvps()->latest('id')->get();
    }

    /**
     * Persist a guest response (RsvpDraft) against the user's invitation.
     * `id` and `createdAt` are produced here, as the frontend expects.
     *
     * @param  array<string, mixed>  $data  validated StoreRsvpRequest payload
     */
    public function createForUser(User $user, array $data): Rsvp
    {
        return $user->rsvps()->create([
            'guest_name' => $data['guestName'],
            'guest_count' => $data['guestCount'],
            'menu_preference' => $data['menuPreference'] ?? '',
            'status' => $data['status'],
            'message' => $data['message'] ?? null,
            'photo_url' => $data['photoUrl'] ?? null,
            'video_url' => $data['videoUrl'] ?? null,
        ]);
    }

    /**
     * Delete one of the user's responses. Scoping through the relation makes
     * cross-account deletion impossible; missing ids surface as a 404.
     */
    public function deleteForUser(User $user, int $id): void
    {
        $user->rsvps()->findOrFail($id)->delete();
    }
}
