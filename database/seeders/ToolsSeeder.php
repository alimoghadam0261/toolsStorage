<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\ToolsInformation;
use App\Models\ToolsDetail;
use App\Models\Storage;

class ToolsSeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Mechanical', 'Electronic', 'Hardware', 'Software'];
        $colors = ['red', 'blue', 'green', 'yellow', 'black', 'gray'];
        $storages = Storage::pluck('id')->toArray();

        if (empty($storages)) {
            $this->command->warn("❌ جدول storages خالی است. لطفاً اول انبارها را seed کن.");
            return;
        }

        $this->command->info("⏳ شروع ایجاد 50 ابزار با جزئیات...");

        $details = [];

        // ایجاد progress bar
        $bar = $this->command->getOutput()->createProgressBar(50);
        $bar->start();

        for ($i = 1; $i <= 50; $i++) {
            // ایجاد ابزار در جدول toolsinformations
            $tool = ToolsInformation::create([
                'name' => 'Tool ' . Str::upper(Str::random(5)),
                'serialNumber' => 'SN-' . strtoupper(Str::random(10)),
            ]);

            // تولید 1 تا 3 جزییات برای هر ابزار
            $detailCount = rand(1, 3);
            $usedStorages = [];

            for ($j = 0; $j < $detailCount; $j++) {
                // جلوگیری از تکرار انبار برای یک ابزار
                $storageId = $storages[array_rand($storages)];
                while (in_array($storageId, $usedStorages)) {
                    $storageId = $storages[array_rand($storages)];
                }
                $usedStorages[] = $storageId;

                $details[] = [
                    'storage_id' => $storageId,
                    'tools_information_id' => $tool->id,
                    'category' => $categories[array_rand($categories)],
                    'model' => 'MD-' . strtoupper(Str::random(4)),
                    'count' => rand(1, 500),
                    'companynumber' => rand(1000, 9999),
                    'Weight' => rand(1, 100) . 'kg',
                    'TypeOfConsumption' => 'نوع ' . strtoupper(Str::random(3)),
                    'size' => rand(10, 200) . 'cm',
                    'Receiver' => 'کاربر ' . rand(1, 20),
                    'price' => rand(10000, 500000),
                    'StorageLocation' => 'انبار شماره ' . rand(1, 5),
                    'color' => $colors[array_rand($colors)],
                    'dateOfSale' => now()->subDays(rand(0, 365)),
                    'dateOfexp' => now()->addDays(rand(30, 365)),
                    'content' => 'توضیحات مربوط به ابزار شماره ' . $i,
                    'attach' => null,
                    'status' => 'سالم',
                    'qty_total' => rand(10, 100),
                    'qty_in_use' => rand(0, 50),
                    'qty_damaged' => rand(0, 10),
                    'qty_lost' => rand(0, 5),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            $bar->advance();
        }

        // اجرای یک insert بزرگ برای افزایش سرعت
        ToolsDetail::insert($details);

        $bar->finish();
        $this->command->info("\n✅ تعداد 200 ابزار با جزییاتشان ساخته شد.");
    }
}
