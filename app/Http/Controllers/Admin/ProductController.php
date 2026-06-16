<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->orderBy('sort_order');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category')) {
            $query->where('product_category_id', $request->category);
        }

        $products   = $query->paginate(15)->withQueryString();
        $categories = ProductCategory::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = ProductCategory::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_category_id' => ['nullable', 'exists:product_categories,id'],
            'name'                => ['required', 'string', 'max:255'],
            'short_description'   => ['nullable', 'string', 'max:500'],
            'description'         => ['nullable', 'string'],
            'price'               => ['nullable', 'numeric', 'min:0'],
            'price_unit'          => ['nullable', 'string', 'max:50'],
            'thumbnail'           => ['nullable', 'image', 'max:4096'],
            'is_featured'         => ['boolean'],
            'is_active'           => ['boolean'],
            'sort_order'          => ['integer', 'min:0'],
        ]);

        $data['slug']        = Str::slug($data['name']);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active']   = $request->boolean('is_active');
        $data['sort_order']  = $request->input('sort_order', 0);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('panel.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        $categories = ProductCategory::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'product_category_id' => ['nullable', 'exists:product_categories,id'],
            'name'                => ['required', 'string', 'max:255'],
            'short_description'   => ['nullable', 'string', 'max:500'],
            'description'         => ['nullable', 'string'],
            'price'               => ['nullable', 'numeric', 'min:0'],
            'price_unit'          => ['nullable', 'string', 'max:50'],
            'thumbnail'           => ['nullable', 'image', 'max:4096'],
            'is_featured'         => ['boolean'],
            'is_active'           => ['boolean'],
            'sort_order'          => ['integer', 'min:0'],
        ]);

        $data['slug']        = Str::slug($data['name']);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active']   = $request->boolean('is_active');
        $data['sort_order']  = $request->input('sort_order', 0);

        if ($request->hasFile('thumbnail')) {
            if ($product->thumbnail && Storage::disk('public')->exists($product->thumbnail)) {
                Storage::disk('public')->delete($product->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('products', 'public');
        }

        if ($request->boolean('delete_thumbnail')) {
            if ($product->thumbnail && Storage::disk('public')->exists($product->thumbnail)) {
                Storage::disk('public')->delete($product->thumbnail);
            }
            $data['thumbnail'] = null;
        }

        $product->update($data);

        return redirect()->route('panel.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        if ($product->thumbnail && Storage::disk('public')->exists($product->thumbnail)) {
            Storage::disk('public')->delete($product->thumbnail);
        }

        $product->delete();

        return back()->with('success', 'Produk berhasil dihapus!');
    }
}
