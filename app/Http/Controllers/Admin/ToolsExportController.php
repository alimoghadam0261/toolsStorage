<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\ToolsExport;
use App\Models\ToolsInformation;
use Illuminate\Http\Request;
use Mpdf\Mpdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Maatwebsite\Excel\Facades\Excel;

class ToolsExportController extends Controller
{
    /**
     * Export tools data as PDF or Excel
     */
    public function export(Request $request)
    {
        // اعتبارسنجی ورودی
        $request->validate([
            'date_from' => 'nullable|date',
            'date_to'   => 'nullable|date',
            'format'    => 'required|in:pdf,excel',
        ]);

        $from = $request->query('date_from');
        $to   = $request->query('date_to');
        $format = $request->query('format');

        // کوئری اصلی
        $query = ToolsInformation::with('details')
            ->join('toolsdetailes', 'toolsinformations.id', '=', 'toolsdetailes.tools_information_id')
            ->select(
                'toolsinformations.*',
                'toolsdetailes.count as detail_count',
                'toolsdetailes.price as detail_price',
                'toolsdetailes.Receiver as detail_receiver',
                'toolsdetailes.created_at as detail_created_at'
            )
            ->orderBy('toolsdetailes.created_at', 'desc');

        if ($from) {
            $query->where('toolsdetailes.created_at', '>=', $from . ' 00:00:00');
        }

        if ($to) {
            $query->where('toolsdetailes.created_at', '<=', $to . ' 23:59:59');
        }

        $rows = $query->get();

        // خروجی Excel
        if ($format === 'excel') {
            $fileName = 'tools_export_' . now()->format('Ymd_His') . '.xlsx';
            return Excel::download(new ToolsExport($rows), $fileName);
        }

        // خروجی PDF
        $html = view('livewire.component.export', compact('rows', 'from', 'to'))->render();

        // تنظیمات فونت و مسیرها
        $defaultConfig = (new ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $publicFontDir = public_path('fonts');

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_left' => 12,
            'margin_right' => 12,
            'margin_top' => 10,
            'margin_bottom' => 10,
            'fontDir' => array_merge($fontDirs, [$publicFontDir]),
            'fontdata' => $fontData + [
                    'vazir' => [
                        'R' => 'vazir.ttf',
                        'B' => 'Vazir-Bold.ttf', // اگر داری
                    ],
                ],
            'default_font' => 'vazir',
            'default_direction' => 'rtl'
        ]);

        // استایل داخلی
        $mpdf->WriteHTML('<style>
            body {direction: rtl; font-family: vazir, sans-serif; font-size: 12px;}
            table {border-collapse: collapse; width: 100%;}
            th, td {border: 1px solid #ddd; padding: 6px; text-align: right;}
            th {background: #f5f5f5;}
        </style>', \Mpdf\HTMLParserMode::HEADER_CSS);

        $mpdf->WriteHTML($html);

        $fileName = 'tools_export_' . now()->format('Ymd_His') . '.pdf';

        return response()->streamDownload(function () use ($mpdf) {
            echo $mpdf->Output('', \Mpdf\Output\Destination::STRING_RETURN);
        }, $fileName, ['Content-Type' => 'application/pdf']);
    }
}
