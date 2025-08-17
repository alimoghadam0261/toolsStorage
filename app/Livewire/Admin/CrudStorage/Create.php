<?php

namespace App\Livewire\Admin\CrudStorage;

use App\Models\Storage;
use Livewire\Component;

class Create extends Component
{
    public $name;
    public $location;
    public $manager;
    public $content;


    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:25',
            'location' => 'required|string|max:100',
            'manager' => 'required|string|max:25',
            'content' => 'required|string|max:255',

        ]);

        $storages = Storage::create([
            'name'=>$this->name,
            'location'=>$this->location,
            'manager'=>$this->manager,
            'content'=>$this->content,
        ]);
        session()->flash('success', 'اطلاعات سایت با موفقیت ثبت شد.');
        return redirect()->route('admin.storages');
    }







    public function render()
    {
        return view('livewire.admin.crud-storage.create');
    }
}
