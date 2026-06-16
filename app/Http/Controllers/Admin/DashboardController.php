<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Product;
use App\Models\ProductCategory;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products'        => Product::count(),
            'categories'      => ProductCategory::count(),
            'messages'        => ContactMessage::count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
        ];

        $recent_messages = ContactMessage::latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_messages'));
    }
}
