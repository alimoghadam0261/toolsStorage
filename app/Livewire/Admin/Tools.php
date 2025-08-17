<?php

namespace App\Livewire\Admin;

use App\Models\ToolsInformation;
use Livewire\Component;

class Tools extends Component
{
    public $tools;
    public $sortBy = 'id'; // پیش‌فرض مرتب‌سازی
    public $sortDirection = 'desc'; // پیش‌فرض نزولی


    public function mount()
    {
        $this->loadTools();
    }

    public function loadTools()
    {
        $query = ToolsInformation::with('details');

        if ($this->sortBy === 'price') {
            $query->join('tool_details', 'tools_information.id', '=', 'tool_details.tool_id')
                ->orderBy('tool_details.price', $this->sortDirection);
        } elseif ($this->sortBy === 'count') {
            // اگر تعداد داری، باید با withCount بیاری
            $query->withCount('details')->orderBy('details_count', $this->sortDirection);
        } elseif ($this->sortBy === 'date') {
            $query->orderBy('created_at', $this->sortDirection);
        } else {
            $query->orderBy('id', 'desc');
        }

        $this->tools = $query->take(15)->get();
    }

    public function delete($id)
    {
        $tool = ToolsInformation::findOrFail($id);
        $tool->delete();
        $this->loadTools();
    }



    public function render()
    {
        $count =ToolsInformation::All()->count();
        return view('livewire.admin.tools',compact('count'));
    }
}
