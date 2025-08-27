<?php

namespace App\Exports;

use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class ToolsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $rows;

    public function __construct($rows)
    {
        // $rows یک Collection از query هست که Controller پاس داده
        $this->rows = $rows;
    }

    public function collection()
    {
        return $this->rows;
    }

    public function headings(): array
    {
        return [
            'نام ابزار',
            'سریال',
            'تعداد (جزئیات)',
            'تحویل گیرنده',
            'قیمت (جزئیات)',
            'تاریخ جزئیات',
            // هر ستون دیگری بخواهید اضافه کنید
        ];
    }

    public function map($row): array
    {
        // تبدیل امن تاریخ detail_created_at به رشته‌ی قابل نوشتن
        $detailDate = '-';
        if (!empty($row->detail_created_at)) {
            try {
                if ($row->detail_created_at instanceof Carbon) {
                    $detailDate = $row->detail_created_at->format('Y-m-d H:i:s');
                } else {
                    // اگر رشته است، تلاش می‌کنیم آن را parse کنیم
                    $detailDate = Carbon::parse($row->detail_created_at)->format('Y-m-d H:i:s');
                }
            } catch (\Throwable $e) {
                // اگر parse شکست خورد، مقدار پیش‌فرض نگه داشته می‌شود
                $detailDate = '-';
            }
        }

        return [
                $row->name ?? '-',
                $row->serialNumber ?? '-',
                $row->detail_count ?? '-',
                $row->detail_receiver ?? '-',
                $row->detail_price ?? '-',
            $detailDate,
        ];
    }
}
