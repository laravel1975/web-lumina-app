// resources/js/pages/Products/Index.tsx
import { useState } from 'react';
import { Head, router } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Checkbox } from '@/components/ui/checkbox';
import { Label } from '@/components/ui/label';
import { Badge } from '@/components/ui/badge';
import { Box, Filter, Search, ArrowRight, X } from 'lucide-react';
import { Input } from '@/components/ui/input';
import { motion, AnimatePresence } from 'framer-motion'; // แนะนำให้ลงเพิ่มเพื่อความ Smooth

interface Props {
    products: { data: any[] };
    categories: any[];
    filters: { category?: string; search?: string };
}

export default function Index({ products, categories, filters }: Props) {
    const [search, setSearch] = useState(filters.search || '');

    const handleFilterChange = (type: string, value: string) => {
        router.get(route('products.index'), {
            ...filters,
            [type]: value === filters[type as keyof typeof filters] ? '' : value,
        }, { preserveState: true, replace: true });
    };

    return (
        <AppLayout>
            <Head title="Material Catalog - LUMINA" />

            {/* Hero Section - ปรับพื้นหลังเป็น Gradient ชมพูอ่อนไปเขียวจางๆ */}
            <div className="relative overflow-hidden bg-gradient-to-br from-pink-50 via-white to-emerald-50 py-16 border-b">
                <div className="absolute top-0 right-0 w-64 h-64 bg-emerald-100/50 rounded-full blur-3xl -mr-32 -mt-32" />
                <div className="absolute bottom-0 left-0 w-64 h-64 bg-pink-100/50 rounded-full blur-3xl -ml-32 -mb-32" />

                <div className="max-w-7xl mx-auto px-4 relative z-10 text-center">
                    <motion.div initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }}>
                        <Badge className="bg-emerald-100 text-emerald-700 hover:bg-emerald-100 border-none mb-4 px-4 py-1">
                            LUMINA PREMIUM MATERIALS
                        </Badge>
                        <h1 className="text-4xl md:text-5xl font-black text-slate-900 mb-4 tracking-tight">
                            Innovative <span className="text-emerald-600">Architectural</span> Solutions
                        </h1>
                        <p className="text-slate-500 max-w-2xl mx-auto text-lg">
                            Explore our high-performance PC, PVC, and WPC materials designed for the next generation of construction.
                        </p>
                    </motion.div>
                </div>
            </div>

            <div className="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div className="flex flex-col lg:flex-row gap-10">

                    {/* --- SIDE FILTER (Glass Design) --- */}
                    <aside className="w-full lg:w-72 space-y-8">
                        <div className="bg-white/50 backdrop-blur-sm border border-slate-200 rounded-3xl p-6 sticky top-24 shadow-sm">
                            <div className="flex items-center justify-between mb-6">
                                <div className="flex items-center gap-2">
                                    <div className="bg-emerald-500 p-2 rounded-xl">
                                        <Filter className="w-4 h-4 text-white" />
                                    </div>
                                    <h2 className="font-bold text-slate-800">Filter Selection</h2>
                                </div>
                                {(filters.category || filters.search) && (
                                    <button onClick={() => router.get(route('products.index'))} className="text-xs text-pink-500 hover:text-pink-600 font-medium">Reset</button>
                                )}
                            </div>

                            <div className="space-y-6">
                                <div>
                                    <h3 className="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Material Types</h3>
                                    <div className="space-y-3">
                                        {categories.map((cat) => (
                                            <div
                                                key={cat.id}
                                                className={`flex items-center p-3 rounded-2xl cursor-pointer transition-all ${filters.category === cat.slug ? 'bg-emerald-50 border-emerald-100 border' : 'hover:bg-slate-50 border border-transparent'}`}
                                                onClick={() => handleFilterChange('category', cat.slug)}
                                            >
                                                <Checkbox
                                                    id={`cat-${cat.id}`}
                                                    checked={filters.category === cat.slug}
                                                    className="data-[state=checked]:bg-emerald-500 data-[state=checked]:border-emerald-500 mr-3"
                                                />
                                                <Label htmlFor={`cat-${cat.id}`} className="cursor-pointer font-medium text-slate-700 grow">
                                                    {cat.name}
                                                </Label>
                                            </div>
                                        ))}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </aside>

                    {/* --- MAIN CONTENT --- */}
                    <main className="flex-1">
                        {/* Search Bar - Modern Rounded */}
                        <div className="relative mb-10 group">
                            <Search className="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 w-5 h-5 group-focus-within:text-emerald-500 transition-colors" />
                            <Input
                                placeholder="Looking for specific SKU or texture? Try searching here..."
                                className="h-14 pl-14 pr-6 rounded-3xl border-slate-200 bg-white shadow-sm focus-visible:ring-emerald-500 focus-visible:border-emerald-500 text-lg transition-all"
                                value={search}
                                onChange={(e) => setSearch(e.target.value)}
                                onKeyDown={(e) => e.key === 'Enter' && handleFilterChange('search', search)}
                            />
                        </div>

                        {/* Product Grid */}
                        <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">
                            <AnimatePresence>
                                {products.data.map((product, index) => (
                                    <motion.div
                                        key={product.id}
                                        initial={{ opacity: 0, y: 20 }}
                                        animate={{ opacity: 1, y: 0 }}
                                        transition={{ delay: index * 0.1 }}
                                    >
                                        <Card className="group overflow-hidden rounded-[2.5rem] border-slate-100 bg-white hover:shadow-2xl hover:shadow-emerald-100/50 transition-all duration-500 cursor-pointer"
                                              onClick={() => router.get(route('products.show', product.slug))}>
                                            <CardContent className="p-0">
                                                {/* Image Placeholder with Gradient Overlay */}
                                                <div className="relative aspect-[4/3] bg-slate-100 overflow-hidden">
                                                    <div className="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity" />
                                                    <div className="absolute inset-0 flex items-center justify-center">
                                                        <Box className="w-16 h-16 text-slate-200 group-hover:scale-110 group-hover:text-emerald-200 transition-transform duration-500" />
                                                    </div>
                                                    <Badge className="absolute top-4 left-4 bg-white/90 backdrop-blur-md text-slate-800 border-none px-3 py-1 rounded-full shadow-sm font-bold text-[10px]">
                                                        {product.category.name}
                                                    </Badge>
                                                </div>

                                                <div className="p-6">
                                                    <h3 className="font-bold text-xl text-slate-800 mb-2 group-hover:text-emerald-600 transition-colors">{product.name}</h3>
                                                    <p className="text-slate-500 text-sm mb-6 line-clamp-2 leading-relaxed">{product.summary}</p>

                                                    {/* Quick Specs - Chips Design */}
                                                    <div className="flex flex-wrap gap-2 mb-6">
                                                        {product.technical_specs_cache && Object.entries(product.technical_specs_cache).slice(0, 2).map(([key, spec]: any) => (
                                                            <div key={key} className="bg-pink-50/50 px-3 py-1.5 rounded-xl border border-pink-100">
                                                                <span className="text-[10px] uppercase font-bold text-pink-400 block tracking-tight">{key}</span>
                                                                <span className="text-xs font-bold text-slate-700">{spec.value} {spec.unit}</span>
                                                            </div>
                                                        ))}
                                                    </div>

                                                    <div className="flex items-center justify-between group/btn">
                                                        <span className="text-sm font-bold text-emerald-600 flex items-center gap-1 opacity-0 group-hover:opacity-100 -translate-x-2 group-hover:translate-x-0 transition-all">
                                                            Discover More <ArrowRight className="w-4 h-4" />
                                                        </span>
                                                        <span className="text-[10px] font-black text-slate-300 tracking-tighter uppercase group-hover:opacity-0 transition-opacity">
                                                            SKU: {product.sku}
                                                        </span>
                                                    </div>
                                                </div>
                                            </CardContent>
                                        </Card>
                                    </motion.div>
                                ))}
                            </AnimatePresence>
                        </div>

                        {/* Empty State */}
                        {products.data.length === 0 && (
                            <div className="text-center py-32 bg-slate-50 rounded-[3rem] border-2 border-dashed border-slate-200">
                                <div className="bg-white w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm">
                                    <X className="w-8 h-8 text-pink-300" />
                                </div>
                                <h3 className="text-xl font-bold text-slate-800 mb-2">No results found</h3>
                                <p className="text-slate-500 mb-6">We couldn't find any materials matching your filters.</p>
                                <Button className="rounded-full bg-emerald-500 hover:bg-emerald-600 px-8" onClick={() => router.get(route('products.index'))}>
                                    Clear all filters
                                </Button>
                            </div>
                        )}
                    </main>
                </div>
            </div>
        </AppLayout>
    );
}
