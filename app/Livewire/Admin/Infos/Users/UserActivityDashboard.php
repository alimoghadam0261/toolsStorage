<?php

namespace App\Livewire\Admin\Infos\Users;

use Livewire\Component;
use App\Models\UserActivity;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Morilog\Jalali\Jalalian;

class UserActivityDashboard extends Component
{
    public $fromDate;
    public $toDate;
    public $selectedRole = null;
    public $selectedUser = null;
    public $selectedAction = null;
    public $range = 'month'; // day, week, month

    public $roles = [];
    public $users = [];

    public function mount()
    {
        $this->fromDate = now()->subMonth()->format('Y-m-d');
        $this->toDate = now()->format('Y-m-d');

        $this->roles = User::select('role')->distinct()->pluck('role')->toArray();
        $this->users = User::select('id', 'name')->get();
    }

    public function render()
    {
        $activities = UserActivity::query()
            ->join('users', 'user_activities.user_id', '=', 'users.id')
            ->when($this->fromDate, fn($q) => $q->whereDate('user_activities.created_at', '>=', $this->fromDate))
            ->when($this->toDate, fn($q) => $q->whereDate('user_activities.created_at', '<=', $this->toDate))
            ->when($this->selectedRole, fn($q) => $q->where('users.role', $this->selectedRole))
            ->when($this->selectedUser, fn($q) => $q->where('user_activities.user_id', $this->selectedUser))
            ->when($this->selectedAction, fn($q) => $q->where('user_activities.action', $this->selectedAction));

        // 📊 1. فعالیت‌ها بر اساس تاریخ (گروه‌بندی روزانه/هفتگی/ماهانه)
        $dateFormat = match($this->range) {
            'day' => '%Y-%m-%d',
            'week' => '%Y-%u',
            'month' => '%Y-%m',
            default => '%Y-%m-%d',
        };

        $activitiesByDate = (clone $activities)
            ->select(
                DB::raw("DATE_FORMAT(user_activities.created_at, '{$dateFormat}') as period"),
                DB::raw('COUNT(user_activities.id) as total')
            )
            ->groupBy('period')
            ->orderBy('period')
            ->get()
            ->map(function($item) {
                return [
                    'period' => $item->period,
                    'label' => Jalalian::fromDateTime($item->period)->format('Y/m/d'),
                    'total' => $item->total
                ];
            })
            ->toArray();

        // 📊 2. فعالیت‌ها بر اساس عملیات
        $activitiesByAction = (clone $activities)
            ->select('user_activities.action', DB::raw('COUNT(user_activities.id) as total'))
            ->groupBy('user_activities.action')
            ->get()
            ->toArray();

        // 📊 3. فعالیت‌ها بر اساس نقش
        $activitiesByRole = (clone $activities)
            ->select('users.role', DB::raw('COUNT(user_activities.id) as total'))
            ->groupBy('users.role')
            ->get()
            ->toArray();

        // 📊 4. کاربران فعال (Top 10)
        $activitiesByUser = (clone $activities)
            ->select('users.name', DB::raw('COUNT(user_activities.id) as total'))
            ->groupBy('users.name')
            ->orderByDesc('total')
            ->take(10)
            ->get()
            ->toArray();

        // 📊 5. فعالیت‌ها بر اساس مدل
        $activitiesByModel = (clone $activities)
            ->select('user_activities.model_type', DB::raw('COUNT(user_activities.id) as total'))
            ->groupBy('user_activities.model_type')
            ->get()
            ->toArray();

        return view('livewire.admin.infos.users.user-activity-dashboard', [
            'activitiesByDate' => $activitiesByDate,
            'activitiesByAction' => $activitiesByAction,
            'activitiesByRole' => $activitiesByRole,
            'activitiesByUser' => $activitiesByUser,
            'activitiesByModel' => $activitiesByModel,
        ]);
    }
}
