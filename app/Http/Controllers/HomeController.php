<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::featured()->with('category')->take(6)->get();
        $categories = ProductCategory::active()->withCount('products')->take(6)->get();

        return view('home', compact('featuredProducts', 'categories'));
    }

    public function about()
    {
        return view('about');
    }
}
