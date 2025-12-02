<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Product;
use App\Models\Category; // 🔥 DÒNG CẦN THÊM (Import Model Category)
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException; // Thêm dòng này để xử lý validate

class FavoriteController extends Controller
{
    /**
     * Xử lý thêm/xóa sản phẩm yêu thích (AJAX khi bấm trái tim)
     */
    public function toggle(Request $request)
    {
        // 1. Kiểm tra đăng nhập
        if (!Auth::check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vui lòng đăng nhập để thêm sản phẩm yêu thích'
            ], 401); // 401 Unauthorized
        }

        // 2. Kiểm tra dữ liệu đầu vào
        try {
            // Đảm bảo product_id là số và tồn tại trong bảng product
            $request->validate([
                'product_id' => 'required|numeric|exists:product,ProductID',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Dữ liệu sản phẩm không hợp lệ.'
            ], 400);
        }

        $productId = $request->product_id;
        $userId = Auth::id();

        $existingFavorite = Favorite::where('AccountID', $userId)
            ->where('ProductID', $productId)
            ->first();

        if ($existingFavorite) {
            // Xóa khỏi yêu thích
            $existingFavorite->delete();
            return response()->json([
                'status' => 'removed',
                'message' => 'Đã xóa khỏi danh sách yêu thích'
            ]);
        } else {
            // Thêm vào yêu thích
            Favorite::create([
                'AccountID' => $userId,
                'ProductID' => $productId
            ]);
            return response()->json([
                'status' => 'added',
                'message' => 'Đã thêm vào danh sách yêu thích'
            ]);
        }
    }

    /**
     * Hiển thị trang sản phẩm yêu thích (Khắc phục lỗi $categories)
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xem danh sách yêu thích');
        }

        // 🔥 FIX LỖI $categories: Lấy danh mục đang hoạt động
        $categories = Category::where('Status', 1)->get();

        $userId = Auth::id();
        $favoriteProducts = Product::whereHas('favorites', function ($query) use ($userId) {
            $query->where('AccountID', $userId);
        })->with(['variants', 'category'])->get();

        // 🔥 Truyền cả $categories và $favoriteProducts vào view
        return view('favorites', compact('favoriteProducts', 'categories'));
    }
}
