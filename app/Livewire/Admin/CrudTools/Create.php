<?php

namespace App\Livewire\Admin\CrudTools;

use App\Models\ToolsInformation;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\Storage;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $storages = [];
    public $tools;
    public $toolId;
    public $customPrefix;

    public $name, $serialNumber,$companynumber;
    public $category, $count, $model, $Weight, $TypeOfConsumption,
        $size, $price, $color, $dateOfSale, $dateOfexp, $Receiver,
        $content, $attach, $status;

    // 👇 این پراپرتی را اضافه کن برای نگه‌داشتن id انبار
    public $storage_id;

    // فقط اگر لازم داری اسم انبار به‌صورت متن هم ذخیره شود (ستون StorageLocation داری)
    public $StorageLocation;

    public $isEdit = false;

    public function mount()
    {
        $this->loadTools();
        $this->storages = Storage::select('id', 'name')->get();

        // پیش‌فرض: اولین انبار
        if ($this->storages->isNotEmpty() && empty($this->storage_id)) {
            $this->storage_id = $this->storages->first()->id;
            $this->StorageLocation = $this->storages->first()->name; // اگر ستون متنی داری
        }
    }

    public function loadTools()
    {
        $this->tools = ToolsInformation::with('details')->get();
    }

    public function updatedCategory($value)
    {
        if (!empty($value)) {
            $this->serialNumber = $this->generateUniqueSerial($value);
        }
    }

    // وقتی انبار عوض شد، اسم لوکیشن متنی را هم ست کن (اختیاری)
    public function updatedStorageId($value)
    {
        $storage = $this->storages->firstWhere('id', (int)$value);
        $this->StorageLocation = $storage?->name;
    }

//    private function generateUniqueSerial($category)
//    {
//        $prefix = $category === 'IPR-' ? 'IPR-' : 'tls';
//        do {
//            $number = random_int(10000, 99999);
//            $serial = $prefix . $number;
//        } while (ToolsInformation::where('serialNumber', $serial)->exists());
//
//        return $serial;
//    }

    private function generateUniqueSerial($category)
    {
        if (strtolower($category) === 'abzar-') {
            $prefix = 'abzar-';
        } elseif (strtoupper($category) === 'IPR' || $category === 'IPR-') {
            $prefix = 'IPR-';
        } else {
            // فقط برای دسته‌های دیگه پیشوند اختصاصی بگیره
            $prefix = $this->customPrefix ? $this->customPrefix . '-' : '200-';
        }

        // گرفتن بیشترین شماره موجود با این prefix، شامل soft deleted ها
        $lastNumber = ToolsInformation::withTrashed()
            ->where('serialNumber', 'like', $prefix . '%')
            ->select(DB::raw("MAX(CAST(SUBSTRING(serialNumber, ".(strlen($prefix)+1).") AS UNSIGNED)) as max_number"))
            ->value('max_number');

        $nextNumber = $lastNumber ? $lastNumber + 1 : 1;

        // ساخت شماره سریال
        $serial = $prefix . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

        // اطمینان از یکتا بودن (اضافی ولی ایمن)
        while (ToolsInformation::withTrashed()->where('serialNumber', $serial)->exists()) {
            $nextNumber++;
            $serial = $prefix . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
        }

        return $serial;
    }






    public function updatedCustomPrefix($value)
    {
        if (!empty($this->category)) {
            $this->serialNumber = $this->generateUniqueSerial($this->category);
        }
    }



    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'status' => 'required',
            'serialNumber' => 'required|string|max:255|unique:toolsinformations,serialNumber,' . $this->toolId,
            'count' => 'required|integer|min:1',
            'model' => 'required|string|max:255',
            'Receiver' => 'required|string|max:25',
            'content' => 'nullable|string',
            'category' => 'required',
            'TypeOfConsumption' => 'required|string',
            'Weight' => 'required|string',
            'size' => 'required|string|max:255',
            'price' => 'required|numeric',
            'color' => 'required|string|max:255',
            'dateOfSale' => 'required|date',
            'dateOfexp' => 'required|date',


            'storage_id' => 'required|exists:storages,id',


            'attach' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);


        $info = ToolsInformation::create([
            'name' => $this->name,
            'serialNumber' => $this->serialNumber
        ]);


        $fileName = null;
        if ($this->attach) {
            $randomNumber = rand(1000, 9999);
            $currentTime = now()->format('YmdHis');
            $fileName = $randomNumber . '_' . $currentTime . '.' . $this->attach->getClientOriginalExtension();
            $this->attach->storeAs('tools', $fileName, 'public');
        }


        if (empty($this->StorageLocation)) {
            $this->StorageLocation = optional(Storage::find($this->storage_id))->name;
        }


        $info->details()->create([
            'storage_id'       => $this->storage_id,
            'category'         => $this->category,
            'companynumber'         => $this->companynumber,
            'count'            => $this->count,
            'status'           => $this->status,
            'model'            => $this->model,
            'Weight'           => $this->Weight,
            'Receiver'         => $this->Receiver,
            'TypeOfConsumption'=> $this->TypeOfConsumption,
            'size'             => $this->size,
            'price'            => $this->price,
            'StorageLocation'  => $this->StorageLocation,
            'color'            => $this->color,
            'dateOfSale'       => $this->dateOfSale,
            'dateOfexp'        => $this->dateOfexp,
            'content'          => $this->content,
            'attach'           => $fileName,
        ]);


        $info->locations()->create([
            'location' => $this->StorageLocation,
            'Receiver' => $this->Receiver,
            'moved_at' => now(),
            'status' =>  $this->status,
        ]);

        $this->resetForm();
        $this->loadTools();

        return redirect()->route('admin.tools')->with('success', 'ابزار جدید با موفقیت ثبت شد ✅');
    }

    public function resetForm()
    {
        $this->reset([
            'toolId', 'name', 'serialNumber', 'category', 'count', 'model',
            'Weight', 'TypeOfConsumption', 'size', 'price',
            'color', 'dateOfSale', 'dateOfexp', 'content', 'isEdit', 'Receiver',
            'status', 'attach', 'storage_id', 'StorageLocation','companynumber'
        ]);
    }

    public function render()
    {
        return view('livewire.admin.crud-tools.create', [
            'storages' => $this->storages
        ]);
    }
}
