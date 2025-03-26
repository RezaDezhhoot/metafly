<?php

namespace App\Models;

use App\Enums\Countries;
use App\Traits\SimpleSearchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    use HasFactory , SimpleSearchable ;

    protected array $searchAbleColumns = ['country','city'];

    protected $guarded = ['id'];

    protected $casts = [
        'country' => Countries::class
    ];

    public function scopeSelect2($q)
    {
        return $q->selectRaw("CONCAT(points.country,' | ',points.city) as text , points.id");
    }
}
