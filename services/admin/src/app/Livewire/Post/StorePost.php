<?php

namespace App\Livewire\Post;

use App\Enums\PostStatus;
use App\Livewire\BaseComponent;
use App\Models\Post;
use Illuminate\Validation\Rule;

class StorePost extends BaseComponent
{
    public $post , $title , $sub_title , $study_time , $content = []  , $image , $status;

    public $categories ;

    public $seo_keywords , $seo_description;

    public $slider = false;

    public string $tab = 'post';

    protected function queryString()
    {
        return [
            'tab' => [
                'as' => 'tab',
            ],
        ];
    }

    public function mount($action , $id = null)
    {
        $this->setMode($action);
        if ($this->isUpdatingMode()) {
            $this->authorizing('edit_blogs');
            $this->post = Post::query()->with(['categories','topics'])->findOrFail($id);
            $this->title = $this->post->title;
            $this->sub_title = $this->post->sub_title;
            $this->study_time = $this->post->study_time;
            $this->content = $this->post->content ?? [];
            $this->image = $this->post->image;
            $this->seo_keywords = $this->post->seo_keywords;
            $this->slider = $this->post->slider;
            $this->seo_description = $this->post->seo_description;
            $this->status = $this->post->status->value;
            $this->header = $this->title;
        } elseif ($this->isCreatingMode()) {
            $this->authorizing('create_blogs');
            $this->header = __('pages.pages.create' , ['item' => __('general.sidebar.post')]);
            $this->status = PostStatus::PUBLISHED->value;
            $this->study_time = 1;
        }
        $this->data['status'] = PostStatus::labels();
    }

    public function store()
    {
        $this->validate([
            'title' => ['required','string','max:250'],
            'sub_title' => ['nullable','string','max:250'],
            'study_time' => ['required','integer','between:1,100000000'],
            'content' => ['required','array','min:1','max:15'],
            'content.*.title' => ['required','string','max:100'],
            'content.*.body' => ['required','string','max:900000000'],
            'image' => ['required','string','max:10050'],
            'status' => ['required',Rule::enum(PostStatus::class)],
            'seo_keywords' => ['required','string','max:500'],
            'seo_description' => ['required','string','max:10000'],
            'categories' => ['nullable','array','max:50'],
            'categories.*' => ['required','exists:categories,id'],
            'slider' => ['nullable','boolean']
        ]);
        $model = $this->post ?: new Post;
        $data = [
            'title' => $this->title,
            'sub_title' => $this->sub_title,
            'study_time' => $this->study_time,
            'content' => $this->content,
            'image' => $this->image,
            'status' => $this->status,
            'seo_keywords' => $this->seo_keywords,
            'seo_description' => $this->seo_description,
            'slider' => emptyToNull($this->slider) ?? false,
        ];
        if (! $model->id) {
            $model->author()->associate(auth()->user());
        }
        try {
            $model->fill($data)->save();
            if ($model->wasRecentlyCreated) {
                $model->categories()->attach($this->categories);
            } else {
                $model->categories()->sync($this->categories);
            }
            $this->emitNotify(__('general.messages.saved-successfully'));
            $this->dispatch('saveTopics' , $model->id , $model::class);
            redirect()->route('post.index');
        } catch (\Exception $exception) {
            report($exception);
            $this->emitNotify(__('general.messages.error'),'warning');
        }
    }

    public function addContent(): void
    {
        $this->content[] = [
            'title' => null,
            'body' => null
        ];
    }

    public function deleteContent($key): void
    {
        unset($this->content[$key]);
    }

    public function render()
    {
        return view('livewire.post.store-post')->extends('layouts.admin');
    }
}
