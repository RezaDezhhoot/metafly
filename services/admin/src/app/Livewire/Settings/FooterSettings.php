<?php

namespace App\Livewire\Settings;

use App\Livewire\BaseComponent;
use App\Models\Settings;

class FooterSettings extends BaseComponent
{
    public $email , $footerText , $signs = [];

    public $telegram , $whatsapp , $youtube , $instagram;

    public function mount()
    {
        $items = Settings::query()->whereIn('name',['email','footerText','signs','telegram','whatsapp','youtube','instagram'])->get()->pluck('value','name');
        $this->email  = $items['email'] ?? null;
        $this->footerText  = $items['footerText'] ?? null;
        $this->signs  = $items['signs'] ?? [];

        $this->telegram  = $items['telegram'] ?? null;
        $this->whatsapp  = $items['whatsapp'] ?? null;
        $this->youtube  = $items['youtube'] ?? null;
        $this->instagram  = $items['instagram'] ?? null;
    }

    public function store()
    {
        $this->validate([
            'email' => ['required','email','max:1500000000'],
            'footerText' => ['required','string','max:1500000000'],
            'signs' => ['array','nullable','min:0','max:25'],

            'telegram' => ['nullable','string','max:15000'],
            'whatsapp' => ['nullable','string','max:15000'],
            'youtube' => ['nullable','string','max:15000'],
            'instagram' => ['nullable','string','max:15000'],
        ]);
        Settings::query()->updateOrCreate(['name' => 'email'] , ['value' => $this->email]);
        Settings::query()->updateOrCreate(['name' => 'footerText'] , ['value' => $this->footerText]);
        Settings::query()->updateOrCreate(['name' => 'signs'] , ['value' => json_encode($this->signs)]);

        Settings::query()->updateOrCreate(['name' => 'telegram'] , ['value' => emptyToNull($this->telegram)]);
        Settings::query()->updateOrCreate(['name' => 'whatsapp'] , ['value' => emptyToNull($this->whatsapp)]);
        Settings::query()->updateOrCreate(['name' => 'youtube'] , ['value' => emptyToNull($this->youtube)]);
        Settings::query()->updateOrCreate(['name' => 'instagram'] , ['value' => emptyToNull($this->instagram)]);


        $this->emitNotify(__('general.messages.saved-successfully'));
    }

    public function addSign(): void
    {
        $this->signs[] = null;
    }

    public function deleteSign($key): void
    {
        unset($this->signs[$key]);
    }

    public function render()
    {
        return view('livewire.settings.footer-settings')->extends('layouts.admin');
    }
}
