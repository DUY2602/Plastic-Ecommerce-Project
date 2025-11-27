<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm (PUBLIC)
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');
        $sortBy = $request->input('sort_by', 'default');

        $query = Product::with(['category', 'variants'])
            ->when($search, function ($query, $search) {
                return $query->where('ProductName', 'like', '%' . $search . '%');
            })
            ->when($category, function ($query, $category) {
                return $query->where('CategoryID', $category);
            });

        // SORT THEO GIÁ TỪ PRODUCT VARIANT - RAW QUERY
        if ($sortBy === 'price_asc') {
            $query->orderByRaw('(SELECT MIN(Price) FROM productvariant WHERE productvariant.ProductID = product.ProductID) ASC');
        } elseif ($sortBy === 'price_desc') {
            $query->orderByRaw('(SELECT MAX(Price) FROM productvariant WHERE productvariant.ProductID = product.ProductID) DESC');
        } else {
            $query->orderBy('ProductID', 'desc');
        }

        $products = $query->paginate(12);
        $categories = Category::where('Status', 1)->get();

        return view('products.index', compact('products', 'categories', 'search', 'sortBy'));
    }

    /**
     * Hiển thị sản phẩm theo danh mục (PUBLIC)
     */
    public function category($slug, Request $request)
    {
        $sortBy = $request->input('sort_by', 'default');

        $categoryName = strtoupper($slug);
        $category = Category::where('CategoryName', $categoryName)->first();

        if (!$category) {
            $category = Category::where('CategoryName', 'like', '%' . $slug . '%')->first();
        }

        if (!$category) {
            abort(404, 'Danh mục không tồn tại');
        }

        $query = Product::with(['category', 'variants'])
            ->where('CategoryID', $category->CategoryID);

        // SORT THEO GIÁ TỪ PRODUCT VARIANT - RAW QUERY (GIỐNG NHƯ PHƯƠNG THỨC INDEX)
        if ($sortBy === 'price_asc') {
            $query->orderByRaw('(SELECT MIN(Price) FROM productvariant WHERE productvariant.ProductID = product.ProductID) ASC');
        } elseif ($sortBy === 'price_desc') {
            $query->orderByRaw('(SELECT MAX(Price) FROM productvariant WHERE productvariant.ProductID = product.ProductID) DESC');
        } else {
            $query->orderBy('ProductID', 'desc');
        }

        $products = $query->paginate(12);
        $categories = Category::where('Status', 1)->get();

        return view('products.index', compact('products', 'categories', 'category', 'sortBy'));
    }

    /**
     * Hiển thị chi tiết sản phẩm (PUBLIC)
     */
    public function show($id)
    {
        $product = Product::with(['category', 'variants'])->findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * Hiển thị form tạo sản phẩm mới (ADMIN)
     */
    public function create()
    {
        $categories = Category::where('Status', 1)->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Lưu sản phẩm mới (ADMIN)
     */
    public function store(Request $request)
    {
        $request->validate([
            'ProductName' => 'required|string|max:255',
            'Description' => 'nullable|string',
            'CategoryID' => 'required|exists:category,CategoryID',
            'Status' => 'required|boolean',
            'Photo' => 'nullable|string|max:500',
        ]);

        try {
            Product::create([
                'ProductName' => $request->ProductName,
                'Description' => $request->Description,
                'CategoryID' => $request->CategoryID,
                'Photo' => $request->Photo,
                'Status' => $request->Status,
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
     * Hiển thị form chỉnh sửa sản phẩm (ADMIN)
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::where('Status', 1)->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Cập nhật sản phẩm (ADMIN)
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'ProductName' => 'required|string|max:255',
            'Description' => 'nullable|string',
            'CategoryID' => 'required|exists:category,CategoryID',
            'Status' => 'required|boolean',
            'Photo' => 'nullable|string|max:500',
        ]);

        try {
            $product->update([
                'ProductName' => $request->ProductName,
                'Description' => $request->Description,
                'CategoryID' => $request->CategoryID,
                'Photo' => $request->Photo,
                'Status' => $request->Status,
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
     * Xóa sản phẩm (ADMIN)
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
}
