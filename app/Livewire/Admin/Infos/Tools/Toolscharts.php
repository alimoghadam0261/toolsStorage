<?php

namespace App\Livewire\Admin\Infos\Tools;

use Livewire\Component;
use App\Models\ToolsDetail;
use App\Models\Transfer_items;
use App\Models\Transfer;

class Toolscharts extends Component
{
    public $lowTools;
    public $maxTools;
    public $damagedItems = [];
    public $lostItems = [];
    public $chartLabels = [];

    public $qtytoolsdamage;
    public $qtytoolslost;

    public function mount()
    {

        $this->lowTools = ToolsDetail::with('information')
            ->whereHas('information')
            ->orderBy('count')
            ->take(10)->get();


        $this->qtytoolslost =ToolsDetail::with('information')
            ->where('qtyLost','>',0)
            ->take(10)->get();

        $this->qtytoolsdamage =ToolsDetail::with('information')
            ->where('qtyLost','>',0)
            ->take(10)->get();



        $this->maxTools = ToolsDetail::with('information')
            ->whereHas('information')
            ->orderByDesc('count')
            ->take(10)->get();


        $transferItems = Transfer_items::with('transfer', 'toolInformation')
            ->whereNotNull('damaged_qty')
            ->orWhereNotNull('lost_qty')
            ->get();

        foreach ($transferItems as $item) {
            $transferDate = $item->transfer ? $item->transfer->created_at->format('Y-m-d') : 'نامشخص';
            $siteName = $item->transfer ? $item->transfer->toStorage->name : 'نامشخص';


            if ($item->damaged_qty > 0) {
                $this->damagedItems[] = [
                    'name' => $item->toolInformation->name,
                    'serial' => $item->toolInformation->serialNumber,
                    'damaged_qty' => $item->damaged_qty,
                    'site_name' => $siteName,
                    'date' => $transferDate,
                ];
            }


            if ($item->lost_qty > 0) {
                $this->lostItems[] = [
                    'name' => $item->toolInformation->name,
                    'serial' => $item->toolInformation->serialNumber,
                    'lost_qty' => $item->lost_qty,
                    'site_name' => $siteName,
                    'date' => $transferDate,
                ];
            }
        }
    }

    public function render()
    {
        return view('livewire.admin.infos.tools.toolscharts');
    }
}
