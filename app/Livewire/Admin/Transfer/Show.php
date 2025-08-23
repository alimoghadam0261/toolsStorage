<?php

namespace App\Livewire\Admin\Transfer;

use Livewire\Component;
use App\Models\Transfer;

class Show extends Component
{

    public $transfer;

    public function mount($id)
    {
        $this->transfer = Transfer::with(['fromStorage', 'toStorage', 'user', 'items.toolDetail.information'])
            ->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.admin.transfer.show');
    }
}
