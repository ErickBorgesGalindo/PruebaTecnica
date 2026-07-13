<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['code' => 'PROD-001', 'name' => 'Laptop HP', 'brand' => 'HP', 'price' => 15999],
            ['code' => 'PROD-002', 'name' => 'Mouse Logitech', 'brand' => 'Logitech', 'price' => 499],
            ['code' => 'PROD-003', 'name' => 'Teclado Mecánico', 'brand' => 'Redragon', 'price' => 1299],
            ['code' => 'PROD-004', 'name' => 'Monitor Samsung', 'brand' => 'Samsung', 'price' => 5499],
            ['code' => 'PROD-005', 'name' => 'Audífonos Sony', 'brand' => 'Sony', 'price' => 2199],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}