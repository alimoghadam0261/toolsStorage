<?php

namespace App\Livewire\Admin\Infos;

use App\Models\ToolsLocation;
use Livewire\Component;
use Morilog\Jalali\CalendarUtils;
use Morilog\Jalali\Jalalian;

class Tools extends Component
{
    public $nodes = [];
    public $edges = [];
    public $locations;
    public $toolId;

    public function mount($toolId)
    {
        $this->toolId = $toolId;

        // گرفتن لیست مکان‌ها مرتب شده بر اساس تاریخ
        $this->locations = ToolsLocation::where('tools_information_id', $this->toolId)
            ->orderBy('moved_at')
            ->get();

        $uniqueNodes = [];
        $nodes = [];
        $edges = [];

        $previousLocation = null;

        foreach ($this->locations as $item) {
            // تاریخ فارسی
            $jdate = $item->moved_at
                ? Jalalian::fromDateTime($item->moved_at)->format('Y/m/d')
                : 'بدون تاریخ';
            $persianDate = CalendarUtils::convertNumbers($jdate);

            // ساخت ID یکتا بر اساس نام محل
            if (!isset($uniqueNodes[$item->location])) {
                $uniqueNodes[$item->location] = count($uniqueNodes) + 1;
                $nodes[] = [
                    'id' => $uniqueNodes[$item->location],
                    'label' => $item->location,
                    'title' => $persianDate,
                    'font' => ['size' => 14],
                    'group' => $item->group_id
                ];
            }

            // ساخت Edge از محل قبلی به محل فعلی و اضافه کردن اطلاعات Receiver به عنوان عنوان فلش
            if ($previousLocation !== null) {
                $edges[] = [
                    'from' => $uniqueNodes[$previousLocation],
                    'to' => $uniqueNodes[$item->location],
                    'arrows' => 'to',
                    'title' => 'تحویل گیرنده: ' . $item->Receiver // اضافه کردن اطلاعات Receiver
                ];
            }

            $previousLocation = $item->location;
        }

        $this->nodes = $nodes;
        $this->edges = $edges;
    }

    public function render()
    {
        return view('livewire.admin.infos.tools', [
            'nodes' => $this->nodes,
            'edges' => $this->edges,
            'locations' => $this->locations
        ]);
    }
}
