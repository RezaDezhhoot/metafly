<?php

namespace App\Livewire\Point;

use App\Livewire\BaseComponent;
use App\Models\Point;
use Livewire\WithPagination;

class IndexPoint extends BaseComponent
{
    use WithPagination;

    public function mount()
    {
        $this->authorizing('show_points');
    }

    public function render()
    {
        $items = Point::query()
            ->latest()
            ->when($this->search , function ($q) {
                $q->search($this->search);
            })->paginate($this->per_page);

        return view('livewire.point.index-point' , get_defined_vars())->extends('layouts.admin');
    }

    public function deleteItem($id)
    {
        $this->authorizing('delete_points');
        Point::destroy($id);
    }
}
