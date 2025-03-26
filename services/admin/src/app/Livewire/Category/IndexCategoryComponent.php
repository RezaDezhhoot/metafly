<?php

namespace App\Livewire\Category;

use App\Livewire\BaseComponent;
use App\Models\Category;
use Livewire\WithPagination;

class IndexCategoryComponent extends BaseComponent
{
    use WithPagination;

    public $type;

    public function mount($type)
    {
        $this->authorizing('show_categories');
        $this->type = $type;
        $this->sortable = true;
        $this->data['sort_by'] = [
            'id' => __('general.id'),
            'created_at' => __('created_at')
        ];
    }

    public function render()
    {
        $items = Category::query()->with(['parent','points'])->when($this->search , function ($q) {
            $q->search($this->search);
        })->when($this->type , function ($q) {
            $q->where('type',$this->type);
        })->orderBy($this->sort ?? 'id' , $this->direction ?? 'desc')->paginate($this->per_page);

        return view('livewire.category.index-category-component' , get_defined_vars())->extends('layouts.admin');
    }

    public function deleteItem($id)
    {
        $this->authorizing('delete_categories');
        Category::destroy($id);
    }
}
