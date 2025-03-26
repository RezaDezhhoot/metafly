<?php

namespace App\Livewire\Topic;


use App\Livewire\BaseComponent;
use App\Models\Topic;

class StoreTopicComponent extends BaseComponent
{
    public $title , $topic;

    public function mount($action , $id = null): void
    {
        $this->setMode($action);
        if ($this->isUpdatingMode()) {
            $this->authorizing('edit_topics');
            $this->topic = Topic::query()->findOrFail($id);
            $this->title = $this->topic->title;
            $this->header = $this->topic->title;
        } elseif ($this->isCreatingMode()) {
            $this->authorizing('create_topics');
            $this->header = __('pages.pages.create' , ['item' => __('general.sidebar.topic')]);
        } else abort(404);
    }

    public function render()
    {
        return view('livewire.topic.store-topic-component')->extends('layouts.admin');
    }

    public function store(): void
    {
        if ($this->isUpdatingMode()) {
            $this->saveInDB($this->topic);
        } elseif ($this->isCreatingMode()){
            $this->saveInDB(new Topic);
        }
    }

    private function saveInDB(Topic $model): void
    {
        $this->validate([
            'title' => ['required','string','max:150']
        ]);
        $data = [
            'title' => $this->title
        ];
        try {
            $model->fill($data)->save();
            $this->emitNotify(__('general.messages.saved-successfully'));
            redirect()->route('topic.index');
        } catch (\Exception $exception) {
            report($exception);
            $this->emitNotify(__('general.messages.error'),'warning');
        }
    }

    public function deleteItem()
    {
        $this->authorizing('delete_topics');
        if ($this->isUpdatingMode() && $this->topic->remove($this->topic->id)) {
            return redirect()->route('topic.index');
        }
    }
}
