<?php

namespace App\Livewire\Admin;

use App\Models\Storage;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class Storages extends Component
{
    // حذف یک انبار
    public function delete($id)
    {
        $storage = Storage::findOrFail($id);
        $storage->delete(); // Soft delete

        // پاک کردن کش پس از حذف
        Cache::forget('storages_list');
        Cache::forget('storages_count');

        session()->flash('success', 'انبار با موفقیت حذف شد.');
        return redirect()->to('/admin/storages');
    }

    public function goToShow($id)
    {
        return redirect()->route('admin.storages.show', $id);
    }

    public function render()
    {
        // کش کردن لیست انبارها و تعداد آن‌ها برای 5 دقیقه
        $storages = Cache::remember('storages_list', now()->addMinutes(5), function () {
            return Storage::all();
        });

        $count = Cache::remember('storages_count', now()->addMinutes(5), function () {
            return Storage::count();
        });

        return view('livewire.admin.storages', compact('storages', 'count'));
    }
}
