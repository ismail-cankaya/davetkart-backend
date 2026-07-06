<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\RsvpStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rsvp extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'guest_name',
        'guest_count',
        'menu_preference',
        'status',
        'message',
        'photo_url',
        'video_url',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'guest_count' => 'integer',
            'status' => RsvpStatus::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
