<?php

namespace App\Livewire\Role;

use App\Livewire\BaseComponent;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class StoreRole extends BaseComponent
{
    public $role , $title;
    public ?array $permissions = [] , $permissionSelected = [];

    public function mount($action , $id = null): void
    {
        $this->setMode($action);
        if ($this->isUpdatingMode()) {
            $this->authorizing('edit_roles');
            $this->role = Role::query()->findOrFail($id);
            $this->title = $this->role->name;
            $this->header = $this->title;
            $this->permissionSelected = $this->role->permissions()->pluck('name')->toArray();
        } elseif ($this->isCreatingMode()) {
            $this->authorizing('create_roles');
            $this->header = __('pages.pages.create' , ['item' => __('general.sidebar.role')]);
        } else abort(404);
        $this->permissions = Permission::query()->latest('id')->select(['id','name'])->get()
            ->map(function ($v){
                $details = explode('_',$v['name']);
                $v['action'] = $details[0];
                unset($details[0]);
                $v['module'] = implode('_',$details);
                $v['title'] = __('general.abilities.'.$v['action'] , ['item' => "" ]);
                return $v;
            })->groupBy('module')->toArray();
    }

    public function store()
    {
        $this->validate(
            [
                'title' => ['required','unique:roles,name,'.($this->role->id ?? 0), 'string','max:250'],
                'permissionSelected' => ['required', 'array','min:1'],
                'permissionSelected.*' => ['required', 'exists:permissions,name'],
            ]
        );
        $attributes = [
            'name' => $this->title
        ];
        $role = $this->role ?: new Role;
        $role->fill($attributes)->save();
        $role->syncPermissions($this->permissionSelected);
        $this->emitNotify(__('general.messages.saved-successfully'));
        redirect()->route('role.index');
    }

    public function render()
    {
        return view('livewire.role.store-role')->extends('layouts.admin');
    }
}
