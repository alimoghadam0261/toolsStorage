<?php

namespace App\Livewire\Admin\CrudStorage;

use App\Livewire\Admin\Storages;
use App\Models\Storage;
use App\Models\ToolsInformation;
use App\Models\ToolsLocation;
use Livewire\Component;

class Show extends Component
{


    public $storages;
    public $locations;

    public function mount($id)
    {
        $this->storages = Storage::findOrFail($id);

        $this->locations = ToolsLocation::with(['tool.details'])
            ->where('location', $this->storages->name)
            ->whereHas('tool', function ($q) {
                $q->whereNull('deleted_at'); // فقط ابزارهایی که حذف نشده‌اند
            })
            ->orderBy('moved_at', 'desc')
            ->get();
    }




    public function render()
    {
        return view('livewire.admin.crud-storage.show');
    }
}
