<?php

namespace App\Livewire\Admin\Transfer;

//use App\Models\Transfer;
use App\Models\Transfer;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
//    public $transferss;
//    public function mount()
//    {
//        $user = Auth::user();
//
//        if ($user->role == 'admin') {
//            $this->transferss = Transfer::latest()->get();
//        } else {
//            // کاربر معمولی فقط انتقال‌های مربوط به انبار خودش را می‌بیند
//            $this->transferss = Transfer::where('from_storage_id', $user->storage_id)
//                ->orWhere('to_storage_id', $user->storage_id)
//                ->latest()
//                ->get();
//        }
//    }
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
        $transfers = Transfer::with(['fromStorage', 'toStorage', 'items.toolDetail.information'])
            ->latest()
            ->get();


        return view('livewire.admin.transfer.index', [
            'transfers' => $transfers,
        ]);
    }
}
