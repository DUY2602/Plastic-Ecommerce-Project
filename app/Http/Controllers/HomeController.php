<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('Status', 1)->get();
        $featuredProducts = Product::with(['variants', 'category'])
            ->where('Status', 1)
            ->take(8)
            ->get();

        $latestBlogs = Blog::orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Xử lý favorite products - chỉ khi user đã đăng nhập
        $favoriteProductIds = [];
        if (Auth::check()) {
            $favoriteProductIds = Favorite::where('AccountID', Auth::id())
                ->pluck('ProductID')
                ->toArray();
        }

        return view('home', compact('categories', 'featuredProducts', 'favoriteProductIds', 'latestBlogs'));
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
