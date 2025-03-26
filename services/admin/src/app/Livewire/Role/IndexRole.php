<?php

namespace App\Livewire\Role;

use App\Livewire\BaseComponent;
use Spatie\Permission\Models\Role;

class IndexRole extends BaseComponent
{
    public function mount()
    {
        $this->authorizing('show_roles');
    }

    public function remove($id): void
    {
        $this->authorizing('delete_roles');
        Role::query()->whereNotIn('name',['admin','administrator'])->where('id',$id)->delete();
    }

    public function render()
    {
        $roles = Role::query()
            ->latest()
            ->get();
        return view('livewire.role.index-role' , get_defined_vars())->extends('layouts.admin');
    }
}
