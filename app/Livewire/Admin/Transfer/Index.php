<?php

namespace App\Livewire\Admin\Transfer;

//use App\Models\Transfer;
use App\Models\Transfer;
use Livewire\Component;

class Index extends Component
{



    public function render()
    {
        $transfers = Transfer::with(['fromStorage', 'toStorage', 'items.toolDetail.information'])
            ->latest()
            ->get();


        return view('livewire.admin.transfer.index', [
            'transfers' => $transfers,
        ]);
    }
}
