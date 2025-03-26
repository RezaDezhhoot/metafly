<?php

namespace App\Livewire\FAQ;

use App\Livewire\BaseComponent;
use App\Models\FAQ;

class StoreFAQ extends BaseComponent
{
    public $faq , $question , $answer;

    public function mount($action , $id = null)
    {
        $this->setMode($action);
        if ($this->isUpdatingMode()) {
            $this->authorizing('edit_faq');
            $this->faq = FAQ::query()->findOrFail($id);
            $this->question = $this->faq->question;
            $this->answer = $this->faq->answer;
        } elseif ($this->isCreatingMode()) {
            $this->authorizing('create_faq');
        } else abort(404);
        $this->header = __('pages.pages.create' , ['item' => __('general.sidebar.faq')]);
    }

    public function store()
    {
        $this->validate([
            'question' => ['required','string','max:100'],
            'answer' => ['required','string','max:100000'],
        ]);
        $faq = $this->faq;
        $attributes = [
            'question' => $this->question,
            'answer' => $this->answer,
        ];
        try {
            $faq->save($attributes);
            $this->emitNotify(__('general.messages.saved-successfully'));
            redirect()->route('faq.index');
        } catch (\Exception $e) {
            report($e);
            $this->emitNotify(__('general.messages.error'),'warning');
        }
    }

    public function render()
    {
        return view('livewire.faq.store-faq')->extends('layouts.admin');
    }
}
