<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Hiển thị danh sách danh mục
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $categories = Category::when($search, function ($query) use ($search) {
            return $query->where('CategoryName', 'like', "%{$search}%")
                ->orWhere('Description', 'like', "%{$search}%");
        })
            ->orderBy('CategoryID', 'desc')
            ->get();

        // Đếm số sản phẩm cho mỗi danh mục
        foreach ($categories as $category) {
            $category->products_count = Product::where('CategoryID', $category->CategoryID)->count();
        }

        // Nếu là request AJAX, trả về partial view
        if ($request->ajax()) {
            return view('admin.categories.partials.table', compact('categories', 'search'));
        }

        return view('admin.categories.index', compact('categories', 'search'));
    }

    /**
     * Hiển thị form tạo danh mục mới
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Lưu danh mục mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'CategoryName' => 'required|string|max:255|unique:category,CategoryName',
            'Description' => 'nullable|string',
            'Status' => 'required|boolean',
        ]);

        try {
            Category::create([
                'CategoryName' => $request->CategoryName,
                'Description' => $request->Description,
                'Status' => $request->Status,
                // Không cần CreatedAt vì đã có DEFAULT current_timestamp()
            ]);

            return redirect()->route('admin.categories')
                ->with('success', 'Danh mục đã được tạo thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi tạo danh mục: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Hiển thị chi tiết danh mục
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);
        $category->products_count = Product::where('CategoryID', $id)->count();
        $products = Product::where('CategoryID', $id)->get();

        return view('admin.categories.show', compact('category', 'products'));
    }

    /**
     * Hiển thị form chỉnh sửa danh mục
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Cập nhật danh mục
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'CategoryName' => 'required|string|max:255|unique:category,CategoryName,' . $id . ',CategoryID',
            'Description' => 'nullable|string',
            'Status' => 'required|boolean',
        ]);

        try {
            $category->update([
                'CategoryName' => $request->CategoryName,
                'Description' => $request->Description,
                'Status' => $request->Status,
                // Không cần UpdatedAt vì không có trường này trong database
            ]);

            return redirect()->route('admin.categories')
                ->with('success', 'Danh mục đã được cập nhật thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi cập nhật danh mục: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Xóa danh mục
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $category = Category::findOrFail($id);

            // Kiểm tra xem danh mục có sản phẩm không
            $productCount = Product::where('CategoryID', $id)->count();
            if ($productCount > 0) {
                return redirect()->route('admin.categories')
                    ->with('error', 'Không thể xóa danh mục vì có ' . $productCount . ' sản phẩm đang thuộc danh mục này!');
            }

            $category->delete();

            DB::commit();

            return redirect()->route('admin.categories')
                ->with('success', 'Danh mục đã được xóa thành công!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('admin.categories')
                ->with('error', 'Có lỗi xảy ra khi xóa danh mục: ' . $e->getMessage());
        }
    }

    /**
     * API lấy danh sách danh mục (nếu cần cho select2, etc.)
     */
    public function getCategories(Request $request)
    {
        $search = $request->get('q');

        $categories = Category::where('Status', 1)
            ->when($search, function ($query) use ($search) {
                return $query->where('CategoryName', 'like', "%{$search}%");
            })
            ->orderBy('CategoryName')
            ->get(['CategoryID as id', 'CategoryName as text']);

        return response()->json($categories);
    }

    /**
     * Cập nhật trạng thái danh mục (AJAX)
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->update([
                'Status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Trạng thái đã được cập nhật!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
}
