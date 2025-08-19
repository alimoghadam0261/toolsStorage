<?php

namespace App\Livewire\Admin\CrudTools;

use App\Models\ToolsInformation;
use App\Models\ToolsLocation;
use Livewire\Component;

class Show extends Component
{
    public $toolId;
    public $tool;
    public $locations;
    public $toolIds;
    public function mount($id)
    {
        $this->toolIds = $id;

        $this->tool = ToolsInformation::with('details')->findOrFail($id);

        $this->locations = ToolsLocation::where('tools_information_id', $this->toolIds)
            ->orderBy('moved_at')
            ->get();
    }



    public function render()
    {
        return view('livewire.admin.crud-tools.show');
    }
}
