<?php

namespace App\Livewire\Admin;

use App\Models\ToolsDetail;
use App\Models\ToolsInformation;
use Livewire\Component;

class Dashboard extends Component
{
    public $countJam;
    public $countTools;

    public function mount()
    {
        $this->countJam =ToolsDetail::where('category', 'IPR-')->count();
        $this->countTools =ToolsDetail::where('category','tools')->count();
   }
    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
