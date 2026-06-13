<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $categories = ProductCategory::active()->withCount('products')->get();

        $query = Product::active()->with(['category', 'images']);

        if ($request->filled('kategori')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->kategori));
        }

        if ($request->filled('cari')) {
            $query->where('name', 'like', '%' . $request->cari . '%');
        }

        $products = $query->paginate(12)->withQueryString();
        $activeCategory = $request->kategori;

        return view('catalog.index', compact('products', 'categories', 'activeCategory'));
    }

    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)->where('is_active', true)
            ->with(['category', 'images'])
            ->firstOrFail();

        $related = Product::active()
            ->where('product_category_id', $product->product_category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('catalog.show', compact('product', 'related'));
    }
}
