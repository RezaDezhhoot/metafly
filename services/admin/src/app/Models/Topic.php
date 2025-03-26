<?php

namespace App\Models;

use App\Traits\SimpleSearchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory , SimpleSearchable ;

    protected array $searchAbleColumns = ['title'];

    protected $guarded = ['id'];

    public function scopeSelect2($q)
    {
        return $q->select(['id','title as text']);
    }
}
