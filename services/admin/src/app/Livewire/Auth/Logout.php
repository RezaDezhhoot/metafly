<?php

namespace App\Livewire\Auth;

use App\Livewire\BaseComponent;
use Illuminate\Support\Facades\Auth;

class Logout extends BaseComponent
{
    public function mount() {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('auth.login');
    }
}
