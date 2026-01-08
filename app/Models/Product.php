<?php

// app/Models/Product.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'sku',
        'summary', 'description', 'technical_specs_cache', 'is_active'
    ];

    protected $casts = [
        'technical_specs_cache' => 'array',
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function attributeValues(): HasMany
    {
        return $this->hasMany(ProductAttributeValue::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    /**
     * ฟังก์ชันสำหรับ Sync ข้อมูลจากตาราง Normalization ลงสู่ JSON Cache
     * ช่วยให้หน้า Frontend ดึงข้อมูลได้เร็วโดยไม่ต้อง Join
     */
    public function syncSpecsCache()
    {
        $specs = $this->attributeValues()
            ->with('attribute')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->attribute->name => [
                    'value' => $item->value,
                    'unit' => $item->attribute->unit,
                    'slug' => $item->attribute->slug
                ]];
            });

        $this->update(['technical_specs_cache' => $specs]);
    }
}
