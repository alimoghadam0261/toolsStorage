<?php

namespace App\Livewire\Admin;

use App\Models\Storage;
use Livewire\Component;

class Storages extends Component
{
    // حذف یک انبار
    public function delete($id)
    {
        $storage = Storage::findOrFail($id);
        $storage->delete(); // Soft delete

        session()->flash('success', 'انبار با موفقیت حذف شد.');
        return redirect()->to('/admin/storages');
    }

    public function goToShow($id)
    {
        return redirect()->route('admin.storages.show', $id);
    }

    public function render()
    {
        // دریافت لیست انبارها و تعداد آن‌ها بدون کش
        $storages = Storage::all();
        $count = Storage::count();

        return view('livewire.admin.storages', compact('storages', 'count'));
    }
}
