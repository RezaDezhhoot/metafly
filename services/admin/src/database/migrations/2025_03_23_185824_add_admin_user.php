<?php

use Database\Seeders\UserSeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \Illuminate\Support\Facades\Artisan::call('db:seed', [
            '--class' => UserSeeder::class,
            '--force' => true
        ]);
        \Illuminate\Support\Facades\Artisan::call('app:sync-role');
    }
};
