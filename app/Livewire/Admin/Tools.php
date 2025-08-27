<?php

namespace App\Livewire\Admin;

use App\Models\ToolsInformation;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Route;

class Tools extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    // existing props
    public $sortBy = 'id';
    public $sortDirection = 'desc';
    public $searchTerm = '';

    // new props for export
    public $date_from;
    public $date_to;
    public $exportFormat = 'pdf'; // مطابق blade: wire:model="exportFormat"

    protected $updatesQueryString = ['searchTerm', 'sortBy', 'sortDirection'];

    public function updatedSortBy()
    {
        $this->resetPage();
    }

    public function updatedSearchTerm()
    {
        $this->resetPage();
    }

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

    public function delete($id)
    {
        $tool = ToolsInformation::findOrFail($id);
        $tool->delete();
        session()->flash('success', 'ابزار با موفقیت حذف شد');
    }

    public function goToShow($id)
    {
        return redirect()->route('admin.tools.show', $id);
    }

    public function loadToolsQuery()
    {
        $query = ToolsInformation::with('details');

        if ($this->searchTerm) {
            $query->where('name', 'like', '%' . $this->searchTerm . '%')
                ->orWhere('serialNumber', 'like', '%' . $this->searchTerm . '%');
        }

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

    /**
     * Export action:
     * این متد URL دانلود را می‌سازد و با یک browser event به فرانت‌اند می‌فرستد.
     * اسکریپت شما در tools.blade این event را شنیده و url را در تب جدید باز می‌کند.
     */
    public function export()
    {
        // اعتبارسنجی
        $this->validate([
            'date_from'    => 'nullable|date',
            'date_to'      => 'nullable|date',
            'exportFormat' => 'required|in:pdf,excel',
        ]);

        // پارامترها (مقادیر null حذف می‌شوند)
        $params = array_filter([
            'date_from' => $this->date_from ?: null,
            'date_to'   => $this->date_to ?: null,
            'format'    => $this->exportFormat,
        ], function($v) { return $v !== null && $v !== ''; });

        // توجه: مطمئن شو این روت وجود دارد:
        // Route::get('/admin/tools/export', [ToolsExportController::class, 'export'])->name('admin.tools.export');
        $url = route('admin.tools.export', $params);

        // ریدایرکت مرورگر (در تب جاری)
        return redirect()->to($url);
    }





    public function render()
    {
        $tools = $this->loadToolsQuery()->paginate(10);
        $count = $tools->total();

        return view('livewire.admin.tools', compact('tools', 'count'));
    }
}
