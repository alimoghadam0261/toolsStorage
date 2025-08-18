<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ToolsSeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['IPR', 'Tools', 'Electronic', 'Mechanical'];

        for ($i = 1; $i <= 12; $i++) {
            $toolId = DB::table('toolsinformations')->insertGetId([
                'name' => 'ابزار شماره ' . $i,
                'serialNumber' => 'SN-' . rand(1000, 9999),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // برای هر ابزار 3 دیتیل بساز
            for ($j = 1; $j <= 3; $j++) {
                DB::table('toolsdetailes')->insert([
                    'tools_information_id' => $toolId,
                    'count' => rand(1, 50),
                    'Weight' => rand(1, 50),
                    'size' => rand(1, 50),
                    'color' => rand(1, 50),
                    'category' => $categories[array_rand($categories)],
                    'status' => "سالم",
                    'StorageLocation' => "انبار مرکزی",
                    'model' => 'مدل ' . Str::upper(Str::random(3)),
                    'TypeOfConsumption' => 'نوع مصرف ' . Str::upper(Str::random(3)),
                    'Receiver' => 'کاربر ' . $j,
                    'price' => rand(10000, 500000),
                    'storage_id' => rand(1, 3),
                    'attach' => null, // میشه عکس پیشفرض یا اسم فایل بزاری
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
