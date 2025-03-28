<?php

namespace App\Livewire\User;

use App\Livewire\BaseComponent;
use App\Models\User;
use App\Modules\User\Rules\PasswordRule;

class StoreUser extends BaseComponent
{
    public $name , $email , $password , $phone;

    public $roles = [];
    public $oldRoles = [];
    public $user;

    public function mount($action , $id = null)
    {
        $this->setMode($action);
        if ($this->isUpdatingMode()) {
            $this->authorizing('edit_users');
            $this->user = User::query()->findOrFail($id);
            $this->name = $this->user->name;
            $this->email = $this->user->email;
            $this->phone = $this->user->phone;
            $this->header = $this->user->name;
        } elseif ($this->isCreatingMode()) {
            $this->authorizing('create_users');
            $this->header = __('pages.pages.create' , ['item' => __('general.sidebar.user')]);
        } else abort(404);
    }

    public function store()
    {
        $this->validate([
            'name' => ['string','required','max:50'],
            'email' => ['email','required','max:100','unique:users,email,'.($this->user->id ?? 0)],
            'phone' => ['string','required','max:100','unique:users,phone,'.($this->user->id ?? 0)],
            'password' => [($this->isCreatingMode() || !empty($this->password)) ? 'required' : 'nullable','string','min:6'],
            'roles' => ['nullable','array'],
            'roles.*' => ['required','exists:roles,id'],
        ]);
        $attributes = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ];
        if ($this->isCreatingMode() || ! empty($this->password)) $attributes['password'] = $this->password;
        $model = $this->user ?: new User;
        $model->fill($attributes)->save();
        if ($model->wasRecentlyCreated) {
            $model->roles()->attach($this->roles);
        } else {
            $model->roles()->sync($this->roles);
        }
        $this->emitNotify(__('general.messages.saved-successfully'));
        redirect()->route('user.index');
    }

    public function deleteItem()
    {
        $this->authorizing('delete_users');
        if ($this->isUpdatingMode()) {
            $this->user->delete();
            redirect()->route('user.index');
        }
    }

    public function render()
    {
        return view('livewire.users.store-user')->extends('layouts.admin');
    }
}
