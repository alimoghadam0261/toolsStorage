<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\UserActivity;

class UserActivities extends Component
{
    use WithPagination;

    public User $user;

    protected $paginationTheme = 'bootstrap'; // یا tailwind بسته به قالب شما

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function render()
    {
        $activities = Useractivities::where('user_id', $this->user->id)
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('livewire.admin.user-activities', compact('activities'));
    }
}
