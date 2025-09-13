<?php

namespace App\Livewire\Admin\CrudTools;

use App\Models\ToolsInformation;
use Livewire\Component;
use App\Models\Storage;
use App\LogsActivity; // Trait ثبت لاگ
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use LogsActivity;

    public $toolId;
    public $name, $serialNumber, $count, $model, $Weight, $TypeOfConsumption, $qtyLost, $qtyDamaged, $qtyWritOff, $qtyTotal,
        $size, $price, $StorageLocation, $color, $status, $companynumber,
        $dateOfSale, $dateOfexp, $category, $content, $Receiver;

    public $storages = [];
    public $customPrefix;

    public function mount($id)
    {
        $tool = ToolsInformation::with('details')->findOrFail($id);

        $this->toolId = $tool->id;
        $this->name = $tool->name;
        $this->serialNumber = $tool->serialNumber;

        $this->qtyLost = $tool->details->qtyLost;
        $this->qtyWritOff = $tool->details->qtyWritOff;
        $this->qtyDamaged = $tool->details->qtyDamaged;

        $this->count = $tool->details->count;

        // محاسبه qtyTotal
        $this->qtyTotal = $this->count - ($this->qtyLost + $this->qtyWritOff + $this->qtyDamaged);
        $this->count = $this->qtyTotal;

        $this->companynumber = $tool->details->companynumber;
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

    /**
     * وقتی Category تغییر کرد، شماره سریال جدید بساز
     */
    public function updatedCategory($value)
    {
        if (!empty($value)) {
            $this->serialNumber = $this->generateUniqueSerial($value, $this->toolId);
        }
    }

    /**
     * تولید شماره سریال یکتا مثل Create
     */
    private function generateUniqueSerial($category, $ignoreToolId = null)
    {
        if (strtolower($category) === 'abzar-') {
            $prefix = 'abzar-';
        } elseif (strtoupper($category) === 'IPR' || $category === 'IPR-') {
            $prefix = 'IPR-';
        } else {
            $prefix = $this->customPrefix ? $this->customPrefix . '-' : '200-';
        }

        $query = ToolsInformation::withTrashed()
            ->where('serialNumber', 'like', $prefix . '%');

        if ($ignoreToolId) {
            $query->where('id', '!=', $ignoreToolId);
        }

        $lastNumber = $query->select(DB::raw("MAX(CAST(SUBSTRING(serialNumber, ".(strlen($prefix)+1).") AS UNSIGNED)) as max_number"))
            ->value('max_number');

        $nextNumber = $lastNumber ? $lastNumber + 1 : 1;
        $serial = $prefix . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

        while (ToolsInformation::withTrashed()
            ->where('serialNumber', $serial)
            ->where('id', '!=', $ignoreToolId)
            ->exists()) {
            $nextNumber++;
            $serial = $prefix . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
        }

        return $serial;
    }

    public function updateTool()
    {
        $info = ToolsInformation::findOrFail($this->toolId);

        // بروزرسانی محل و ثبت لاگ
        $this->updateLocation($this->toolId, $this->StorageLocation);

        // محاسبه qtyTotal و همسان‌سازی count
        $this->qtyTotal = $this->count - ($this->qtyDamaged + $this->qtyWritOff + $this->qtyLost);
        $this->count = $this->qtyTotal;

        // بروزرسانی ToolsInformation
        $info->update([
            'name' => $this->name,
            'serialNumber' => $this->serialNumber,
        ]);

        // بروزرسانی جزئیات ابزار
        $info->details()->update([
            'category' => $this->category,
            'count' => $this->count,
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

        $this->logActivity('edit', $info, "ابزار ویرایش شد: {$info->details->model}");

        session()->flash('success', 'اطلاعات با موفقیت به‌روزرسانی شد.');
        return redirect()->route('admin.tools');
    }

    /**
     * بروزرسانی محل ابزار و ثبت در locations
     */
    public function updateLocation($toolId, $newLocation)
    {
        $tool = ToolsInformation::findOrFail($toolId);

        $tool->update([
            'StorageLocation' => $newLocation,
            'Receiver' => $this->Receiver,
        ]);

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
