<?php

namespace App\Livewire\Admin;

use App\Models\ToolsDetail;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Dashboard extends Component
{
    public $countJam;
    public $countTools;
    public $lowTools;

    public function mount()
    {
        // 📌 کش کردن داده‌ها
        $this->lowTools = Cache::remember('dashboard_lowTools', now()->addMinutes(5), function () {
            return ToolsDetail::select(['id', 'count', 'tools_information_id'])
                ->with(['information:id,name']) // فقط ستون‌های لازم
                ->where('count', '<', 10)
                ->get();
        });

        $this->countJam = Cache::remember('dashboard_countJam', now()->addMinutes(5), function () {
            return ToolsDetail::where('category', 'IPR-')->count();
        });

        $this->countTools = Cache::remember('dashboard_countTools', now()->addMinutes(5), function () {
            return ToolsDetail::where('category', 'tools')->count();
        });
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
