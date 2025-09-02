<?php

namespace App\Livewire\Admin;

use App\Models\ToolsDetail;
use App\Models\ToolsInformation;
use Livewire\Component;

class Dashboard extends Component
{
    public $countJam;
    public $countTools;
    public $lowTools;

    public function mount()
    {
        $this->lowTools = ToolsDetail::with('information')
            ->where('count', '<', 10)
            ->get();
        $this->countJam =ToolsDetail::where('category', 'IPR-')->count();
        $this->countTools =ToolsDetail::where('category','tools')->count();
   }
    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
