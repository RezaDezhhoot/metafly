<?php

namespace App\Livewire\Settings;

use App\Livewire\BaseComponent;
use App\Models\Settings;

class ContactSettings extends BaseComponent
{
    public $aboutUs , $address , $phone1 , $phone2 , $location;

    public function mount()
    {
        $items = Settings::query()->whereIn('name',['aboutUs','address','phone1','phone2','location'])->get()->pluck('value','name');
        $this->aboutUs  = $items['aboutUs'] ?? null;
        $this->address  = $items['address'] ?? null;
        $this->phone1  = $items['phone1'] ?? null;
        $this->phone2  = $items['phone2'] ?? null;
        $this->location  = $items['location'] ?? null;
    }

    public function store()
    {
        $this->validate([
            'aboutUs' => ['required','string','max:1500000000'],
            'address' => ['required','string','max:150000'],
            'phone1' => ['required','string','max:400'],
            'phone2' => ['required','string','max:400'],
            'location' => ['required','string','max:100000000000000'],
        ]);
        Settings::query()->updateOrCreate(['name' => 'aboutUs'] , ['value' => $this->aboutUs]);
        Settings::query()->updateOrCreate(['name' => 'address'] , ['value' => $this->address]);
        Settings::query()->updateOrCreate(['name' => 'phone1'] , ['value' => $this->phone1]);
        Settings::query()->updateOrCreate(['name' => 'phone2'] , ['value' => $this->phone2]);
        Settings::query()->updateOrCreate(['name' => 'location'] , ['value' => $this->location]);
        $this->emitNotify(__('general.messages.saved-successfully'));
    }

    public function render()
    {
        return view('livewire.settings.contact-settings')->extends('layouts.admin');
    }
}
