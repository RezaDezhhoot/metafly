<?php

namespace App\Livewire\Category;

use App\Enums\CategoryType;
use App\Livewire\BaseComponent;
use App\Models\Category;
use Illuminate\Validation\Rule;

class StoreCategoryComponent extends BaseComponent
{
    public $category , $title , $image , $type ,$parent , $points = [];

    public function mount($type,$action , $id = null): void
    {
        $this->type = $type;
        $this->setMode($action);
        if ($this->isUpdatingMode()) {
            $this->authorizing('edit_categories');
            $this->category = Category::query()->with(['parent' ,'points' => function ($q) {
                $q->select2();
            }])->findOrFail($id);
            $this->title = $this->category->title;
            $this->image = $this->category->image;
            $this->header = $this->title;
        } elseif ($this->isCreatingMode()) {
            $this->authorizing('create_categories');
            $this->header = CategoryType::from($type)->label().' '.__('pages.pages.create' , ['item' => __('general.sidebar.category')]);
        } else abort(404);
    }


    public function store(): void
    {
        if ($this->isCreatingMode()) {
            $this->saveInDB(new Category());
        } elseif ($this->isUpdatingMode()) {
            $this->saveInDB($this->category);
        }
    }

    private function saveInDB(Category $model)
    {
        $this->validate([
            'title' => ['required','string','max:60'],
            'type' => ['required',Rule::in(CategoryType::values())],
            'image' => ['nullable','string','max:3000'],
            'parent' => ['nullable',Rule::exists('categories','id')->where('type' , $this->type)]
        ]);
        $attributes = [
            'title' => $this->title,
            'type' => $this->type,
            'image' => emptyToNull($this->image),
            'parent_id' => emptyToNull($this->parent),
        ];
        try {
            $model->fill($attributes)->save();
            if ($model->wasRecentlyCreated) {
                $model->points()->attach($this->points);
            } else {
                $model->points()->sync($this->points);
            }
            $this->emitNotify(__('general.messages.saved-successfully'));
            redirect()->route('category.index',[$this->type]);
        } catch (\Exception $e) {
            report($e);
            $this->emitNotify(__('general.messages.error'),'warning');
        }
    }

    public function deleteItem(): void
    {
        $this->authorizing('delete_categories');
        if ($this->isUpdatingMode()) {
            $this->category->delete();
            redirect()->route('category.index' , $this->type);
        }
    }

    public function render()
    {
        return view('livewire.category.store-category-component')->extends('layouts.admin');
    }
}
