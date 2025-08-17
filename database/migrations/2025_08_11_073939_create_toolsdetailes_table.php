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
        Schema::create('toolsdetailes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tools_information_id')
                ->constrained('toolsinformations')
                ->cascadeOnDelete();
            $table->enum('category',['tools','jam'])->default('tools');
            $table->string('brand');
            $table->string('model');
            $table->string('Weight');
            $table->string('TypeOfConsumption');
            $table->string('size');
            $table->string('Receiver');
            $table->string('price');
            $table->string('StorageLocation');
            $table->string('color')->default('blackDefault');
            $table->date('dateOfSale')->nullable();
            $table->date('dateOfexp')->nullable();
            $table->longText('content')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('toolsdetailes');
    }
};
