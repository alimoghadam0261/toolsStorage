<?php

namespace App\Livewire\Admin\CrudTools;

use App\Models\ToolsInformation;
use Livewire\Component;

class Show extends Component
{
    public $toolId;
    public $tool;

    public function mount($id)
    {
        $this->tool = ToolsInformation::with('details')->findOrFail($id);
    }



    public function render()
    {
        return view('livewire.admin.crud-tools.show');
    }
}
