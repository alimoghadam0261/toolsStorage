<?php

namespace App\Livewire\Admin;

use App\Models\ToolsInformation;
use Livewire\Component;
use Livewire\WithPagination;

class Tools extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';


    public $sortBy = 'id'; // ستون پیش‌فرض برای مرتب‌سازی
    public $sortDirection = 'desc'; // جهت پیش‌فرض
    public $searchTerm = ''; // برای جستجو

    protected $updatesQueryString = ['searchTerm', 'sortBy', 'sortDirection'];

    // وقتی مرتب‌سازی تغییر کرد، صفحه به 1 برگردد
    public function updatedSortBy()
    {
        $this->resetPage();
    }

    public function updatedSearchTerm()
    {
        $this->resetPage();
    }

    // تغییر جهت مرتب‌سازی
    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    // حذف ابزار
    public function delete($id)
    {
        $tool = ToolsInformation::findOrFail($id);
        $tool->delete();
        session()->flash('success', 'ابزار با موفقیت حذف شد');
    }

    // مسیر نمایش جزئیات ابزار
    public function goToShow($id)
    {
        return redirect()->route('admin.tools.show', $id);
    }

    // query اصلی برای paginate
    public function loadToolsQuery()
    {
        $query = ToolsInformation::with('details');

        // جستجو
        if ($this->searchTerm) {
            $query->where('name', 'like', '%' . $this->searchTerm . '%')
                ->orWhere('serialNumber', 'like', '%' . $this->searchTerm . '%');
        }

        // مرتب‌سازی
        if ($this->sortBy === 'price') {
            $query->select('toolsinformations.*')
                ->join('toolsdetailes', 'toolsinformations.id', '=', 'toolsdetailes.tools_information_id')
                ->orderByRaw('CAST(toolsdetailes.price AS UNSIGNED) ' . $this->sortDirection);
        } elseif ($this->sortBy === 'count') {
            $query->select('toolsinformations.*')
                ->join('toolsdetailes', 'toolsinformations.id', '=', 'toolsdetailes.tools_information_id')
                ->orderBy('toolsdetailes.count', $this->sortDirection);
        } else {
            $query->orderBy($this->sortBy, $this->sortDirection);
        }

        return $query;
    }

    public function render()
    {
        $tools = $this->loadToolsQuery()->paginate(2);
        $count = $tools->total();

        return view('livewire.admin.tools', compact('tools', 'count'));
    }
}
