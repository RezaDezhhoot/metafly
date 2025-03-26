<?php

namespace App\Livewire\Topic;

use App\Livewire\BaseComponent;
use App\Models\Topic;
use Livewire\WithPagination;

class IndexTopicComponent extends BaseComponent
{
    use WithPagination;

    public function mount(): void
    {
        $this->authorizing('show_topics');
    }

    public function render()
    {
        $items = Topic::query()
            ->when($this->search , function ($q) {
                $q->search($this->search);
            })->paginate($this->per_page);

        return view('livewire.topic.index-topic-component' , get_defined_vars())->extends('layouts.admin');
    }

    public function remove($id): void
    {
        $this->authorizing('delete_topics');
        Topic::destroy($id);
    }
}
