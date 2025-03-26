<?php

namespace App\Livewire\Settings;

use App\Livewire\BaseComponent;
use App\Models\Settings;

class BaseSettings extends BaseComponent
{
    public $title , $description , $keywords , $logo;


    public function mount()
    {
        $items = Settings::query()->whereIn('name',['title','description','keywords','logo'])->get()->pluck('value','name');
        $this->title  = $items['title'] ?? null;
        $this->description  = $items['description'] ?? null;
        $this->keywords  = $items['keywords'] ?? null;
        $this->logo  = $items['logo'] ?? null;
    }

    public function store()
    {
        $this->validate([
            'title' => ['required','string','max:100'],
            'description' => ['required','string','max:1000'],
            'keywords' => ['required','string','max:1000'],
            'logo' => ['required','string','max:10000'],
        ]);
        Settings::query()->updateOrCreate(['name' => 'title'] , ['value' => $this->title]);
        Settings::query()->updateOrCreate(['name' => 'description'] , ['value' => $this->description]);
        Settings::query()->updateOrCreate(['name' => 'keywords'] , ['value' => $this->keywords]);
        Settings::query()->updateOrCreate(['name' => 'logo'] , ['value' => $this->logo]);
        $this->emitNotify(__('general.messages.saved-successfully'));
    }

    public function render()
    {
        return view('livewire.settings.base-settings')->extends('layouts.admin');
    }
}
