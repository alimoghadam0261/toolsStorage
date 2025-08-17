<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use App\Models\Storage;
class Personal extends Component
{
    public $personal;
    public $storages;

    public function mount()
    {
        $this->storages = Storage::select('id', 'name')->get();
        $this->personal = User::all();
    }

    public function render()
    {
        return view('livewire.admin.personal');
    }
}
