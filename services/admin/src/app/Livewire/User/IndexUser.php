<?php

namespace App\Livewire\User;

use App\Livewire\BaseComponent;
use App\Models\User;
use Livewire\WithPagination;

class IndexUser extends BaseComponent
{
    use WithPagination;

    public function mount()
    {
        $this->authorizing('show_users');
    }

    public function render()
    {
        $items = User::query()
            ->with(['roles'])
            ->latest()
            ->when($this->search , function ($q) {
                $q->search($this->search);
            })->paginate($this->per_page);

        return view('livewire.users.index-user' , get_defined_vars())->extends('layouts.admin');
    }
}
