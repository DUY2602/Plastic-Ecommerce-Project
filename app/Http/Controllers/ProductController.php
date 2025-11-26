<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sortBy = $request->query('sort_by', 'default'); // Lấy tham số sắp xếp

        $query = Product::with(['category', 'variants'])
            ->when($search, function ($query) use ($search) {
                return $query->where('ProductName', 'like', '%' . $search . '%')
                    ->orWhere('Description', 'like', '%' . $search . '%');
            })
            ->where('Status', 1);

        // BƯỚC QUAN TRỌNG: ÁP DỤNG SẮP XẾP THEO GIÁ
        if ($sortBy !== 'default') {

            // 1. Dùng Subquery để tính giá thấp nhất (min_price) từ variants
            //    'min_price' là cột ảo được thêm vào truy vấn.
            $query->addSelect([
                'min_price' => ProductVariant::selectRaw('MIN(Price)')
                    ->whereColumn('ProductID', 'product.ProductID') // So sánh khóa ngoại
                    ->where('Status', 1) // (Tùy chọn) Chỉ lấy biến thể đang hoạt động
                    ->limit(1)
            ]);

            if ($sortBy === 'price_asc') {
                $query->orderBy('min_price', 'asc');
            } elseif ($sortBy === 'price_desc') {
                $query->orderBy('min_price', 'desc');
            }
        }

        // Nếu không sắp xếp theo giá, mặc định sắp xếp theo ngày tạo (CreatedAt)
        if ($sortBy === 'default') {
            $query->orderBy('CreatedAt', 'desc');
        }

        $products = $query->paginate(12)->withQueryString(); // Giữ lại tham số lọc/sắp xếp

        // ... [Phần còn lại giữ nguyên]
        $favoriteProductIds = [];
        if (Auth::check()) {
            $favoriteProductIds = Favorite::where('AccountID', Auth::id())
                ->pluck('ProductID')
                ->toArray();
        }

        $categories = Category::where('Status', 1)->get();
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
