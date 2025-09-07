<?php

namespace App\Livewire\Admin\CrudTools;

use App\Models\ToolsInformation;
use Livewire\Component;
use App\Models\Storage;
use App\LogsActivity; // Trait ثبت لاگ

class Index extends Component
{
    use LogsActivity;

    public $toolId;
    public $name, $serialNumber, $count, $model, $Weight, $TypeOfConsumption, $qtyLost, $qtyDamaged, $qtyWritOff, $qtyTotal,
        $size, $price, $StorageLocation, $color, $status, $companynumber,
        $dateOfSale, $dateOfexp, $category, $content, $Receiver;

    public $storages = [];

    public function mount($id)
    {
        // محاسبه مجموع مقادیر گمشده، خراب و اسقاطی
        $qtyrez = $this->qtyDamaged + $this->qtyWritOff + $this->qtyLost;
        $qtyrez1 = $this->count - $qtyrez;
        $this->qtyTotal = $qtyrez1;
        $this->count = $this->qtyTotal;  // count را به مقدار qtyTotal برابر می‌کنیم

        // بارگذاری اطلاعات ابزار
        $tool = ToolsInformation::with('details')->findOrFail($id);

        $this->toolId = $tool->id;
        $this->name = $tool->name;

        $this->qtyLost = $tool->details->qtyLost;
        $this->qtyWritOff = $tool->details->qtyWritOff;
        $this->qtyDamaged = $tool->details->qtyDamaged;
        $this->qtyTotal = $qtyrez1; // بروزرسانی qtyTotal
        $this->count = $this->qtyTotal; // به روزرسانی count

        $this->companynumber = $tool->companynumber;
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

        // آپدیت محل و ثبت لاگ انتقال
        $this->updateLocation($this->toolId, $this->StorageLocation);

        // محاسبه مجدد qtyTotal و همسان‌سازی count با آن
        $qtyrez = $this->qtyDamaged + $this->qtyWritOff + $this->qtyLost;
        $qtyrez1 = $this->count - $qtyrez;
        $this->qtyTotal = $qtyrez1;
        $this->count = $this->qtyTotal; // count را به مقدار qtyTotal برابر می‌کنیم

        // بروزرسانی اطلاعات اصلی ابزار
        $info->update([
            'name' => $this->name,
            'serialNumber' => $this->serialNumber,
        ]);

        // بروزرسانی جزئیات ابزار
        $info->details()->update([
            'category' => $this->category,
            'count' => $this->count, // به‌روزرسانی count
            'companynumber' => $this->companynumber,
            'status' => $this->status,
            'model' => $this->model,
            'Weight' => $this->Weight,
            'TypeOfConsumption' => $this->TypeOfConsumption,
            'size' => $this->size,
            'price' => $this->price,
            'StorageLocation' => $this->StorageLocation,
            'Receiver' => $this->Receiver,
            'color' => $this->color,
            'qtyLost' => $this->qtyLost,
            'qtyWritOff' => $this->qtyWritOff,
            'qtyDamaged' => $this->qtyDamaged,
            'content' => $this->content,
        ]);

        // ثبت لاگ ویرایش ابزار
        $this->logActivity('edit', $info, "ابزار ویرایش شد: {$info->details->model}");

        session()->flash('success', 'اطلاعات با موفقیت به‌روزرسانی شد.');
        return redirect()->route('admin.tools');
    }

    /**
     * آپدیت محل ابزار و ثبت در جدول locations
     */
    public function updateLocation($toolId, $newLocation)
    {
        $tool = ToolsInformation::findOrFail($toolId);

        // آپدیت محل فعلی
        $tool->update([
            'StorageLocation' => $newLocation,
            'Receiver' => $this->Receiver,
        ]);

        // ثبت لاگ تغییر محل
        $tool->locations()->create([
            'location' => $newLocation,
            'Receiver' => $this->Receiver,
            'status' => $this->status,
            'moved_at' => now(),
        ]);
    }

    public function render()
    {
        return view('livewire.admin.crud-tools.index', [
            'storages' => $this->storages,
        ]);
    }
}
