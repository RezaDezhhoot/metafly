<?php

namespace App\Livewire\Comment;


use App\Enums\CommentStatus;
use App\Livewire\BaseComponent;
use App\Models\Comment;
use Illuminate\Validation\Rule;

class StoreComment extends BaseComponent
{
    public $comment , $replyText , $status;

    public function mount($action , $id)
    {
        $this->setMode($action);
        $this->authorizing('edit_comments');
        if ($this->isUpdatingMode()) {
            $this->comment = Comment::query()->findOrFail($id);
            $this->status = $this->comment->status->value;
        } else abort(404);

        $this->data['status'] = CommentStatus::labels();
    }

    public function deleteItem(): void
    {
        $this->authorizing('delete_comments');
        $this->comment->delete();
        redirect()->route('comment.index');
    }

    public function store()
    {
        $this->validate([
            'status' => ['required',Rule::in(CommentStatus::values())]
        ]);
        $attributes = [
            'status' => $this->status
        ];
        $this->comment->fill($attributes)->save();
        $this->emitNotify(__('general.messages.saved-successfully'));
    }

    public function confirm($id): void
    {
        $this->authorizing('edit_comments');
        Comment::query()->find($id)->fill([
            'status' => CommentStatus::PUBLISHED
        ])->save();
        $this->emitNotify(__('general.messages.saved-successfully'));
    }

    public function toDraft($id): void
    {
        $this->authorizing('edit_comments');
        Comment::query()->find($id)->fill([
            'status' => CommentStatus::DRAFT
        ])->save();
        $this->emitNotify(__('general.messages.saved-successfully'));
    }

    public function submitReply(): void
    {
        $this->validate([
            'replyText' => ['required','string','max:3000']
        ]);
        $reply = new Comment();
        $reply->commentable()->associate($this->comment->commentable);
        $reply->parent()->associate($this->comment);
        $reply->fill([
                'body' => $this->replyText,
                'status' => CommentStatus::PUBLISHED,
                'user_id' => auth()->id(),
            ]
        )->save();
        $this->emitNotify(__('general.messages.saved-successfully'));
        $this->reset(['replyText']);
        $this->comment->load('replies');
    }

    public function render()
    {
        return view('livewire.comment.store-comment')->extends('layouts.admin');
    }
}
