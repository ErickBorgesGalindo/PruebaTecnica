<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Product::select('code', 'name', 'brand', 'price', 'created_at')->get()->map(fn($item) => collect($item->toArray())->except('id')->toArray());;
    }

    public function headings(): array
    {
        return ['Código', 'Nombre', 'Marca', 'Precio', 'Fecha de Creación'];
    }
}