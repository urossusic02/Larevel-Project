<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProductRequest;
use App\Models\Products;

class AdminController extends Controller
{
    public function index()
    {
        $products = Products::all();
        return view('admin', compact('products'));
    }
    public function editProduct(string $name)
    {
        $product = Products::where(['name' => $name])->first();
        return $product ? view('editProduct', compact('product')) : redirect(route('admin'));
    }
    public function updateProduct(UpdateProductRequest $request)
    {
        $product = Products::where(['id' => $request->get('product_id')])->first();
        $nameChanged = $product->name !== $request->get('name');
        if ($nameChanged && Products::where(['name' => $request->get('name')])->first() != null)
        {
            return redirect('greska');
        }

    }
    public function deleteProduct($productId)
    {
        Products::where(['id' => $productId])->delete();
        return response()->json([
           'success' => true,
        ]);

    }
}