<?php

namespace App\Traits;

use Illuminate\Contracts\Translation\Translator;
use Illuminate\Foundation\Application;

trait HasLabel
{
    /**
     * Returns enum values as an array.
     */

    abstract public function label();

    static function labels(): array
    {
        $values = [];

        foreach (self::cases() as $index => $enumCase) {
            $values[$enumCase->value] = $enumCase->label() ?? $enumCase->name;
        }

        return $values;
    }
}
