<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Invitation;
use App\Models\User;

class InvitationService
{
    /** The user's single invitation, or null when nothing was saved yet. */
    public function getForUser(User $user): ?Invitation
    {
        return $user->invitation;
    }

    /**
     * Upsert the user's invitation from the full frontend object.
     *
     * The SPA always sends the complete invitation state (camelCase); this is
     * the single place that maps it onto the snake_case column layout.
     *
     * @param  array<string, mixed>  $data  validated SaveInvitationRequest payload
     */
    public function saveForUser(User $user, array $data): Invitation
    {
        return Invitation::updateOrCreate(
            ['user_id' => $user->id],
            [
                'title' => $data['title'] ?? '',
                'subtitle' => $data['subtitle'] ?? '',
                'names' => $data['names'] ?? '',
                'event_date' => $data['date'] ?? '',
                'venue' => $data['venue'] ?? '',
                'map_url' => $data['mapUrl'] ?? '',
                'phone_background' => $data['phoneBackground'] ?? '',
                'image_theme' => $data['imageTheme'] ?? '',
                'category_id' => $data['categoryId'] ?? '',
                'palette' => $data['palette'] ?? 'midnight',
                'show_envelope' => $data['showEnvelope'] ?? true,
                'show_timer' => $data['showTimer'] ?? true,
                'show_timeline' => $data['showTimeline'] ?? true,
                'show_gallery' => $data['showGallery'] ?? true,
                'show_gift' => $data['showGift'] ?? true,
                'show_rsvp' => $data['showRSVP'] ?? true,
                'bank_name' => $data['bankName'] ?? '',
                'account_holder' => $data['accountHolder'] ?? '',
                'iban' => $data['iban'] ?? '',
                'gift_options' => $data['giftOptions'] ?? [],
                'rsvp_deadline' => $data['rsvpDeadline'] ?? '',
                'ask_menu_preference' => $data['askMenuPreference'] ?? true,
                'timeline_events' => $data['timelineEvents'] ?? [],
                'gallery_images' => $data['galleryImages'] ?? [],
            ],
        );
    }
}
