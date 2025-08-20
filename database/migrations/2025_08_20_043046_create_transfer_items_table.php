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
        Schema::create('transfer_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transfer_id')->constrained('transfers')->cascadeOnDelete();
            $table->foreignId('toolsinformation_id')->constrained('toolsinformations');
            $table->foreignId('toolsdetailes_id')->nullable()->constrained('toolsdetailes');
            $table->unsignedInteger('qty')->default(0);
            $table->unsignedInteger('damaged_qty')->default(0);
            $table->unsignedInteger('lost_qty')->default(0);
            $table->text('note')->nullable();
            $table->index(['transfer_id', 'toolsinformation_id']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_items');
    }
};
