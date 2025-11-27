<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $products = Product::with('category')
            ->when($search, function ($query) use ($search) {
                return $query->where('ProductName', 'like', "%{$search}%")
                    ->orWhere('Description', 'like', "%{$search}%");
            })
            ->orderBy('ProductID', 'desc')
            ->get();

        return view('admin.products.index', compact('products', 'search'));
    }

    /**
     * Hiển thị form tạo sản phẩm mới
     */
    public function create()
    {
        $categories = Category::where('Status', 1)->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Lưu sản phẩm mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'ProductName' => 'required|string|max:255',
            'Description' => 'nullable|string',
            'CategoryID' => 'required|exists:category,CategoryID', // SỬA: categories -> category
            'Status' => 'required|boolean',
            'Photo' => 'nullable|string|max:500', // THÊM: Photo field
        ]);

        try {
            Product::create([
                'ProductName' => $request->ProductName,
                'Description' => $request->Description,
                'CategoryID' => $request->CategoryID,
                'Photo' => $request->Photo, // THÊM: Photo
                'Status' => $request->Status,
                // XÓA: CreatedAt vì đã có DEFAULT current_timestamp()
            ]);

            return redirect()->route('admin.products')
                ->with('success', 'Sản phẩm đã được tạo thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi tạo sản phẩm: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Hiển thị chi tiết sản phẩm
     */
    public function show($id)
    {
        $product = Product::with(['category', 'variants'])->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Hiển thị form chỉnh sửa sản phẩm
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::where('Status', 1)->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Cập nhật sản phẩm
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'ProductName' => 'required|string|max:255',
            'Description' => 'nullable|string',
            'CategoryID' => 'required|exists:category,CategoryID', // SỬA: categories -> category
            'Status' => 'required|boolean',
            'Photo' => 'nullable|string|max:500', // THÊM: Photo field
        ]);

        try {
            $product->update([
                'ProductName' => $request->ProductName,
                'Description' => $request->Description,
                'CategoryID' => $request->CategoryID,
                'Photo' => $request->Photo, // THÊM: Photo
                'Status' => $request->Status,
                // XÓA: UpdatedAt vì không có trường này
            ]);

            return redirect()->route('admin.products')
                ->with('success', 'Sản phẩm đã được cập nhật thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi cập nhật sản phẩm: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Xóa sản phẩm
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $product = Product::findOrFail($id);

            // Kiểm tra xem sản phẩm có biến thể không
            $variantCount = DB::table('productvariant')->where('ProductID', $id)->count();
            if ($variantCount > 0) {
                return redirect()->route('admin.products')
                    ->with('error', 'Không thể xóa sản phẩm vì có ' . $variantCount . ' biến thể đang thuộc sản phẩm này!');
            }

            $product->delete();

            DB::commit();

            return redirect()->route('admin.products')
                ->with('success', 'Sản phẩm đã được xóa thành công!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('admin.products')
                ->with('error', 'Có lỗi xảy ra khi xóa sản phẩm: ' . $e->getMessage());
        }
    }

    /**
     * Cập nhật trạng thái sản phẩm (AJAX)
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->update([
                'Status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Trạng thái sản phẩm đã được cập nhật!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
}
