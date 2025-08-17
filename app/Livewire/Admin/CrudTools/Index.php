<?php

namespace App\Livewire\Admin\CrudTools;

use App\Models\ToolsInformation;
use Livewire\Component;
use App\Models\Storage;
class Index extends Component
{

    public $toolId;
    public $name, $serialNumber, $count, $model, $Weight, $TypeOfConsumption,
        $size, $price, $StorageLocation, $color, $status,
        $dateOfSale, $dateOfexp, $category, $content,$Receiver;
    public $storages = [];

    public function mount($id)
    {
        $tool = ToolsInformation::with('details')->findOrFail($id);
        $this->toolId = $tool->id;
        $this->name = $tool->name;
        $this->serialNumber = $tool->serialNumber;
        $this->count = $tool->details->count;
        $this->status = $tool->details->status;
        $this->model = $tool->details->model;
        $this->Receiver = $tool->details->Receiver;
        $this->Weight = $tool->details->Weight;
        $this->TypeOfConsumption = $tool->details->TypeOfConsumption;
        $this->size = $tool->details->size;
        $this->price = $tool->details->price;
        $this->StorageLocation = $tool->details->StorageLocation;
        $this->color = $tool->details->color;
        $this->dateOfSale = $tool->details->dateOfSale;
        $this->dateOfexp = $tool->details->dateOfexp;
        $this->category = $tool->details->category;
        $this->content = $tool->details->content;

        $this->storages = Storage::select('id', 'name')->get();

    }


    public function updateTool()
    {
        $info = ToolsInformation::findOrFail($this->toolId);
        $this->updateLocation($this->toolId, $this->StorageLocation);
        $info->update([
            'name' => $this->name,
            'serialNumber' => $this->serialNumber

        ]);
//   انبار مرکزی
        $info->details()->update([
            'category' => $this->category,
            'count' => $this->count,
            'status' => $this->status,
            'model' => $this->model,
            'Weight' => $this->Weight,
            'TypeOfConsumption' => $this->TypeOfConsumption,
            'size' => $this->size,
            'price' => $this->price,
            'StorageLocation' => $this->StorageLocation,
            'Receiver' => $this->Receiver,
            'color' => $this->color,
            'dateOfSale' => $this->dateOfSale,
            'dateOfexp' => $this->dateOfexp,
            'content' => $this->content,
        ]);

        session()->flash('success', 'اطلاعات با موفقیت به‌روزرسانی شد.');
        return redirect()->route('admin.tools');
    }

    public function updateLocation($toolId, $newLocation)
    {
        $tool = ToolsInformation::findOrFail($toolId);

        // آپدیت محل فعلی
        $tool->update([
            'StorageLocation' => $newLocation,
            'Receiver' => $this->Receiver,
        ]);

        // ثبت لاگ
        $tool->locations()->create([
            'location' => $newLocation,
            'Receiver' => $this->Receiver,
            'status' => $this->status,
            'moved_at' => now()
        ]);
    }




    public function render()
    {
        return view('livewire.admin.crud-tools.index', [
            'storages' => $this->storages
        ]);
    }
}
