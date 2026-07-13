<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Traits\Auditable;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    use Auditable;

    public function index()
    {
        return Product::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'price' => 'required|numeric|max:999',
        ]);

        $product = Product::create([
            'code'  => 'PROD-' . strtoupper(Str::random(6)),
            'name'  => $request->name,
            'brand' => $request->brand,
            'price' => $request->price,
        ]);

        $this->logAudit('product', 'created', null, $product->toArray());

        return response()->json($product, 201);
    }

    public function show($id)
    {
        return Product::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $oldData = $product->toArray();

        $request->validate([
            'name'  => 'sometimes|required|string|max:255',
            'brand' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric|max:999',
        ]);

        $product->update($request->only(['name', 'brand', 'price']));

        $this->logAudit('product', 'updated', $oldData, $product->toArray());

        return response()->json($product);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $oldData = $product->toArray();

        $product->delete();

        $this->logAudit('product', 'deleted', $oldData, null);

        return response()->json(['message' => 'Producto eliminado']);
    }
}