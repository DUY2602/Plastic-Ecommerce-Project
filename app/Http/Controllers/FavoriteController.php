<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggle(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Vui lòng đăng nhập'], 401);
        }

        $productId = $request->input('product_id');
        $userId = Auth::id();

        $existingFavorite = Favorite::where('AccountID', $userId)
            ->where('ProductID', $productId)
            ->first();

        if ($existingFavorite) {
            // Xóa khỏi yêu thích
            $existingFavorite->delete();
            return response()->json(['status' => 'removed']);
        } else {
            // Thêm vào yêu thích
            Favorite::create([
                'AccountID' => $userId,
                'ProductID' => $productId
            ]);
            return response()->json(['status' => 'added']);
        }
    }

    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $categories = Category::where('Status', 1)->get(); // Sửa lại
        view()->share('categories', $categories);

        $favoriteProducts = Product::whereHas('favorites', function ($query) {
            $query->where('AccountID', Auth::id());
        })->with(['variants'])->get();

        return view('favorites', compact('favoriteProducts'));
    }
}
