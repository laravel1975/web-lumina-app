<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_attribute_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('attribute_id')->constrained()->onDelete('cascade');
            $table->string('value'); // ค่าที่ระบุ เช่น "6.0", "Class A", "UV Protected"
            $table->timestamps();

            // Index เพื่อความเร็วในการทำ Filtering สินค้าตามคุณสมบัติ
            $table->index(['product_id', 'attribute_id']);
            $table->index('value');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_attribute_values');
    }
};
