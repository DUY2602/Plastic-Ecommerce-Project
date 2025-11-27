<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Account;
use App\Models\ProductVariant;
use App\Models\Feedback;
use App\Models\VisitorCount;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_users' => Account::where('Role', 0)->count(),
            'total_feedbacks' => Feedback::count(),
            'low_stock_variants' => ProductVariant::where('StockQuantity', '<', 10)->count(),
            'today_visitors' => VisitorCount::where('date', today())->value('count') ?? 0,
            'total_visitors' => VisitorCount::sum('count'),
        ];

        // Recent products
        $recentProducts = Product::with('category')
            ->orderBy('CreatedAt', 'desc')
            ->take(5)
            ->get();

        // Recent feedbacks
        $recentFeedbacks = Feedback::with(['product'])
            ->orderBy('SubmissionDate', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentProducts', 'recentFeedbacks'));
    }

    public function products(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');

        $query = Product::with(['category', 'variants']);

        // Tìm kiếm theo tên sản phẩm
        if ($search) {
            $query->where('ProductName', 'like', '%' . $search . '%');
        }

        // Lọc theo danh mục
        if ($category) {
            $query->where('CategoryID', $category);
        }

        $products = $query->orderBy('ProductID', 'desc')->get();
        $categories = Category::where('Status', 1)->get();

        return view('admin.products', compact('products', 'categories', 'search'));
    }

    public function variants()
    {
        $variants = ProductVariant::with(['product', 'colour', 'volume'])->orderBy('VariantID', 'desc')->get();
        return view('admin.variants', compact('variants'));
    }

    // Hiển thị form thêm sản phẩm mới
    public function create()
    {
        $categories = Category::where('Status', 1)->get();
        return view('admin.products.create', compact('categories'));
    }

    // Lưu sản phẩm mới
    public function store(Request $request)
    {
        $request->validate([
            'ProductName' => 'required|string|max:255',
            'CategoryID' => 'required|exists:category,CategoryID', // SỬA: categories -> category
            'Description' => 'nullable|string',
            'Photo' => 'nullable|string|max:500', // SỬA: Không dùng upload file
            'Status' => 'required|boolean',
        ]);

        try {
            Product::create([
                'ProductName' => $request->ProductName,
                'Description' => $request->Description,
                'CategoryID' => $request->CategoryID,
                'Photo' => $request->Photo, // SỬA: Dùng string path
                'Status' => $request->Status,
                // XÓA: CreatedAt vì đã có DEFAULT
            ]);

            return redirect()->route('admin.products')->with('success', 'Sản phẩm đã được thêm thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi thêm sản phẩm: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Hiển thị chi tiết sản phẩm
    public function show($id)
    {
        $product = Product::with(['category', 'variants'])->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    // Hiển thị form chỉnh sửa sản phẩm
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::where('Status', 1)->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // Cập nhật sản phẩm
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'ProductName' => 'required|string|max:255',
            'CategoryID' => 'required|exists:category,CategoryID', // SỬA: categories -> category
            'Description' => 'nullable|string',
            'Photo' => 'nullable|string|max:500', // SỬA: Không dùng upload file
            'Status' => 'required|boolean',
        ]);

        try {
            $product->update([
                'ProductName' => $request->ProductName,
                'Description' => $request->Description,
                'CategoryID' => $request->CategoryID,
                'Photo' => $request->Photo, // SỬA: Dùng string path
                'Status' => $request->Status,
                // XÓA: UpdatedAt vì không có trường này
            ]);

            return redirect()->route('admin.products')->with('success', 'Sản phẩm đã được cập nhật thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi cập nhật sản phẩm: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Xóa sản phẩm
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);

            // Kiểm tra xem sản phẩm có biến thể không
            $variantCount = ProductVariant::where('ProductID', $id)->count();
            if ($variantCount > 0) {
                return redirect()->route('admin.products')->with('error', 'Không thể xóa sản phẩm vì có ' . $variantCount . ' biến thể đang thuộc sản phẩm này!');
            }

            $product->delete();

            return redirect()->route('admin.products')->with('success', 'Sản phẩm đã được xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.products')->with('error', 'Có lỗi xảy ra khi xóa sản phẩm: ' . $e->getMessage());
        }
    }

    public function categories(Request $request)
    {
        $search = $request->input('search');

        $query = Category::query();

        // Tìm kiếm theo tên danh mục
        if ($search) {
            $query->where('CategoryName', 'like', '%' . $search . '%')
                ->orWhere('Description', 'like', '%' . $search . '%');
        }

        $categories = $query->orderBy('CategoryID', 'desc')->get();

        // Đếm số sản phẩm cho mỗi danh mục
        foreach ($categories as $category) {
            $category->products_count = Product::where('CategoryID', $category->CategoryID)->count();
        }

        return view('admin.categories', compact('categories', 'search'));
    }

    // Hiển thị form thêm danh mục mới
    public function createCategory()
    {
        return view('admin.categories.create');
    }

    // Lưu danh mục mới
    public function storeCategory(Request $request)
    {
        $request->validate([
            'CategoryName' => 'required|string|max:255|unique:category,CategoryName', // SỬA: categories -> category
            'Description' => 'nullable|string',
            'Status' => 'required|boolean',
        ]);

        try {
            Category::create([
                'CategoryName' => $request->CategoryName,
                'Description' => $request->Description,
                'Status' => $request->Status,
                // XÓA: CreatedAt vì đã có DEFAULT
            ]);

            return redirect()->route('admin.categories')->with('success', 'Danh mục đã được thêm thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi thêm danh mục: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Hiển thị chi tiết danh mục
    public function showCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->products_count = Product::where('CategoryID', $id)->count();
        $products = Product::where('CategoryID', $id)->with('variants')->get();

        return view('admin.categories.show', compact('category', 'products'));
    }

    // Hiển thị form chỉnh sửa danh mục
    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    // Cập nhật danh mục
    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'CategoryName' => 'required|string|max:255|unique:category,CategoryName,' . $id . ',CategoryID', // SỬA: categories -> category
            'Description' => 'nullable|string',
            'Status' => 'required|boolean',
        ]);

        try {
            $category->update([
                'CategoryName' => $request->CategoryName,
                'Description' => $request->Description,
                'Status' => $request->Status,
                // XÓA: UpdatedAt vì không có trường này
            ]);

            return redirect()->route('admin.categories')->with('success', 'Danh mục đã được cập nhật thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi cập nhật danh mục: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Xóa danh mục
    public function destroyCategory($id)
    {
        try {
            $category = Category::findOrFail($id);

            // Kiểm tra xem danh mục có sản phẩm không
            $productCount = Product::where('CategoryID', $id)->count();
            if ($productCount > 0) {
                return redirect()->route('admin.categories')->with('error', 'Không thể xóa danh mục vì có ' . $productCount . ' sản phẩm đang thuộc danh mục này!');
            }

            $category->delete();

            return redirect()->route('admin.categories')->with('success', 'Danh mục đã được xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.categories')->with('error', 'Có lỗi xảy ra khi xóa danh mục: ' . $e->getMessage());
        }
    }

    public function users()
    {
        $users = Account::where('Role', 0)->orderBy('AccountID', 'desc')->get();
        return view('admin.users', compact('users'));
    }

    // Hiển thị form chỉnh sửa user
    public function editUser($id)
    {
        $user = Account::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // Cập nhật user
    public function updateUser(Request $request, $id)
    {
        $user = Account::findOrFail($id);

        $request->validate([
            'Username' => 'required|string|max:255|unique:account,Username,' . $id . ',AccountID',
            'Email' => 'required|email|unique:account,Email,' . $id . ',AccountID',
            'Role' => 'required|in:0,1',
            'Status' => 'required|in:0,1',
            'password' => 'nullable|min:6',
        ]);

        try {
            $updateData = [
                'Username' => $request->Username,
                'Email' => $request->Email,
                'Role' => $request->Role,
                'Status' => $request->Status,
            ];

            // Chỉ cập nhật mật khẩu nếu có nhập
            if ($request->password) {
                $updateData['Password'] = bcrypt($request->password);
            }

            $user->update($updateData);

            return redirect()->route('admin.users')->with('success', 'Cập nhật người dùng thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi cập nhật người dùng: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Xóa user
    public function destroyUser($id)
    {
        DB::beginTransaction();

        try {
            $user = Account::findOrFail($id);

            if ($user->Role == 1) {
                return redirect()->route('admin.users')->with('error', 'Không thể xóa tài khoản admin!');
            }

            // Xóa user - feedback sẽ tự động set AccountID = NULL
            $user->delete();

            DB::commit();

            return redirect()->route('admin.users')->with('success', 'Người dùng đã được xóa thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.users')->with('error', 'Có lỗi xảy ra khi xóa người dùng: ' . $e->getMessage());
        }
    }
}
