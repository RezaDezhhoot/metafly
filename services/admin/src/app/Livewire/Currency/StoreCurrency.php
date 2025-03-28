<?php

namespace App\Livewire\Currency;

use App\Livewire\BaseComponent;
use App\Models\Currency;

class StoreCurrency extends BaseComponent
{
    public $currency , $title , $symbol , $amount , $image;

    public function mount($action , $id = null)
    {
        $this->setMode($action);
        if ($this->isUpdatingMode()) {
            $this->authorizing('edit_currencies');
            $this->currency = Currency::query()->findOrFail($id);
            $this->title = $this->currency->title;
            $this->symbol = $this->currency->symbol;
            $this->amount = $this->currency->amount;
            $this->image = $this->currency->image;
            $this->header = $this->title;
        } elseif ($this->isCreatingMode()) {
            $this->authorizing('create_currencies');
            $this->header = __('pages.pages.create' , ['item' => __('general.sidebar.currency')]);
        } else abort(404);
    }

    public function store()
    {
        $this->validate([
            'title' => ['required','string','max:50'],
            'symbol' => ['required','string','max:5'],
            'amount' => ['required','integer','between:0,1000000000000000'],
            'image' => ['required','string','max:1000000000']
        ]);
        $model = $this->currency ?: new Currency;
        $data = [
            'title' => $this->title,
            'symbol' => $this->symbol,
            'amount' => $this->amount,
            'image' => $this->image
        ];
        try {
            $model->fill($data)->save();
            $this->emitNotify(__('general.messages.saved-successfully'));
            redirect()->route('currency.index');
        } catch (\Exception $exception) {
            report($exception);
            $this->emitNotify(__('general.messages.error'),'warning');
        }
    }

    public function deleteItem()
    {
        $this->authorizing('delete_currencies');
        if ($this->isUpdatingMode()) {
            $this->currency->delete();
            redirect()->route('currency.index');
        }
    }

    public function render()
    {
        return view('livewire.currency.store-currency')->extends('layouts.admin');
    }
}
