<?php

namespace App\Livewire\Admin;

use App\Models\ToolsLocation;
use Livewire\Component;
use Morilog\Jalali\Jalalian;
use Morilog\Jalali\CalendarUtils;

class ResultInfo extends Component
{

    public function render()
    {
        return view('livewire.admin.result-info');
    }
}
