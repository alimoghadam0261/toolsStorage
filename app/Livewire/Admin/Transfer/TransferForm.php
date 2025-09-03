<?php

namespace App\Livewire\Admin\Transfer;

use App\Models\Storage;
use App\Models\ToolsDetail;
use App\Models\Transfer;
use App\Models\Transfer_items;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class TransferForm extends Component
{
    use WithFileUploads;

    public $fromStorage;
    public $toStorage;
    public $selectedTool;
    public $qty;
    public $status;
    public $note;
    public $image; // اضافه شد

    public $tools = [];
    public $transferItems = [];

    public function updatedFromStorage($value)
    {
        $this->tools = ToolsDetail::with('information')
            ->where('storage_id', $value)
            ->get();
    }

    public function addItem()
    {
        if (!$this->selectedTool || !$this->qty) {
            $this->addError('qty', 'لطفاً ابزار و تعداد را وارد کنید.');
            return;
        }

        $tool = ToolsDetail::with('information')->find($this->selectedTool);

        $this->transferItems[] = [
            'tool_id' => $tool->id,
            'name'    => $tool->information->name ?? '---',
            'qty'     => $this->qty,
        ];

        $this->selectedTool = null;
        $this->qty = null;
    }

    public function removeItem($index)
    {
        unset($this->transferItems[$index]);
        $this->transferItems = array_values($this->transferItems);
    }

    public function save()
    {
        $this->validate([
            'fromStorage'   => 'required|different:toStorage',
            'toStorage'     => 'required',
            'transferItems' => 'required|array|min:1',
            'image'         => 'nullable|image|max:2048', // اعتبارسنجی عکس
        ], [
            'fromStorage.required'   => 'انبار مبدا الزامی است.',
            'toStorage.required'     => 'انبار مقصد الزامی است.',
            'fromStorage.different'  => 'انبار مبدا و مقصد نباید یکسان باشند.',
            'transferItems.min'      => 'حداقل یک ابزار باید انتخاب شود.',
            'image.image'            => 'فایل باید تصویر باشد.',
            'image.max'              => 'حداکثر حجم فایل ۲ مگابایت است.',
        ]);

        DB::transaction(function () {
            $number = 'TR-' . now()->format('Ymd') . random_int(10000, 99999);

            $transfer = Transfer::create([
                'from_storage_id' => $this->fromStorage,
                'to_storage_id'   => $this->toStorage,
                'number'          => $number,
                'status'          => $this->status,
                'note'            => $this->note,
                'user_id'         => auth()->id(),
            ]);

            foreach ($this->transferItems as $item) {
                $fromTool = ToolsDetail::where('storage_id', $this->fromStorage)
                    ->where('id', $item['tool_id'])
                    ->first();

                if (!$fromTool) {
                    throw new \Exception("ابزار انتخاب‌شده در انبار مبدا یافت نشد.");
                }

                if ($fromTool->count < $item['qty']) {
                    throw new \Exception("موجودی ابزار کافی نیست.");
                }

                $fromTool->decrement('count', $item['qty']);

                $toTool = ToolsDetail::firstOrCreate(
                    [
                        'tools_information_id' => $fromTool->tools_information_id,
                        'storage_id'           => $this->toStorage,
                    ],
                    [
                        'category'         => $fromTool->category,
                        'status'           => $fromTool->status,
                        'note'             => $fromTool->note,
                        'model'            => $fromTool->model,
                        'Weight'           => $fromTool->Weight,
                        'Receiver'         => $fromTool->Receiver,
                        'TypeOfConsumption'=> $fromTool->TypeOfConsumption,
                        'size'             => $fromTool->size,
                        'price'            => $fromTool->price,
                        'StorageLocation'  => optional(Storage::find($this->toStorage))->name,
                        'color'            => $fromTool->color,
                        'dateOfSale'       => $fromTool->dateOfSale,
                        'dateOfexp'        => $fromTool->dateOfexp,
                        'content'          => $fromTool->content,
                        'attach'           => $fromTool->attach,
                        'count'            => 0,
                    ]
                );

                $toTool->increment('count', $item['qty']);

                $imagePath = null;
                if ($this->image) {
                    $imagePath = $this->image->store('transfer', 'public');
                }

                Transfer_items::create([
                    'transfer_id'        => $transfer->id,
                    'toolsinformation_id'=> $fromTool->tools_information_id,
                    'toolsdetailes_id'   => $fromTool->id,
                    'qty'                => $item['qty'],
                    'damaged_qty'        => 0,
                    'lost_qty'           => 0,
                    'note'               => $this->note,
                    'image'              => $imagePath,
                ]);
            }
        });

        $this->reset();
        return redirect()->route('admin.transfer.index')->with('success', 'انتقال با موفقیت ثبت شد ✅');
    }

    public function render()
    {
        return view('livewire.admin.transfer.transfer-form', [
            'storages' => Storage::all(),
        ]);
    }
}
