<?php

namespace App\Livewire\Topic;

use App\Livewire\BaseComponent;
use App\Models\Topic;

class TopicFormComponent extends BaseComponent
{
    public $topics = [];
    public $oldTopics = [];

    public $topicable = null;

    public $title;

    protected $listeners = ['saveTopics' => 'attachTopics'];


    public function mount($topicable = null): void
    {
        $this->topicable = $topicable;
        if ($this->topicable) {
            $this->oldTopics = $this->topicable->topics->toArray();
        }
    }

    public function attachTopics($topicable_id , $model): void
    {
        $model::find($topicable_id)
            ->topics()
            ->sync($this->topics);
    }

    public function addTopic(): void
    {
        $this->validate([
            'title' => ['required','string','max:100']
        ]);
        $topic = Topic::query()->create(['title' => $this->title]);
        $this->dispatch('attachSelect2#topics' , $topic->toArray());
        $this->reset('title');
    }

    public function render()
    {
        return view('livewire.topic.topic-form-component');
    }
}
