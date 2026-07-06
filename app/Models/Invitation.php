<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invitation extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'subtitle',
        'names',
        'event_date',
        'venue',
        'map_url',
        'phone_background',
        'image_theme',
        'category_id',
        'palette',
        'show_envelope',
        'show_timer',
        'show_timeline',
        'show_gallery',
        'show_gift',
        'show_rsvp',
        'bank_name',
        'account_holder',
        'iban',
        'gift_options',
        'rsvp_deadline',
        'ask_menu_preference',
        'timeline_events',
        'gallery_images',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'show_envelope' => 'boolean',
            'show_timer' => 'boolean',
            'show_timeline' => 'boolean',
            'show_gallery' => 'boolean',
            'show_gift' => 'boolean',
            'show_rsvp' => 'boolean',
            'ask_menu_preference' => 'boolean',
            'gift_options' => 'array',
            'timeline_events' => 'array',
            'gallery_images' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
