<?php

namespace App\Livewire\Settings;

use App\Livewire\BaseComponent;

class LandingSettings extends BaseComponent
{
    public function render()
    {
        return view('livewire.settings.landing-settings')->extends('layouts.admin');
    }
}
