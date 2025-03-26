<?php

namespace App\Livewire;

use App\Enums\PageAction;
use Illuminate\Auth\Access\AuthorizationException;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Contracts\Filesystem\Filesystem;

class BaseComponent extends Component
{
    use AuthorizesRequests;

    public $header = '';

    public $loading = true;

    protected ?Filesystem $disk;

    public $mode , $search = '';

    public int $per_page = 10;

    public $sortable = false , $sort;

    public $searchable = true;

    public $direction = 'desc';

    public array $data = [] , $page_address = [];
    public function isUpdatingMode(): bool
    {
        return $this->mode === PageAction::UPDATE;
    }

    public function init(): void
    {
        $this->disableLoader();
    }

    public function resetErrors(): void
    {
        $this->resetErrorBag();
    }

    public function enableLoader(): void
    {
        $this->loading = true;
    }

    public function disableLoader(): void
    {
        $this->loading = false;
    }

    public function isCreatingMode(): bool
    {
        return $this->mode === PageAction::CREATE;
    }

    protected function setMode($mode): void
    {
        $this->mode = PageAction::tryFrom($mode);
    }

    protected function authorizing($ability): void
    {
        try {
            $this->authorize($ability);
        } catch (AuthorizationException $e) {
            abort(403);
        }
    }

    protected function emitNotify($title, $icon = 'success'): \Livewire\Features\SupportEvents\Event
    {
        $data['title'] = $title;
        $data['icon'] = $icon;

        return $this->dispatch('notify', $data);
    }

    protected function emitShowModal($id): void
    {
        $this->dispatch('showModal', $id);
    }

    protected function emitHideModal($id): void
    {
        $this->dispatch('hideModal', $id);
    }


    public function setErrors($errors): void
    {
        $this->setErrorBag($errors);
    }
}
