<?php

namespace App\Livewire\Admin\CrudStorage;

use App\Models\Storage;
use App\Models\UserActivity;
use Illuminate\Support\Facades\Auth;
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

        // ثبت لاگ کاربری
        UserActivity::create([
            'user_id'    => Auth::id(),
            'action'     => 'create',
            'model_type' => 'Storage',
            'model_id'   => $storages->id,
            'description'=> "ایجاد انبار جدید: {$storages->name}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        session()->flash('success', 'اطلاعات سایت با موفقیت ثبت شد.');
        return redirect()->route('admin.storages');
    }







    public function render()
    {
        return view('livewire.admin.crud-storage.create');
    }
}
