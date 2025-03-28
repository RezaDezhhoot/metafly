<?php

namespace App\Models;

use App\Traits\SimpleSearchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    use SoftDeletes;

    use SimpleSearchable;
    public array $searchAbleColumns = ['title'];

    protected $guarded = ['id'];

}
