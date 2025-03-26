<?php

namespace App\Livewire;
class Lfm extends BaseComponent
{
    public function mount()
    {
        $this->header =  __('general.sidebar.lfm');
    }

    public function render()
    {
        return view('livewire.base.lfm')->extends('layouts.admin');
    }
}
