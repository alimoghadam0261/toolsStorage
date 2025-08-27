<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;
use Mpdf\Mpdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;

class ToolsExport implements FromArray, WithHeadings
{
    protected $rows;

    /**
     * $rows: انتظار میره مجموعه (Collection) یا آرایه‌ای از ردیف‌ها باشه
     */
    public function __construct($rows)
    {
        $this->rows = $rows;
    }

    /**
     * برمی‌گرداند آرایه‌ای از آرایه‌ها که Laravel-Excel آن را خروجی می‌گیرد
     */
    public function array(): array
    {
        $data = [];

        foreach ($this->rows as $i => $row) {
            // ایمن کردن تبدیل تاریخ detail_created_at
            $detailDate = '-';
            if (!empty($row->detail_created_at)) {
                try {
                    if ($row->detail_created_at instanceof Carbon) {
                        $detailDate = $row->detail_created_at->format('Y-m-d H:i:s');
                    } else {
                        $detailDate = Carbon::parse($row->detail_created_at)->format('Y-m-d H:i:s');
                    }
                } catch (\Throwable $e) {
                    $detailDate = '-';
                }
            }

            $data[] = [
                $i + 1,
                    $row->name ?? '-',
                    $row->serialNumber ?? '-',
                    $row->detail_count ?? '-',
                    $row->detail_receiver ?? '-',
                    $row->detail_price ?? '-',
                $detailDate,
            ];
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            '#',
            'نام ابزار',
            'سریال',
            'تعداد (جزئیات)',
            'تحویل گیرنده',
            'قیمت',
            'تاریخ جزئیات',
        ];
    }
}
