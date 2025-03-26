<?php

namespace App\Models;

use App\Enums\CategoryType;
use App\Traits\SimpleSearchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Sluggable\SlugOptions;
use Pishran\LaravelPersianSlug\HasPersianSlug;

class Category extends Model
{
    use SimpleSearchable , HasPersianSlug;

    public array $searchAbleColumns = ['title','slug'];

    protected $guarded = ['id'];

    public static array $cacheTags = ['category'];
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    protected $casts = [
        'type' => CategoryType::class
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class,'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class,'parent_id');
    }

    public function scopeSelect2($q)
    {
        return $q->addSelect(['title as text', 'id']);
    }

    public function points(): MorphToMany
    {
        return $this->morphToMany(Point::class,'object','object_points');
    }

}
