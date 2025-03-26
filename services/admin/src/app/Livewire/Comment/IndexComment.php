<?php

namespace App\Livewire\Comment;

use App\Enums\CommentStatus;
use App\Livewire\BaseComponent;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;

class IndexComment extends BaseComponent
{
    use WithPagination;

    public $status;

    public function mount(): void
    {
        $this->authorizing('show_comments');
        $this->data['status'] = CommentStatus::labels();
        $this->searchable = false;
    }

    public function deleteItem($id): void
    {
        $this->authorizing('delete_comments');
        Comment::destroy($id);
    }

    public function confirm($id): void
    {
        $this->authorizing('edit_comments');
        Comment::query()->find($id)->fill([
            'status' => CommentStatus::PUBLISHED
        ])->save();
    }

    public function render()
    {
        $items = Comment::query()
            ->orderByDesc('new_replies_count')
            ->withCount(['replies','newReplies'])
            ->when($this->status , function ($q) {
                $q->where('status' , $this->status);
            })->with(['commentable'])
            ->where(function (Builder $builder) {
                $builder->whereNull('reply_on')->orWhereHas('replies');
            })
            ->paginate($this->per_page);
        return view('livewire.comment.index-comment', get_defined_vars())->extends('layouts.admin');
    }
}
