<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'variants'])->active();

        if ($request->has('search') && $request->search) {
            $query->where('ProductName', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(12);
        $categories = Category::active()->withCount('products')->get();

        // Share categories for header component
        view()->share('categories', $categories);

        return view('products', compact('products', 'categories'));
    }

    public function category($slug)
    {
        $category = Category::where('CategoryName', 'like', '%' . $slug . '%')->first();

        if (!$category) {
            abort(404, 'Danh mục không tồn tại');
        }

        $products = Product::with(['category', 'variants'])
            ->where('CategoryID', $category->CategoryID)
            ->active()
            ->paginate(12);

        $categories = Category::active()->withCount('products')->get();

        // Share categories for header component
        view()->share('categories', $categories);

        return view('products', compact('products', 'categories', 'category'));
    }

    public function show($id)
    {
        $product = Product::with([
            'category',
            'variants.color',
            'variants.volume',
            'feedback.user',
            'documents'
        ])->findOrFail($id);

        return view('product-detail', compact('product'));
    }
}
