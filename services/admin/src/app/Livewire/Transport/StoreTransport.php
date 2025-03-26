<?php

namespace App\Livewire\Transport;

use App\Enums\TransportStatus;
use App\Enums\TransportType;
use App\Livewire\BaseComponent;
use App\Models\Transport;
use Illuminate\Validation\Rule;

class StoreTransport extends BaseComponent
{
    public $transport , $title , $type , $status , $logo;

    public function mount($action , $id = null)
    {
        $this->authorizing('edit_transports');
        $this->setMode($action);
        if ($this->isUpdatingMode()) {
            $this->transport = Transport::query()->findOrFail($id);
            $this->title = $this->transport->title;
            $this->type = $this->transport->type;
            $this->status = $this->transport->status;
            $this->logo = $this->transport->logo;
            $this->header = $this->title;
        } elseif ($this->isCreatingMode()) {
            $this->authorizing('create_transports');
            $this->header = __('pages.pages.create' , ['item' => __('general.sidebar.transport')]);
        } else abort(404);
        $this->data['type'] = TransportType::labels();
        $this->data['status'] = TransportStatus::labels();
    }

    public function store()
    {
        $this->validate([
            'title' => ['required','string','max:150'],
            'type' => ['required',Rule::enum(TransportType::class)],
            'status' => ['required',Rule::enum(TransportStatus::class)],
            'logo' => ['required','string','max:150000']
        ]);
        $data = [
            'title' => $this->title,
            'type' => $this->type,
            'status' => $this->status,
            'logo' => $this->logo
        ];
        $model = $this->transport ?: new Transport;
        try {
            $model->fill($data)->save();
            $this->emitNotify(__('general.messages.saved-successfully'));
            redirect()->route('transport.index');
        } catch (\Exception $exception) {
            report($exception);
            $this->emitNotify(__('general.messages.error'),'warning');
        }
    }

    public function render()
    {
        return view('livewire.transport.store-transport')->extends('layouts.admin');
    }
}
