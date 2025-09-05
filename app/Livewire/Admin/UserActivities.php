<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\UserActivity;
use Illuminate\Support\Facades\Cache;

class UserActivities extends Component
{
    use WithPagination;

    protected string $paginationTheme = 'bootstrap';
    public int $perPage = 30;
    public string $search = ''; // 🔍 سرچ زنده

    public function updatingSearch()
    {
        $this->resetPage();
    }

    private function getCacheKey(string $type, int $page): string
    {
        return "user_activities_{$type}_page_{$page}_search_" . md5($this->search);
    }

    public function render()
    {
        $page = $this->page ?? 1;

        $activities = Cache::remember($this->getCacheKey('activities', $page), now()->addMinutes(5), function () {
            return UserActivity::with('user')
                ->whereNotIn('model_type', ['ToolsDetail', 'ToolsInformation'])
                ->whereHas('user', function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhere('cardNumber', 'like', "%{$this->search}%");
                })
                ->latest()
                ->paginate($this->perPage);
        });

        $toolActivities = Cache::remember($this->getCacheKey('tools', $page), now()->addMinutes(5), function () {
            return UserActivity::with('user')
                ->whereIn('model_type', ['ToolsDetail', 'ToolsInformation'])
                ->whereHas('user', function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhere('cardNumber', 'like', "%{$this->search}%");
                })
                ->latest()
                ->paginate($this->perPage);
        });

        $storageActivities = Cache::remember($this->getCacheKey('storage', $page), now()->addMinutes(5), function () {
            return UserActivity::with(['user', 'storage'])
                ->where('model_type', 'Storage')
                ->whereHas('user', function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhere('cardNumber', 'like', "%{$this->search}%");
                })
                ->latest()
                ->paginate($this->perPage);
        });

        return view('livewire.admin.user-activities', [
            'activities' => $activities,
            'toolActivities' => $toolActivities,
            'storageActivities' => $storageActivities,
        ]);
    }
}
