<?php

namespace App\Livewire\Dashboard;

use App\Livewire\BaseComponent;

class Dashboard extends BaseComponent
{
    public function mount()
    {

    }
    public function render()
    {
        return view('livewire.dashboard.dashboard')->extends('layouts.admin');
    }
}
