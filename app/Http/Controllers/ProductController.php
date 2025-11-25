<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $products = Product::with(['category', 'variants'])
            ->when($search, function ($query) use ($search) {
                return $query->where('ProductName', 'like', '%' . $search . '%')
                    ->orWhere('Description', 'like', '%' . $search . '%');
            })
            ->where('Status', 1) // Đảm bảo dùng where
            ->orderBy('CreatedAt', 'desc')
            ->paginate(12);

        $favoriteProductIds = [];
        if (Auth::check()) {
            $favoriteProductIds = Favorite::where('AccountID', Auth::id())
                ->pluck('ProductID')
                ->toArray();
        }

        $categories = Category::where('Status', 1)->get(); // Sửa lại
        view()->share('categories', $categories);

        return view('products', compact('products', 'favoriteProductIds'));
    }

    public function show($id)
    {
        $product = Product::with(['category', 'variants.colour', 'variants.volume'])
            ->where('ProductID', $id)
            ->where('Status', 1) // Sửa lại
            ->firstOrFail();

        $categories = Category::where('Status', 1)->get(); // Sửa lại
        view()->share('categories', $categories);

        return view('product-detail', compact('product'));
    }

    public function byCategory($categoryName)
    {
        $category = Category::where('CategoryName', strtoupper($categoryName))
            ->where('Status', 1) // Sửa lại
            ->firstOrFail();

        $products = Product::with(['category', 'variants'])
            ->where('CategoryID', $category->CategoryID)
            ->where('Status', 1) // Sửa lại
            ->paginate(12);

        $favoriteProductIds = [];
        if (Auth::check()) {
            $favoriteProductIds = Favorite::where('AccountID', Auth::id())
                ->pluck('ProductID')
                ->toArray();
        }

        $categories = Category::where('Status', 1)->get(); // Sửa lại
        view()->share('categories', $categories);

        return view('products', compact('products', 'favoriteProductIds', 'category'));
    }
}
