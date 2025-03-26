<?php

namespace App\Livewire\FAQ;

use App\Livewire\BaseComponent;
use App\Models\FAQ;

class IndexFAQ extends BaseComponent
{
    public $question , $answer;

    public function mount(): void
    {
        $this->authorizing('show_faq');
        $this->searchable = false;
    }

    public function deleteItem($id): void
    {
        $this->authorizing('delete_faq');
        FAQ::destroy($id);
    }

    public function render()
    {
        $items = FAQ::query()
            ->latest()
            ->paginate($this->per_page);
        return view('livewire.faq.index-faq' , get_defined_vars())->extends('layouts.admin');
    }

    public function store(): void
    {
        $this->validate([
            'question' => ['required','string','max:100'],
            'answer' => ['required','string','max:100000'],
        ]);
        try {
            $attributes = [
                'question' => $this->question,
                'answer' => $this->answer,
            ];
            FAQ::query()->create($attributes);
            $this->reset(['question','answer']);
            $this->dispatch('hideCollapse','create-new');
            $this->emitNotify(__('general.messages.saved-successfully'));
        } catch (\Exception $e) {
            report($e);
            $this->emitNotify(__('general.messages.error'),'warning');
        }
    }
}
