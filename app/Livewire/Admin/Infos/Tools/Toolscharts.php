<?php

namespace App\Livewire\Admin\Infos\Tools;


use Livewire\Component;
use App\Models\ToolsDetail;


class Toolscharts extends Component
{
public $test;

    public function mount()
    {
      $this->test = ToolsDetail::with('information')->orderByDesc('price')->get()->toArray();;
}


    public function render()
    {

        return view('livewire.admin.infos.tools.toolscharts');
    }
}
