<?php

namespace App\Enums;

use App\Traits\EnumHelpers;
use App\Traits\HasLabel;

enum PostStatus: string
{
    use EnumHelpers , HasLabel;
    case PUBLISHED = "published";
    case DRAFT = "draft";


    public function label()
    {
        return match ($this) {
            self::DRAFT => __('general.draft'),
            self::PUBLISHED => __('general.published'),
        };
    }
}
