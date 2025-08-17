<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('toolsdetailes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('storage_id')->constrained('storages')->cascadeOnDelete();
            $table->foreignId('tools_information_id')->constrained('toolsinformations')->cascadeOnDelete();
            $table->string('category')->default('tools');
            $table->string('model');
            $table->integer('count')->default(0);
            $table->string('Weight');
            $table->string('TypeOfConsumption');
            $table->string('size');
            $table->string('Receiver');
            $table->decimal('price', 12, 2);
            $table->string('StorageLocation');
            $table->string('color')->default('blackDefault');
            $table->date('dateOfSale')->nullable();
            $table->date('dateOfexp')->nullable();
            $table->longText('content')->nullable();
            $table->string('attach')->nullable(); // فایل عکس
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('toolsdetailes');
    }
};
