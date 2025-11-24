<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Account;
use App\Models\ProductVariant;
use App\Models\Feedback;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_users' => Account::where('Role', 0)->count(),
            'total_feedbacks' => Feedback::count(),
            'low_stock_variants' => ProductVariant::where('StockQuantity', '<', 10)->count(),
        ];

        // Recent products
        $recentProducts = Product::with('category')
            ->orderBy('CreatedAt', 'desc')
            ->take(5)
            ->get();

        // Recent feedbacks
        $recentFeedbacks = Feedback::with(['product', 'user'])
            ->orderBy('SubmissionDate', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentProducts', 'recentFeedbacks'));
    }

    public function products()
    {
        $products = Product::with(['category', 'variants'])->get();
        return view('admin.products', compact('products'));
    }

    public function categories()
    {
        $categories = Category::withCount('products')->get();
        return view('admin.categories', compact('categories'));
    }

    public function users()
    {
        $users = Account::where('Role', 0)->get();
        return view('admin.users', compact('users'));
    }

    public function variants()
    {
        $variants = ProductVariant::with(['product', 'color', 'volume'])->get();
        return view('admin.variants', compact('variants'));
    }
}
