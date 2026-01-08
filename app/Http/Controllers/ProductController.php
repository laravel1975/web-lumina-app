<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * หน้า Catalog สินค้าทั้งหมด
     */
    public function index(Request $request)
    {
        $query = Product::query()->with(['category'])->where('is_active', true);

        // Filter ตามหมวดหมู่ (ถ้ามี)
        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        return Inertia::render('Products/Index', [
            'products' => $query->latest()->paginate(12)->withQueryString(),
            'categories' => Category::all(['id', 'name', 'slug']),
            'filters' => $request->only(['category', 'search'])
        ]);
    }

    /**
     * หน้ารายละเอียดสินค้า (Product Detail)
     */
    public function show($slug)
    {
        $product = Product::with(['category', 'documents'])
            ->where('slug', $slug)
            ->firstOrFail();

        return Inertia::render('Products/Show', [
            'product' => $product,
            // ข้อมูล Specs จะอยู่ใน $product->technical_specs_cache เรียบร้อยแล้ว
        ]);
    }
}
