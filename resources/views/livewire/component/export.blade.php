<div>
    <div class="title">گزارش ابزارها</div>
    <div class="meta">بازه: {{ $from ?: '-' }} تا {{ $to ?: '-' }}</div>

    <table class="table-auto w-full border-collapse">
        <thead>
        <tr>
            <th class="border px-2 py-1">#</th>
            <th class="border px-2 py-1">نام ابزار</th>
            <th class="border px-2 py-1">سریال</th>
            <th class="border px-2 py-1">تعداد (جزئیات)</th>
            <th class="border px-2 py-1">تحویل گیرنده</th>
            <th class="border px-2 py-1">قیمت</th>
            <th class="border px-2 py-1">تاریخ جزئیات</th>
        </tr>
        </thead>
        <tbody>
        @foreach($rows as $i => $row)
            <tr>
                <td class="border px-2 py-1">{{ $i + 1 }}</td>
                <td class="border px-2 py-1">{{ $row->name }}</td>
                <td class="border px-2 py-1">{{ $row->serialNumber }}</td>
                <td class="border px-2 py-1">{{ $row->detail_count ?? '-' }}</td>
                <td class="border px-2 py-1">{{ $row->detail_receiver ?? '-' }}</td>
                <td class="border px-2 py-1">{{ $row->detail_price ?? '-' }}</td>
                <td class="border px-2 py-1">{{ $row->detail_created_at ? \Carbon\Carbon::parse($row->detail_created_at)->format('Y/m/d H:i') : '-' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <style>
        div { direction: rtl; font-family: vazir, sans-serif; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: right; vertical-align: top; }
        th { background: #f5f5f5; }
        .title { text-align: center; margin-bottom: 10px; font-size: 14px; font-weight: bold; }
        .meta { margin-bottom: 6px; font-size: 12px; }
    </style>
</div>
