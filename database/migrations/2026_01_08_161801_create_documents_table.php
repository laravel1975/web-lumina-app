<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('title'); // เช่น "ใบรับรอง ISO 9001", "ผลทดสอบ ASTM"
            $table->string('file_path');
            $table->enum('type', ['iso', 'astm', 'catalog', 'sds', 'manual'])->default('catalog');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
