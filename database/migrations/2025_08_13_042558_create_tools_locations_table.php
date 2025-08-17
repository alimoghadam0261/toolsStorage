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
        Schema::create('tools_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tools_information_id')
                ->constrained('toolsinformations') // اسم واقعی جدول مرجع
                ->onDelete('cascade');
            $table->string('location');
            $table->string('Receiver');
            $table->string('status');
            $table->timestamp('moved_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tools_locations');
    }
};
