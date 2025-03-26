<?php

namespace App\Livewire\Transport;

use App\Enums\TransportStatus;
use App\Enums\TransportType;
use App\Livewire\BaseComponent;
use App\Models\Transport;
use Livewire\WithPagination;

class IndexTransport extends BaseComponent
{
    use WithPagination;

    public $type , $status;

    public function mount()
    {
        $this->authorizing('show_transports');
        $this->data['type'] = TransportType::labels();
        $this->data['status'] = TransportStatus::labels();
    }

    public function render()
    {
        $items = Transport::query()
            ->latest()
            ->when($this->search , function ($q) {
                $q->search($this->search);
            })->when($this->type , function ($q) {
                $q->where('type' , $this->type);
            })->when($this->status , function ($q) {
                $q->where('status' , $this->status);
            })->paginate($this->per_page);

        return view('livewire.transport.index-transport' , get_defined_vars())->extends('layouts.admin');
    }

    public function deleteItem($id)
    {
        $this->authorizing('delete_transports');
        Transport::destroy($id);
    }
}
