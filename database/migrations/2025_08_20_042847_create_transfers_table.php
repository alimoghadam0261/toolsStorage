<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');

            // از کدام انبار به کدام انبار
            $table->foreignId('from_storage_id')->nullable()->constrained('storages');
            $table->foreignId('to_storage_id')->nullable()->constrained('storages');

            // وضعیت‌ها طبق خواسته‌ی شما
            // sent: ارسال شده، returned: بازگشته، in_progress: در حال کار/در مسیر
            $table->enum('status', ['sent','returned','in_progress'])->default('in_progress');

            // برای رهگیری/گزارش‌گیری
            $table->string('number', 32)->unique(); // مثلاً TR-20250820-0001
            $table->string('reason')->nullable();   // دلیل: انتقال، تعمیر، خرابی، ...
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->text('note')->nullable();



            $table->index(['status']);
            $table->index(['from_storage_id', 'to_storage_id']);
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
