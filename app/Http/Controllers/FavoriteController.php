<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggle(Request $request)
    {
        // Kiểm tra đăng nhập
        if (!Auth::check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vui lòng đăng nhập để thêm sản phẩm yêu thích'
            ], 401);
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

    public function index()
    {
        // Kiểm tra đăng nhập
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xem danh sách yêu thích');
        }

        $userId = Auth::id();
        $favoriteProducts = Product::whereHas('favorites', function ($query) use ($userId) {
            $query->where('AccountID', $userId);
        })->with(['variants', 'category'])->get();

        return view('favorites.index', compact('favoriteProducts'));
    }
}
