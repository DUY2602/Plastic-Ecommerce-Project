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
        // 1. Lấy danh mục (để hiển thị sidebar/menu)
        $categories = Category::where('Status', 1)->get();

        // 2. Lấy sản phẩm nổi bật (Featured Products)
        $featuredProducts = Product::with(['variants', 'category'])
            ->where('Status', 1)
            ->take(4)
            ->get();

        // 3. Lấy bài viết blog mới nhất
        $latestBlogs = Blog::orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // 4. Lấy ID sản phẩm yêu thích của người dùng hiện tại
        $favoriteProductIds = [];
        $favoriteProducts = collect(); // Khởi tạo collection rỗng cho sản phẩm yêu thích

        if (Auth::check()) {
            // Lấy danh sách ID sản phẩm yêu thích
            $favoriteProductIds = Favorite::where('AccountID', Auth::id())
                ->pluck('ProductID')
                ->toArray();

            // Lấy thông tin chi tiết sản phẩm yêu thích
            if (!empty($favoriteProductIds)) {
                $favoriteProducts = Product::with(['variants', 'category'])
                    ->whereIn('ProductID', $favoriteProductIds)
                    ->where('Status', 1)
                    ->take(6) // Giới hạn hiển thị 6 sản phẩm trên trang chủ
                    ->get();
            }
        }

        // Truyền tất cả dữ liệu vào view
        return view('home', compact(
            'categories',
            'featuredProducts',
            'favoriteProductIds',
            'latestBlogs',
            'favoriteProducts'
        ));
    }

    public function profile()
    {
        $categories = Category::where('Status', 1)->get();
        view()->share('categories', $categories);

        return view('user.profile');
    }

    public function about()
    {
        $categories = Category::where('Status', 1)->get();
        view()->share('categories', $categories);

        return view('about');
    }

    public function contact()
    {
        $categories = Category::where('Status', 1)->get();
        view()->share('categories', $categories);

        return view('contact');
    }
}
