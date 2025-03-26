<?php

namespace App\Livewire\Post;

use App\Enums\PostStatus;
use App\Livewire\BaseComponent;
use App\Models\Post;

class IndexPost extends BaseComponent
{
    public $status , $category;

    public $slider ;

    public function mount()
    {
        $this->authorizing('show_blogs');
        $this->data['status'] = PostStatus::labels();
        $this->sortable = true;
        $this->data['sort_by'] = [
            'id' => __('general.id'),
            'created_at' => __('general.created_at'),
            'views' => __('general.views'),
        ];
    }

    public function render()
    {
        $items = Post::query()
            ->latest()
            ->with(['author','categories'])
            ->when($this->category && sizeof($this->category) > 0 , function ($q) {
                $q->whereHas('categories' , function ($q) {
                    $q->whereIn('category_id' , $this->category);
                });
            })
            ->when($this->slider, function ($q){
                $q->where('slider' , $this->slider);
            })
            ->when($this->search , function ($q) {
                $q->search($this->search);
            })->when($this->status , function ($q){
                $q->where('status' , $this->status);
            })->orderBy($this->sort ?? 'id' , $this->direction ?? 'desc')->paginate($this->per_page);
        return view('livewire.post.index-post' , get_defined_vars())->extends('layouts.admin');
    }

    public function deleteItem($id)
    {
        $this->authorizing('delete_blogs');
        Post::destroy($id);
    }
}
