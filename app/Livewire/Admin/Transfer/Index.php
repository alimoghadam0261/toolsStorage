<?php

namespace App\Livewire\Admin\Transfer;

use App\Models\Transfer;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    // حذف انتقال
    public function delete($id)
    {
        $transfer = Transfer::findOrFail($id);
        $transfer->delete(); // Soft Delete

        session()->flash('success', 'انتقال با موفقیت حذف شد (نرم‌حذف) ✅');
    }

    public function test($id)
    {
        return redirect()->route('admin.transfer.show', $id);
    }

    public function render()
    {
        $user = Auth::user();

        $transfers = Transfer::with(['fromStorage', 'toStorage', 'items.toolDetail.information'])
            ->latest();

        if ($user->role !== 'admin') {
            $transfers->where(function ($q) use ($user) {
                $q->where('from_storage_id', $user->storage_id)
                    ->orWhere('to_storage_id', $user->storage_id);
            });
        }

        $transfers = $transfers->get();

        return view('livewire.admin.transfer.index', [
            'transfers' => $transfers,
        ]);
    }
}
