<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->text('summary')->nullable(); // คำอธิบายสั้นๆ หน้า List สินค้า
            $table->longText('description')->nullable(); // รายละเอียดเต็ม (Rich Text)

            // Technical Specs Cache: สำหรับเก็บข้อมูล Spec ทั้งหมดในรูปแบบ JSON
            // เพื่อให้ React ดึงไปแสดงผลได้ทันทีโดยไม่ต้อง Join ตาราง Attribute ทุกครั้ง
            $table->json('technical_specs_cache')->nullable();

            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
