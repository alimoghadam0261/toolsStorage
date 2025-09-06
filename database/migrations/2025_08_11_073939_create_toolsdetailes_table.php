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

            $table->foreignId('storage_id')
                ->constrained('storages')
                ->cascadeOnDelete();

            $table->foreignId('tools_information_id')
                ->constrained('toolsinformations')
                ->cascadeOnDelete();

            $table->string('category')->default('tools');
            $table->string('model');
            $table->integer('count')->default(0);
            $table->integer('companynumber')->nullable();
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
            $table->string('attach')->nullable();
            $table->string('status');

            $table->string('qtyTotal')->default(0);
            $table->string('qtyWritOff')->default(0);
            $table->string('qtyDamaged')->default(0);
            $table->string('qtyLost')->default(0);

            // اصلاح شد
            $table->unique(['tools_information_id', 'storage_id'], 'ux_tool_storage');
            $table->index(['storage_id']);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('toolsdetailes', function (Blueprint $table) {
            $table->dropUnique('ux_tool_storage');
            $table->dropIndex(['storage_id']);
        });

        Schema::dropIfExists('toolsdetailes');
    }
};
