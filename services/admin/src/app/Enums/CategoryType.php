<?php

namespace App\Enums;

use App\Traits\EnumHelpers;
use App\Traits\HasLabel;

enum CategoryType: string
{
    use HasLabel , EnumHelpers;

    case POST = 'post';
    case HOTEL = 'hotel';
    case TOUR = 'tour';

    public function label()
    {
        return match ($this) {
            self::HOTEL => __('general.hotel'),
            self::POST => __('general.post'),
            self::TOUR => __('general.tour'),
        };
    }
}
