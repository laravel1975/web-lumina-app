// resources/js/pages/Products/Show.tsx
import { Head } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';

interface ProductProps {
    product: {
        name: string;
        description: string;
        technical_specs_cache: Record<string, { value: string; unit: string | null }>;
    };
}

export default function Show({ product }: ProductProps) {
    return (
        <AppLayout>
            <Head title={product.name} />
            <div className="max-w-7xl mx-auto py-12 px-4">
                <h1 className="text-3xl font-bold">{product.name}</h1>

                {/* ส่วนแสดง Specs จาก JSON Cache */}
                <div className="mt-8 bg-slate-50 p-6 rounded-lg border">
                    <h3 className="text-lg font-semibold mb-4">Technical Specifications</h3>
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {product.technical_specs_cache && Object.entries(product.technical_specs_cache).map(([key, spec]) => (
                            <div key={key} className="flex justify-between border-b py-2">
                                <span className="text-slate-600">{key}</span>
                                <span className="font-medium">
                                    {spec.value} {spec.unit}
                                </span>
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
