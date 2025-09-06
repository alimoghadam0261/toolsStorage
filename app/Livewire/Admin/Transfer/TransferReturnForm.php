<?php

namespace App\Livewire\Admin\Transfer;

use App\Models\Transfer;
use App\Models\ToolsDetail;
use App\Models\Transfer_items;
use Livewire\Component;
use App\Models\ToolsLocation;
use Illuminate\Support\Facades\DB;

class TransferReturnForm extends Component
{
    public Transfer $transfer; // با route-model-binding مقداردهی می‌شود
    public $transferId;
    public $items = [];

    /**
     * Livewire route passes {transfer} -> Laravel will resolve the Transfer model
     */
    public function mount(Transfer $transfer)
    {
        // load relations
        $this->transfer = $transfer->load('items.toolInformation');
        $this->transferId = $transfer->id;

        $this->items = [];

        foreach ($this->transfer->items as $item) {
            $this->items[] = [
                'id' => $item->id,
                // توجه: نام فیلد در جدول transfer_items احتمالا toolsinformation_id (بدون underscore)
                // ما آن مقدار را نگه می‌داریم تا بتوانیم در ToolsDetail جستجو کنیم (که از tools_information_id استفاده می‌کند).
                'toolsinformation_id' => $item->toolsinformation_id ?? $item->tools_information_id ?? null,
                'name' => $item->toolInformation->name ?? '---',
                'qty_sent' => (int) $item->qty,
                // پیش‌فرض برگشتی = همه (یا صفر) — اینجا صفر منطقی‌تر است ولی می‌توانی مقدار پیش‌فرض دلخواه بذاری
                'qty_return' => 0,
                'damaged_qty' => (int) ($item->damaged_qty ?? 0),
                'lost_qty' => (int) ($item->lost_qty ?? 0),
            ];
        }
    }

    protected function rules()
    {
        return [
            'items.*.qty_return'  => 'required|integer|min:0',
            'items.*.damaged_qty' => 'required|integer|min:0',
            'items.*.lost_qty'    => 'required|integer|min:0',
        ];
    }

    public function save()
    {
        // اعتبارسنجی اولیه
        $this->validate();

        foreach ($this->items as $idx => $row) {
            $sent = (int) ($row['qty_sent'] ?? 0);
            $qReturn = (int) ($row['qty_return'] ?? 0);
            $damaged = (int) ($row['damaged_qty'] ?? 0);
            $lost = (int) ($row['lost_qty'] ?? 0);

            // اعتبارسنجی جمع مقادیر
            if (($qReturn + $damaged + $lost) > $sent) {
                $this->addError("items.$idx.qty_return", "جمع مقادیر (برگشتی + خراب + گمشده) نباید از تعداد ارسال‌شده بیشتر باشد.");
                return; // از ادامه ذخیره جلوگیری کن
            }
        }

        DB::transaction(function () {
            $transfer = Transfer::with('items')->findOrFail($this->transferId);

            foreach ($this->items as $row) {
                $sent = (int) ($row['qty_sent'] ?? 0);
                $qReturn = (int) ($row['qty_return'] ?? 0);
                $damaged = (int) ($row['damaged_qty'] ?? 0);
                $lost = (int) ($row['lost_qty'] ?? 0);

                $transferItem = Transfer_items::findOrFail($row['id']);

                // 1. پیدا کردن ابزار در انبار مقصد (to_storage_id)
                $toTool = ToolsDetail::where('storage_id', $transfer->to_storage_id)
                    ->where('tools_information_id', $row['toolsinformation_id'])
                    ->first();

                $decrementAmount = $qReturn + $damaged + $lost;

                // 2. کاهش موجودی ابزار از انبار مقصد
                if ($toTool) {
                    if ($decrementAmount > $toTool->count) {
                        $this->addError("items.{$row['id']}.qty_return", "موجودی انبار مقصد برای '{$row['name']}' کافی نیست.");
                        return;
                    }
                    if ($decrementAmount > 0) {
                        $toTool->decrement('count', $decrementAmount); // کاهش موجودی در انبار مقصد
                    }

                    // 3. حذف رکورد ابزار از `ToolsLocation` مربوط به انبار مقصد
                    ToolsLocation::where('location', $transfer->toStorage->name)
                        ->where('tools_information_id', $toTool->tools_information_id) // استفاده از tools_information_id
                        ->delete(); // حذف رکورد ابزار از انبار مقصد
                }

                // 4. برگشت ابزار به انبار مبدا
                if ($qReturn > 0) {
                    // پیدا کردن یا ساخت ابزار در انبار مبدا
                    $fromTool = ToolsDetail::firstOrCreate(
                        [
                            'tools_information_id' => $row['toolsinformation_id'],
                            'storage_id'           => $transfer->from_storage_id, // برگشت به انبار مبدا
                        ],
                        ['count' => 0]
                    );
                    $fromTool->increment('count', $qReturn); // افزایش موجودی در انبار مبدا
                }

                // 5. آپدیت اطلاعات انتقال در Transfer_items (برای ثبت خسارت و گم‌شده)
                $transferItem->update([
                    'damaged_qty' => $damaged,
                    'lost_qty'    => $lost,
                ]);

                // 6. آپدیت `qty_damaged` و `qty_lost` در جدول ToolsDetail
                if ($damaged > 0 || $lost > 0) {
                    $toolDetail = ToolsDetail::where('tools_information_id', $row['toolsinformation_id'])
                        ->where('storage_id', $transfer->from_storage_id) // مطمئن شویم که در انبار مبدا است
                        ->first();

                    if ($toolDetail) {
                        // اضافه کردن مقدار خراب یا گمشده به ابزار در انبار مبدا
                        if ($damaged > 0) {
                            $toolDetail->increment('qty_damaged', $damaged);
                        }

                        if ($lost > 0) {
                            $toolDetail->increment('qty_lost', $lost);
                        }
                    }
                }
            }

            // 7. آپدیت وضعیت انتقال به "returned"
            $transfer->update([
                'status' => 'returned',
                'received_at' => now(),
            ]);
        });

        // پیام موفقیت
        session()->flash('success', 'برگشت ابزار با موفقیت ثبت شد ✅');
        return redirect()->route('admin.transfer.index');
    }



    public function render()
    {
        return view('livewire.admin.transfer.transfer-return-form');
    }
}
