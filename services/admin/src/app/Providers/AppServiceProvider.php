<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Relation::enforceMorphMap([
            'category' => 'App\Models\Category',
            'post' => 'App\Models\Post',
            'point' => 'App\Models\Point',
            'settings' => 'App\Models\Settings',
            'topic' => 'App\Models\Topic',
            'transport' => 'App\Models\Transport',
            'user' => 'App\Models\User',
        ]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
