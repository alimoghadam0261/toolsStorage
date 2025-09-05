<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use App\Models\Storage;
use Illuminate\Support\Facades\Cache;

class Personal extends Component
{
    public $personal;
    public $storages;

    public function mount()
    {
        // کش برای لیست انبارها
        $this->storages = Cache::remember('storages_list', now()->addMinutes(5), function () {
            return Storage::select('id', 'name')->get();
        });

        // کش برای لیست کاربران
        $this->personal = Cache::remember('users_list', now()->addMinutes(5), function () {
            return User::all();
        });
    }

    public function render()
    {
        return view('livewire.admin.personal', [
            'personal' => $this->personal,
            'storages' => $this->storages,
        ]);
    }
}
