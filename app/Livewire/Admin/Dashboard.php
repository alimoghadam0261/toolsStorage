<?php

namespace App\Livewire\Admin;

use App\Models\ToolsDetail;
use Livewire\Component;
use Morilog\Jalali\Jalalian;

class Dashboard extends Component
{
    public $countJam;
    public $countabzar;
    public $countmasraf;

    public $countTools;
    public $countTotal;
    public $lowTools;
    public $chartData;
    public $lineChartData;

    public function mount()
    {
        // داده‌های برای نمودار میله‌ای (بر اساس ماه‌های شمسی)
        $this->chartData = ToolsDetail::selectRaw('category, COUNT(*) as count, MONTH(created_at) as month, YEAR(created_at) as year')
            ->groupBy('category', 'month', 'year')
            ->get();

        // تبدیل تاریخ میلادی به تاریخ شمسی برای هر ماه
        $this->chartData->transform(function($item) {
            $item->month = Jalalian::fromDateTime($item->created_at)->getMonth(); // ماه شمسی
            return $item;
        });

        // داده‌های برای نمودار خطی (بر اساس ماه‌های شمسی)
        $this->lineChartData = ToolsDetail::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->get();

        // تبدیل تاریخ میلادی به تاریخ شمسی برای نمودار خطی
        $this->lineChartData->transform(function($item) {
            $item->month = Jalalian::fromDateTime($item->created_at)->getMonth(); // ماه شمسی
            return $item;
        });

        // حذف کش

        $this->lowTools = ToolsDetail::with(['information:id,name'])
            ->where('count', '<', 10) // اطمینان از اینکه فقط ابزارهای با موجودی کمتر از ۱۰ گرفته می‌شوند
            ->get(['id', 'tools_information_id', 'count']);


        $this->countJam = ToolsDetail::where('category', 'IPR-')->count();
        $this->countabzar = ToolsDetail::where('category', 'abzar-')->count();
        $this->countmasraf = ToolsDetail::where('category', '!=', 'IPR-')
            ->where('category', '!=', 'abzar-')
            ->count();
        $this->countTools = ToolsDetail::where('category', 'tools')->count();
        $this->countTotal = ToolsDetail::count();
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
