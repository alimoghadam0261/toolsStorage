<?php

namespace App\Livewire\Admin;

use App\Models\ToolsInformation;
use App\Models\UserActivity;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Morilog\Jalali\Jalalian;
use Carbon\Carbon;

class Tools extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $sortBy = 'id';
    public $sortDirection = 'desc';
    public $searchTerm = '';
    public $date_from;
    public $date_to;
    public $exportFormat = 'pdf';

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
        $toolName = $tool->name;
        $toolSerial = $tool->serialNumber;

        $tool->delete();

        UserActivity::create([
            'user_id'    => Auth::id(),
            'action'     => 'delete',
            'model_type' => 'ToolsInformation',
            'model_id'   => $id,
            'description'=> "ابزار حذف شد: {$toolName} ({$toolSerial})",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        session()->flash('success', 'ابزار با موفقیت حذف شد');
    }

    public function goToShow($id)
    {
        return redirect()->route('admin.tools.show', $id);
    }

    public function loadToolsQuery()
    {
        $query = ToolsInformation::with('details');

        // فیلتر جستجو
        if ($this->searchTerm) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('serialNumber', 'like', '%' . $this->searchTerm . '%');
            });
        }

        // فیلتر تاریخ شمسی
        if ($this->date_from) {
            $from = $this->parseJalaliToCarbonOrNull($this->date_from);
            if ($from) {
                $query->whereDate('created_at', '>=', $from->startOfDay());
            }
        }

        if ($this->date_to) {
            $to = $this->parseJalaliToCarbonOrNull($this->date_to);
            if ($to) {
                $query->whereDate('created_at', '<=', $to->endOfDay());
            }
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

    public function export()
    {
        $this->validate([
            'date_from'    => 'nullable|string',
            'date_to'      => 'nullable|string',
            'exportFormat' => 'required|in:pdf,excel',
        ]);

        $dateFrom = $this->parseJalaliToCarbonOrNull($this->date_from);
        $dateTo   = $this->parseJalaliToCarbonOrNull($this->date_to);

        $params = array_filter([
            'date_from' => $dateFrom ? $dateFrom->toDateString() : null,
            'date_to'   => $dateTo ? $dateTo->toDateString() : null,
            'format'    => $this->exportFormat,
        ], fn($v) => $v !== null && $v !== '');

        $url = route('admin.tools.export', $params);

        return redirect()->to($url);
    }

    private function faDigitsToEn(?string $value): ?string
    {
        if ($value === null) return null;
        $persian = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹','٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
        $english = ['0','1','2','3','4','5','6','7','8','9','0','1','2','3','4','5','6','7','8','9'];
        return str_replace($persian, $english, $value);
    }

    private function parseJalaliToCarbonOrNull(?string $jalali)
    {
        if (empty($jalali)) return null;

        $raw = trim($jalali);
        $raw = $this->faDigitsToEn($raw);
        $raw = str_replace(['.', '-', ' '], '/', $raw);

        try {
            return Jalalian::fromFormat('Y/m/d', $raw)->toCarbon();
        } catch (\Throwable $e) {
            try {
                return Carbon::parse($raw);
            } catch (\Throwable $ex) {
                return null;
            }
        }
    }

    public function render()
    {
        $tools = $this->loadToolsQuery()->paginate(20);
        $count = $tools->total();

        return view('livewire.admin.tools', compact('tools', 'count'));
    }
}
