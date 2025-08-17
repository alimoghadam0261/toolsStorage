<?php

namespace App\Livewire\Admin;

use App\Models\Storage;
use Livewire\Component;

class Storages extends Component
{

    public function delete($id)
    {
        $storage = Storage::findOrFail($id);
        $storage->delete(); // Soft delete
        session()->flash('success', 'سایت با موفقیت حذف شد.');
    }


    public function render()
    {
        $storages =  Storage::all();
        $count =  Storage::all()->count();
        return view('livewire.admin.storages',compact('storages','count'));
    }
}
