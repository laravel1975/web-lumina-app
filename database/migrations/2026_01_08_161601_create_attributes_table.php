<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // ความหนา, ความหนาแน่น, มาตรฐานการลามไฟ
            $table->string('slug')->unique(); // thickness, density, fire-rating
            $table->string('unit')->nullable(); // mm, g/cm3, หรือค่าว่าง
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attributes');
    }
};
