<?php

namespace App\Livewire\Admin\Transfer;

use App\Models\Transfer;
use App\Models\Transfer_items;
use App\Models\ToolsDetail;
use Livewire\Component;
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

            // ❌ به جای throw -> از addError استفاده کن
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

                $toTool = ToolsDetail::where('storage_id', $transfer->to_storage_id)
                    ->where('tools_information_id', $row['toolsinformation_id'])
                    ->first();

                $decrementAmount = $qReturn + $damaged + $lost;

                if ($toTool) {
                    if ($decrementAmount > $toTool->count) {
                        $this->addError("items.{$row['id']}.qty_return", "موجودی انبار مقصد برای '{$row['name']}' کافی نیست.");
                        return;
                    }
                    if ($decrementAmount > 0) {
                        $toTool->decrement('count', $decrementAmount);
                    }
                }

                if ($qReturn > 0) {
                    $fromTool = ToolsDetail::firstOrCreate(
                        [
                            'tools_information_id' => $row['toolsinformation_id'],
                            'storage_id'           => $transfer->from_storage_id,
                        ],
                        ['count' => 0]
                    );
                    $fromTool->increment('count', $qReturn);
                }

                $transferItem->update([
                    'damaged_qty' => $damaged,
                    'lost_qty'    => $lost,
                ]);
            }

            $transfer->update([
                'status' => 'returned',
                'received_at' => now(),
            ]);
        });

        session()->flash('success', 'برگشت ابزار با موفقیت ثبت شد ✅');
        return redirect()->route('admin.transfer.index');
    }


    public function render()
    {
        return view('livewire.admin.transfer.transfer-return-form');
    }
}
