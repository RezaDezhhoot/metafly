<?php

namespace App\Enums;

use App\Traits\EnumHelpers;
use App\Traits\HasLabel;

enum TransportType: string
{
    use EnumHelpers , HasLabel;

    case AIRLINE = "airline";
    case RAILROAD = "railroad";

    case ROADWAY = "roadway";

    case SEAWAY = "seaway";

    public function label()
    {
        return match ($this) {
            self::AIRLINE => __('general.airline'),
            self::RAILROAD => __('general.railroad'),
            self::ROADWAY => __('general.roadway'),
            self::SEAWAY => __('general.seaway'),
        };
    }

    public function icon()
    {
        return match ($this) {
            self::SEAWAY => "fas fa-ship",
            self::RAILROAD => "fas fa-train",
            self::ROADWAY => "fas fa-bus",
            self::AIRLINE => "fas fa-plane",
        };
    }
}
