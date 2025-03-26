<?php

namespace App\Enums;

use App\Traits\EnumHelpers;
use App\Traits\HasLabel;

enum CommentStatus: string
{
    use HasLabel , EnumHelpers;

    case PUBLISHED = 'published';
    case DRAFT = 'draft';

    public function label(): string
    {
        return match ($this) {
            self::PUBLISHED => __('enums.comment.status.published'),
            self::DRAFT => __('enums.comment.status.draft'),
        };
    }
}
