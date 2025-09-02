<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Users extends Seeder
{
    public function run(): void
    {
        $roles = ['مدیر','انباردار','کاربر'];
        $departments = ['فنی','اداری','مالی'];

        // گرفتن مقادیر موجود برای جلوگیری از تکرار
        $existingMobiles = DB::table('users')->pluck('mobile')->toArray();
        $existingCardNumbers = DB::table('users')->pluck('cardNumber')->map(function($v){ return (string)$v; })->toArray();

        $usedMobiles = [];      // موبایل‌هایی که در همین اجرا تولید شده‌اند
        $usedCardNumbers = [];  // کارت‌نمبرهایی که در همین اجرا تولید شده‌اند

        $rows = [];
        $needed = 40;

        for ($i = 0; $i < $needed; $i++) {
            $mobile = $this->generateUniqueMobile($existingMobiles, $usedMobiles);
            $usedMobiles[] = $mobile;

            $cardNumber = $this->generateUniqueCardNumber($existingCardNumbers, $usedCardNumbers);
            $usedCardNumbers[] = $cardNumber;

            $rows[] = [
                'name' => 'USER-' . Str::upper(Str::random(4)),
                'role' => $roles[array_rand($roles)],
                'mobile' => $mobile,
                'department' => $departments[array_rand($departments)],
                'cardNumber' => $cardNumber,
                'storage' => 'انبار ذخیره',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // درج دسته‌ای
        foreach (array_chunk($rows, 100) as $chunk) {
            DB::table('users')->insert($chunk);
        }
    }

    /**
     * تولید یک موبایل یکتا با فرمت 09XXXXXXXXX
     */
    private function generateUniqueMobile(array $existing, array $used): string
    {
        $attempts = 0;
        do {
            $candidate = '09' . mt_rand(100000000, 999999999); // 9 رقم بعد از 09
            $attempts++;
            if ($attempts > 1000) {
                throw new \RuntimeException('Unable to generate unique mobile after 1000 attempts.');
            }
        } while (in_array($candidate, $existing) || in_array($candidate, $used));

        return $candidate;
    }

    /**
     * تولید یک cardNumber یکتا (اینجا 6 رقمی) و جلوگیری از تداخل با DB و batch فعلی
     */
    private function generateUniqueCardNumber(array $existing, array $used): int
    {
        $attempts = 0;
        do {
            // تولید عدد 6 رقمی
            $candidate = mt_rand(100000, 999999);
            $attempts++;
            if ($attempts > 1000) {
                throw new \RuntimeException('Unable to generate unique cardNumber after 1000 attempts.');
            }
        } while (in_array((string)$candidate, $existing) || in_array((string)$candidate, $used));

        return $candidate;
    }
}
