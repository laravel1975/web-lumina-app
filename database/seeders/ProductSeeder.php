<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\ProductAttributeValue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // --- 1. สร้างหมวดหมู่ (Categories) ---
        $catPC = Category::create([
            'name' => 'Polycarbonate (PC)',
            'slug' => 'polycarbonate',
            'description' => 'แผ่นโพลีคาร์บอเนตคุณภาพสูง ทนทานต่อแรงกระแทกและรังสียูวี'
        ]);

        $catWPC = Category::create([
            'name' => 'Wood Plastic Composite (WPC)',
            'slug' => 'wpc-decking',
            'description' => 'ไม้สังเคราะห์สำหรับงานตกแต่งภายนอกและภายใน ทนแดด ทนฝน'
        ]);

        // --- 2. สร้างนิยามคุณสมบัติ (Attributes) ---
        $attrThickness = Attribute::create(['name' => 'Thickness', 'slug' => 'thickness', 'unit' => 'mm']);
        $attrDensity = Attribute::create(['name' => 'Density', 'slug' => 'density', 'unit' => 'g/cm3']);
        $attrFireRating = Attribute::create(['name' => 'Fire Rating', 'slug' => 'fire-rating', 'unit' => null]);
        $attrSurface = Attribute::create(['name' => 'Surface Texture', 'slug' => 'surface', 'unit' => null]);

        // --- 3. สร้างสินค้าตัวอย่าง: Polycarbonate Solid Sheet ---
        $pcSolid = Product::create([
            'category_id' => $catPC->id,
            'name' => 'Lumina PC Solid Sheet - Clear',
            'slug' => 'pc-solid-sheet-clear',
            'sku' => 'PC-SS-001',
            'summary' => 'แผ่นโพลีฯ แบบตัน สีใส โปร่งแสง 90%',
            'description' => 'วัสดุวิศวกรรมคุณภาพสูง แข็งแรงกว่ากระจก 250 เท่า เหมาะสำหรับทำหลังคาโปร่งแสง...',
            'is_active' => true,
        ]);

        // เพิ่ม Specs ให้สินค้า PC
        $this->addSpec($pcSolid, $attrThickness, '3.0');
        $this->addSpec($pcSolid, $attrFireRating, 'Class B1');
        $this->addSpec($pcSolid, $attrSurface, 'Glossy');
        $pcSolid->syncSpecsCache(); // สั่งสรุปข้อมูลลง JSON

        // --- 4. สร้างสินค้าตัวอย่าง: WPC Decking Board ---
        $wpcDeck = Product::create([
            'category_id' => $catWPC->id,
            'name' => 'WPC Premium Decking - Teak Wood',
            'slug' => 'wpc-decking-teak',
            'sku' => 'WPC-DK-002',
            'summary' => 'ไม้พื้นสังเคราะห์ สีไม้สัก สัมผัสธรรมชาติ',
            'description' => 'ไม้พื้นรุ่นพรีเมียม ป้องกันปลวก 100% ไม่บิดงอ ทนทานต่อความชื้นสูง...',
            'is_active' => true,
        ]);

        // เพิ่ม Specs ให้สินค้า WPC
        $this->addSpec($wpcDeck, $attrThickness, '25');
        $this->addSpec($wpcDeck, $attrDensity, '1.3');
        $this->addSpec($wpcDeck, $attrSurface, 'Wood Grain Embossed');
        $wpcDeck->syncSpecsCache();

        // --- 5. เพิ่มเอกสารตัวอย่าง (Download Center) ---
        $pcSolid->documents()->create([
            'title' => 'PC Solid Sheet Data Sheet (TDS)',
            'file_path' => 'catalogs/pc-solid-tds.pdf',
            'type' => 'catalog'
        ]);

        $wpcDeck->documents()->create([
            'title' => 'ASTM D7031 Test Report',
            'file_path' => 'tests/wpc-astm-report.pdf',
            'type' => 'astm'
        ]);
    }

    /**
     * Helper สำหรับเพิ่มค่า Attribute แบบง่ายๆ
     */
    private function addSpec($product, $attribute, $value)
    {
        ProductAttributeValue::create([
            'product_id' => $product->id,
            'attribute_id' => $attribute->id,
            'value' => $value
        ]);
    }
}
