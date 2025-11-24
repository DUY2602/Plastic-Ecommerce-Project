<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::active()->get();
        $featuredProducts = Product::with(['category', 'variants'])
            ->active()
            ->withCount('variants')
            ->orderBy('CreatedAt', 'desc')
            ->take(8)
            ->get();

        // Share categories with all views that use components.header
        view()->share('categories', $categories);

        return view('home', compact('categories', 'featuredProducts'));
    }

    public function profile()
    {
        $categories = Category::active()->get();
        view()->share('categories', $categories);

        return view('user.profile');
    }

    public function about()
    {
        $categories = Category::active()->get();
        view()->share('categories', $categories);

        return view('about');
    }

    public function contact()
    {
        $categories = Category::active()->get();
        view()->share('categories', $categories);

        return view('contact');
    }
}
