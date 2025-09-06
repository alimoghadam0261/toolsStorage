<?php

namespace App\Livewire\Admin\CrudStorage;

use App\Livewire\Admin\Storages;
use App\Models\Storage;
use App\Models\ToolsInformation;
use App\Models\ToolsLocation;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    public $storages;
//    public $locations;

    public function mount($id)
    {
        $this->storages = Storage::findOrFail($id);


    }




    public function render()
    {
        // گرفتن ابزارهایی که به انبار مقصد منتقل شده‌اند
        $locations = ToolsLocation::with(['tool.details'])
            ->where('location', $this->storages->name)
            ->whereHas('tool', function ($q) {
                $q->whereNull('deleted_at');
            })
            ->orderBy('moved_at', 'desc')
            ->paginate(20);

        return view('livewire.admin.crud-storage.show', [
            'locations' => $locations,
        ]);
    }

}
