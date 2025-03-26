<?php

namespace App\Livewire\Point;

use App\Enums\Countries;
use App\Livewire\BaseComponent;
use App\Models\Point;
use Illuminate\Validation\Rule;

class StorePoint extends BaseComponent
{
    public $point , $country , $city , $image , $longitude , $latitude;
    public function mount($action , $id = null)
    {
        $this->setMode($action);
        if ($this->isUpdatingMode()) {
            $this->authorizing('edit_points');
            $this->point = Point::query()->findOrFail($id);
            $this->country = $this->point->country?->value;
            $this->city = $this->point->city;
            $this->image = $this->point->image;
            $this->latitude = $this->point->latitude;
            $this->longitude = $this->point->longitude;
            $this->header = sprintf("%s-%s" , $this->point->country?->label() , $this->city);
        } elseif ($this->isCreatingMode()) {
            $this->authorizing('create_points');
            $this->header = __('pages.pages.create' , ['item' => __('general.sidebar.point')]);
        } else abort(404);
        $this->data['country'] = Countries::labels();
    }


    public function store()
    {
        $model = $this->point ?: new Point();
        $this->validate([
            'country' => ['required',Rule::enum(Countries::class)],
            'city' => ['required','string','max:100'],
            'image' => ['required','string','max:50000'],
        ]);
        $data = [
            'country' => $this->country,
            'city' => $this->city,
            'image' => $this->image
        ];
        try {
            $model->fill($data)->save();
            $this->emitNotify(__('general.messages.saved-successfully'));
            redirect()->route('point.index');
        } catch (\Exception $exception) {
            report($exception);
            $this->emitNotify(__('general.messages.error'),'warning');
        }
    }

    public function deleteItem(): void
    {
        $this->authorizing('delete_points');
        if ($this->isUpdatingMode()) {
            $this->point->delete();
            redirect()->route('point.index');
        }
    }

    public function render()
    {
        return view('livewire.point.store-point')->extends('layouts.admin');
    }
}
