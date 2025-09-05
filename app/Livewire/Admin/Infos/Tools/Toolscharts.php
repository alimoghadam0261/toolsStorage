<?php

namespace App\Livewire\Admin\Infos\Tools;


use Livewire\Component;
use App\Models\ToolsDetail;


class Toolscharts extends Component
{

public $lowTools;
public $maxTools;

    public $chartLabels = [];
    public $lowCounts = [];
    public $maxCounts = [];
    public $lowNames    = [];
    public $maxNames    = [];


    public function mount()
    {
        $this->lowTools = ToolsDetail::with('information')
            ->orderBy('count')
            ->take(10)->get();

        $this->maxTools = ToolsDetail::with('information')
            ->orderByDesc('count')
            ->take(10)->get();

        // کمترین ابزارها
        foreach ($this->lowTools as $tool) {
            $this->chartLabels[] = $tool->created_at->format('Y-m-d'); // زمان
            $this->lowCounts[]   = $tool->count; // تعداد
            $this->lowNames[]    = $tool->information->name; // نام ابزار
        }

        // بیشترین ابزارها
        foreach ($this->maxTools as $tool) {
            $this->chartLabels[] = $tool->created_at->format('Y-m-d'); // زمان
            $this->maxCounts[]   = $tool->count; // تعداد
            $this->maxNames[]    = $tool->information->name; // نام ابزار
        }
    }


    public function render()
    {

        return view('livewire.admin.infos.tools.toolscharts');
    }
}
