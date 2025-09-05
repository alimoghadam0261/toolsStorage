<?php

namespace App\Livewire\Errors;

use Livewire\Component;

class NotFound extends Component
{
    public function render()
    {
        return view('livewire.errors.not-found')->layout('layouts.guest');
    }
}
