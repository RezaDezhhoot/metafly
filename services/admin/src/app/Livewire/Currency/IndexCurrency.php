<?php

namespace App\Livewire\Currency;

use App\Livewire\BaseComponent;
use App\Models\Currency;
use Livewire\WithPagination;

class IndexCurrency extends BaseComponent
{
    use WithPagination;

    public function mount()
    {
        $this->authorizing('show_currencies');
    }

    public function render()
    {
        $items = Currency::query()
            ->latest()
            ->when($this->search , function ($q){
                $q->search($this->search);
            })->paginate($this->per_page);
        return view('livewire.currency.index-currency' , get_defined_vars())->extends('layouts.admin');
    }

    public function deleteItem($id)
    {
        $this->authorizing('delete_currencies');
        Currency::destroy($id);
    }
}
