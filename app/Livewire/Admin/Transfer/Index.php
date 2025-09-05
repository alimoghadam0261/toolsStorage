<?php

namespace App\Livewire\Admin\Transfer;

use App\Models\Transfer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Index extends Component
{
    // حذف انتقال
    public function delete($id)
    {
        $transfer = Transfer::findOrFail($id);
        $transfer->delete(); // Soft Delete

        // پاک کردن کش پس از حذف
        Cache::forget($this->getCacheKey());

        session()->flash('success', 'انتقال با موفقیت حذف شد (نرم‌حذف) ✅');
    }

    public function test($id)
    {
        return redirect()->route('admin.transfer.show', $id);
    }

    // تولید کلید کش دینامیک بر اساس نقش کاربر
    private function getCacheKey(): string
    {
        $user = Auth::user();
        return 'transfers_' . ($user->role === 'admin' ? 'all' : 'user_' . $user->id);
    }

    public function render()
    {
        $cacheKey = $this->getCacheKey();

        $transfers = Cache::remember($cacheKey, now()->addMinutes(5), function () {
            $user = Auth::user();

            $query = Transfer::with(['fromStorage', 'toStorage', 'items.toolDetail.information'])
                ->latest();

            if ($user->role !== 'admin') {
                $query->where(function ($q) use ($user) {
                    $q->where('from_storage_id', $user->storage_id)
                        ->orWhere('to_storage_id', $user->storage_id);
                });
            }

            return $query->get();
        });

        return view('livewire.admin.transfer.index', [
            'transfers' => $transfers,
        ]);
    }
}
