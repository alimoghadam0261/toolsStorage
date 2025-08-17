<?php

namespace App\Livewire\Admin\CrudTools;

use App\Models\ToolsInformation;
use Livewire\Component;
use App\Models\Storage;


class Create extends Component
{
    public $storages = [];
    public $tools;
    public $toolId;
    public $name, $serialNumber;
    public $category, $brand, $model, $Weight, $TypeOfConsumption, $size, $price, $StorageLocation, $color, $dateOfSale, $dateOfexp,$Receiver ,$content;

    public $isEdit = false;

    public function mount()
    {
        $this->loadTools();
        $this->storages = Storage::select('id', 'name')->get();

    }

    public function loadTools()
    {
        $this->tools = ToolsInformation::with('details')->get();
    }

    // وقتی دسته‌بندی تغییر کرد
    public function updatedCategory($value)
    {
        if (!empty($value)) {
            $this->serialNumber = $this->generateUniqueSerial($value);
        }
    }

    // تولید شماره سریال یکتا
    private function generateUniqueSerial($category)
    {
        $prefix = $category === 'jam' ? 'jam' : 'tls';
        do {
            $number = random_int(10000, 99999); // 5 رقمی
            $serial = $prefix . $number;
        } while (ToolsInformation::where('serialNumber', $serial)->exists());

        return $serial;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'serialNumber' => 'required|string|max:255|unique:toolsinformations,serialNumber,' . $this->toolId,
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'Receiver' => 'required|string|max:25',
            'content' => 'required|string',
            'category' => 'required',
            'TypeOfConsumption' => 'required',
            'Weight' => 'required',
            'StorageLocation' => 'required',
            'size' => 'required|string|max:255',
            'price' => 'required',
            'color' => 'required',
            'dateOfSale' => 'required',
            'dateOfexp' => 'required|string|max:255',
        ]);

        $info = ToolsInformation::create([
            'name' => $this->name,
            'serialNumber' => $this->serialNumber
        ]);

        $info->details()->create([
            'category' => $this->category,
            'brand' => $this->brand,
            'model' => $this->model,
            'Weight' => $this->Weight,
            'Receiver' => $this->Receiver,
            'TypeOfConsumption' => $this->TypeOfConsumption,
            'size' => $this->size,
            'price' => $this->price,
            'StorageLocation' => $this->StorageLocation,
            'color' => $this->color,
            'dateOfSale' => $this->dateOfSale,
            'dateOfexp' => $this->dateOfexp,
            'content' => $this->content,
        ]);


        $info->locations()->create([
            'location' => $this->StorageLocation,
            'Receiver' => $this->Receiver,
            'moved_at' => now()
        ]);



        $this->resetForm();
        $this->loadTools();
        return redirect()->route('admin.tools')->with('success', 'ابزار جدید با موفقیت ثبت شد ✅');
    }

    public function resetForm()
    {
        $this->reset([
            'toolId', 'name', 'serialNumber', 'category', 'brand', 'model',
            'Weight', 'TypeOfConsumption', 'size', 'price', 'StorageLocation',
            'color', 'dateOfSale', 'dateOfexp', 'content', 'isEdit','Receiver'
        ]);
    }

    public function render()
    {
        return view('livewire.admin.crud-tools.create',[
        'storages' => $this->storages
        ]);
    }
}
