<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Sửa lại: thay ->active() bằng ->where('Status', 1)
        $categories = Category::where('Status', 1)->get();
        $featuredProducts = Product::with(['category', 'variants'])
            ->where('Status', 1) // Thay ->active() bằng where
            ->withCount('variants')
            ->orderBy('CreatedAt', 'desc')
            ->take(8)
            ->get();

        $favoriteProductIds = [];
        $favoriteProducts = collect();

        if (Auth::check()) {
            $favoriteProductIds = Favorite::where('AccountID', Auth::id())
                ->pluck('ProductID')
                ->toArray();

            $favoriteProducts = Product::whereIn('ProductID', $favoriteProductIds)
                ->with(['category', 'variants'])
                ->get();
        }

        // Share categories with all views that use components.header
        view()->share('categories', $categories);

        return view('home', compact('categories', 'featuredProducts', 'favoriteProductIds', 'favoriteProducts'));
    }

    public function profile()
    {
        $categories = Category::where('Status', 1)->get(); // Sửa lại
        view()->share('categories', $categories);

        return view('user.profile');
    }

    public function about()
    {
        $categories = Category::where('Status', 1)->get(); // Sửa lại
        view()->share('categories', $categories);

        return view('about');
    }

    public function contact()
    {
        $categories = Category::where('Status', 1)->get(); // Sửa lại
        view()->share('categories', $categories);

        return view('contact');
    }
}
