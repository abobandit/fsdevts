<?php

namespace App\Http\Controllers\Api;

use App\ApiHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
   public function index(Request $request)
    {
        $query = Product::query()->with('category');
        if ($request->filled('category')) {

            $query->where('category_id', $request->category);
        }
        return  $query->orderBy('id')->paginate(10);
    }

    public function show(Product $product)
    {
        return $product->load('category');
    }

    public function store(StoreProductRequest $request)
    {
        return Product::create($request->validated());
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        return $product->load('category');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->noContent();
    }
    public function getTrashed()
    {
        return ApiHelper::response(data:Product::onlyTrashed()->get()) ;
    }

    public function restore(string $productId)
    {
        $product = Product::withTrashed()->find($productId);
        return $product->restore();
    }
}
