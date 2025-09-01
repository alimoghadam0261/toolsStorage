<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\UserActivity;

class UserActivities extends Component
{
    use WithPagination;

    protected string $paginationTheme = 'bootstrap';
    public int $perPage = 30;
    public string $search = ''; // 🔍 سرچ زنده

    public function updatingSearch()
    {
        // وقتی سرچ تغییر کرد صفحه برگرده به اول
        $this->resetPage();
    }

    public function render()
    {
        $activities = UserActivity::with('user')
            ->whereNotIn('model_type', ['ToolsDetail', 'ToolsInformation'])
            ->whereHas('user', function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('cardNumber', 'like', "%{$this->search}%");
            })
            ->latest()
            ->paginate($this->perPage);

        $toolActivities = UserActivity::with('user')
            ->whereIn('model_type', ['ToolsDetail', 'ToolsInformation'])
            ->whereHas('user', function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('cardNumber', 'like', "%{$this->search}%");
            })
            ->latest()
            ->paginate($this->perPage);

        $storageActivities = UserActivity::with(['user', 'storage'])
            ->where('model_type', 'Storage')
            ->whereHas('user', function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('cardNumber', 'like', "%{$this->search}%");
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.user-activities', [
            'activities' => $activities,
            'toolActivities' => $toolActivities,
            'storageActivities' => $storageActivities,
        ]);
    }
}
