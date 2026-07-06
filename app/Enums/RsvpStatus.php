<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Guest attendance status. The backed values are the exact Turkish labels the
 * frontend uses (`RsvpStatus` union in types.ts) — they travel over the wire
 * unchanged.
 */
enum RsvpStatus: string
{
    case Attending = 'Katılıyor';
    case Pending = 'Bekleniyor';
    case Declined = 'Katılamıyor';
}
