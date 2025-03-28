<?php

use Illuminate\Support\Facades\Route;

Route::group(['as' => 'auth.','prefix' => 'auth'],function (){
    Route::get('login',\App\Livewire\Auth\Login::class)->name('login')->middleware('guest');
    Route::get('logout',\App\Livewire\Auth\Logout::class)->name('logout')->middleware('auth');
});

Route::group(['as' => 'dashboard','middleware' => ['auth','role:admin']],function (){
    Route::get('/', \App\Livewire\Dashboard\Dashboard::class);
});

Route::group(['as' => 'lfm' , 'prefix' => 'fm','middleware' => ['auth','role:admin']],function (){
    Route::get('/', \App\Livewire\Lfm::class);
});

Route::group(['as' => 'topic.' , 'prefix' => 'topics','middleware' => ['auth','role:admin']] , function (){
    Route::get('/', \App\Livewire\Topic\IndexTopicComponent::class)->name('index');
    Route::get('/feed', \App\Http\Controllers\Feed\TopicFeedController::class)->name('feed');
    Route::get('/forms/{action}/{id?}', \App\Livewire\Topic\StoreTopicComponent::class)->name('store');
});

Route::group(['as' => 'category.' , 'prefix' => 'categories/{type}','middleware' => ['auth','role:admin']] , function (){
    Route::get('/', \App\Livewire\Category\IndexCategoryComponent::class)->name('index');
    Route::get('/feed/{parent?}', \App\Http\Controllers\Feed\CategoryFeedController::class)->name('feed');
    Route::get('/forms/{action}/{id?}', \App\Livewire\Category\StoreCategoryComponent::class)->name('store');
});

Route::group(['as' => 'point.' , 'prefix' => 'points','middleware' => ['auth','role:admin']] , function (){
    Route::get('/', \App\Livewire\Point\IndexPoint::class)->name('index');
    Route::get('/forms/{action}/{id?}', \App\Livewire\Point\StorePoint::class)->name('store');
    Route::get('/feed', \App\Http\Controllers\Feed\PointFeedController::class)->name('feed');
});

Route::group(['as' => 'transport.' , 'prefix' => 'transports','middleware' => ['auth','role:admin']] , function (){
    Route::get('/', \App\Livewire\Transport\IndexTransport::class)->name('index');
    Route::get('/forms/{action}/{id?}', \App\Livewire\Transport\StoreTransport::class)->name('store');
});

Route::group(['as' => 'post.' , 'prefix' => 'posts','middleware' => ['auth','role:admin']] , function (){
    Route::get('/', \App\Livewire\Post\IndexPost::class)->name('index');
    Route::get('/{action}/{id?}', \App\Livewire\Post\StorePost::class)->name('store');
});

Route::group(['as' => 'user.' , 'prefix' => 'users','middleware' => ['auth','role:admin']] , function (){
    Route::get('/', \App\Livewire\User\IndexUser::class)->name('index');
    Route::get('/forms/{action}/{id?}', \App\Livewire\User\StoreUser::class)->name('store');
});

Route::group(['as' => 'role.' , 'prefix' => 'roles','middleware' => ['auth','role:admin']] , function (){
    Route::get('/', \App\Livewire\Role\IndexRole::class)->name('index');
    Route::get('/forms/{action}/{id?}', \App\Livewire\Role\StoreRole::class)->name('store');
    Route::get('/feed', \App\Http\Controllers\Feed\RoleFeedController::class)->name('feed');
});

Route::group(['as' => 'comment.' , 'prefix' => 'comments','middleware' => ['auth','role:admin']] , function (){
    Route::get('/', \App\Livewire\Comment\IndexComment::class)->name('index');
    Route::get('/{action}/{id?}', \App\Livewire\Comment\StoreComment::class)->name('store');
});

Route::group(['as' => 'faq.' , 'prefix' => 'faq','middleware' => ['auth','role:admin']] , function (){
    Route::get('/', \App\Livewire\FAQ\IndexFAQ::class)->name('index');
    Route::get('/{action}/{id?}', \App\Livewire\FAQ\StoreFAQ::class)->name('store');
});

Route::group(['as' => 'currency.' , 'prefix' => 'currencies','middleware' => ['auth','role:admin']] , function (){
    Route::get('/', \App\Livewire\Currency\IndexCurrency::class)->name('index');
    Route::get('/{action}/{id?}', \App\Livewire\Currency\StoreCurrency::class)->name('store');
});

Route::group(['as' => 'settings.' , 'prefix' => 'settings','middleware' => ['auth','role:admin']] , function (){
    Route::get('/base', \App\Livewire\Settings\BaseSettings::class)->name('base');
    Route::get('/contact', \App\Livewire\Settings\ContactSettings::class)->name('contact');
    Route::get('/footer', \App\Livewire\Settings\FooterSettings::class)->name('footer');
    Route::get('/landing', \App\Livewire\Settings\LandingSettings::class)->name('landing');
});
