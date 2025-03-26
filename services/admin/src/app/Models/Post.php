<?php

namespace App\Models;

use App\Enums\PostStatus;
use App\Traits\SimpleSearchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Pishran\LaravelPersianSlug\HasPersianSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model
{
    protected $guarded = ['id'];

    use HasPersianSlug , SimpleSearchable;

    public array $searchAbleColumns = ['title','slug'];

    protected $casts = [
        'status' => PostStatus::class,
        'content' => "array",
        'slider' => 'boolean'
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }


    public function categories(): MorphToMany
    {
        return $this->morphToMany(Category::class,'categoryable','categoryables');
    }

    public function topics(): MorphToMany
    {
        return $this->morphToMany(Topic::class,'topicable','topicables');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
