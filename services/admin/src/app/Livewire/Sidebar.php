<?php

namespace App\Livewire;

use App\Enums\CommentStatus;
use App\Models\Comment;
use Livewire\Component;

class Sidebar extends Component
{
    public function render( )
    {
        $data = [
            'comments' => Comment::query()->where('status',CommentStatus::DRAFT)->count()
        ];
        return view('livewire.base.sidebar',$data);
    }
}
