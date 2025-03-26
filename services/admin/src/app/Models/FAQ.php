<?php

namespace App\Models;

use App\Traits\SimpleSearchable;
use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    use SimpleSearchable;
    public array $searchAbleColumns = ['question'];

    protected $guarded = ['id'];

    protected $table = 'faq';
}
