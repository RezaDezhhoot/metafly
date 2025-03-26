<?php

namespace App\Models;

use App\Enums\TransportStatus;
use App\Enums\TransportType;
use App\Traits\SimpleSearchable;
use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    use SimpleSearchable;

    public array $searchAbleColumns = ['title'];

    protected $guarded = ['id'];

    protected $casts = [
        'type' => TransportType::class,
        'status' => TransportStatus::class
    ];
}
