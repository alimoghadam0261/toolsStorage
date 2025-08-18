<?php


namespace App\Livewire\Admin;

use App\Models\ToolsInformation;
use Livewire\Component;

class Tools extends Component
{
    public $tools;
    public $sortBy = 'id'; // پیش‌فرض مرتب‌سازی
    public $sortDirection = 'desc'; // پیش‌فرض نزولی

    public $searchTerm = ''; // اضافه کردن متغیر برای جستجو

    public function mount()
    {
        $this->loadTools();
    }

    public function loadTools()
    {
        $query = ToolsInformation::with('details');

        // اعمال فیلتر جستجو در نام یا شماره سریال
        if ($this->searchTerm) {
            $query->where('name', 'like', '%' . $this->searchTerm . '%')
                ->orWhere('serialNumber', 'like', '%' . $this->searchTerm . '%');
        }

        // اعمال مرتب‌سازی
        if ($this->sortBy === 'price') {
            $query->select('toolsinformations.*') // ستون‌های جدول اصلی
            ->join('toolsdetailes', 'toolsinformations.id', '=', 'toolsdetailes.tools_information_id')
                ->orderByRaw('CAST(toolsdetailes.price AS UNSIGNED) ' . 'desc');

        }
        elseif ($this->sortBy === 'count') {
            $query->join('toolsdetailes', 'toolsinformations.id', '=', 'toolsdetailes.tools_information_id')
                ->orderBy('toolsdetailes.count','desc')
                ->select('toolsinformations.*');
        }

        elseif ($this->sortBy === 'date') {
            $query->orderBy('created_at', 'desc');
        }
        else {
            $query->orderBy('id', $this->sortDirection);
        }

        // بارگذاری داده‌ها
        $this->tools = $query->take(15)->get();


    }

    // تغییر جهت مرتب‌سازی
    public function updatedSortBy($value)
    {
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        $this->loadTools();
    }

    // حذف ابزار
    public function delete($id)
    {
        $tool = ToolsInformation::findOrFail($id);
        $tool->delete();
        $this->loadTools();
    }

    // واکنش به تغییر جستجو
    public function updatedSearchTerm()
    {
        $this->loadTools();
    }

    public function goToShow($id)
    {
        return redirect()->route('admin.tools.show', $id);
    }

    public function render()
    {
        $count = $this->tools->count();
        return view('livewire.admin.tools', compact('count')) ->with('tools', $this->tools);
    }
}
