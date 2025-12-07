<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Account;
use App\Models\Blog;
use App\Models\Colour;
use App\Models\Contact;
use App\Models\ProductVariant;
use App\Models\Feedback;
use App\Models\VisitorCount;
use App\Models\Volume;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
            'total_blogs' => Blog::count(),
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

        // Recent blogs
        $recentBlogs = Blog::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentProducts', 'recentFeedbacks', 'recentBlogs'));
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

        return view('admin.products.index', compact('products', 'categories', 'search'));
    }

    // Thêm method lowStock
    public function lowStock()
    {
        $variants = ProductVariant::with(['product', 'colour', 'volume'])
            ->where('StockQuantity', '<', 5)
            ->orderBy('StockQuantity', 'asc')
            ->orderBy('VariantID', 'desc')
            ->get();

        return view('admin.products.low-stock', compact('variants'));
    }

    // Hiển thị form thêm sản phẩm mới
    public function create()
    {
        $categories = Category::where('Status', 1)->get();
        $colours = Colour::all();
        $volumes = Volume::all();
        return view('admin.products.create', compact('categories', 'colours', 'volumes'));
    }

    // Lưu sản phẩm mới (với variants)
    public function store(Request $request)
    {
        $request->validate([
            'ProductName' => 'required|string|max:255',
            'CategoryID' => 'required|exists:category,CategoryID',
            'Description' => 'nullable|string',
            'Photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'Status' => 'required|boolean',
            'variants' => 'required|array|min:1',
            'variants.*.colour_id' => 'required|exists:colour,ColourID',
            'variants.*.volume_id' => 'required|exists:volume,VolumeID',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.stock' => 'required|integer|min:0',
            'variants.*.main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $photoPath = null;

            // Xử lý upload ảnh sản phẩm chính
            if ($request->hasFile('Photo')) {
                $file = $request->file('Photo');
                $fileName = 'product_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $directory = public_path('img/products');
                if (!file_exists($directory)) {
                    mkdir($directory, 0755, true);
                }
                $file->move($directory, $fileName);
                $photoPath = '/img/products/' . $fileName;
            }

            // Tạo sản phẩm
            $product = Product::create([
                'ProductName' => $request->ProductName,
                'Description' => $request->Description,
                'CategoryID' => $request->CategoryID,
                'Photo' => $photoPath,
                'Status' => $request->Status,
            ]);

            // Tạo các variants
            if ($request->has('variants')) {
                foreach ($request->variants as $index => $variantData) {
                    if (!empty($variantData['colour_id']) && !empty($variantData['volume_id'])) {

                        $mainImagePath = null;

                        // Xử lý upload ảnh cho variant
                        if (isset($variantData['main_image']) && $variantData['main_image']) {
                            $file = $variantData['main_image'];
                            $fileName = 'variant_' . time() . '_' . $index . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                            $directory = public_path('img/variants');
                            if (!file_exists($directory)) {
                                mkdir($directory, 0755, true);
                            }
                            $file->move($directory, $fileName);
                            $mainImagePath = '/img/variants/' . $fileName;
                        }

                        ProductVariant::create([
                            'ProductID' => $product->ProductID,
                            'ColourID' => $variantData['colour_id'],
                            'VolumeID' => $variantData['volume_id'],
                            'Price' => $variantData['price'] ?? 0,
                            'StockQuantity' => $variantData['stock'] ?? 0,
                            'MainImage' => $mainImagePath,
                            'Status' => 1,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.products')->with('success', 'Product and variants created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error occurred: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Cập nhật sản phẩm (với variants)
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'ProductName' => 'required|string|max:255',
            'CategoryID' => 'required|exists:category,CategoryID',
            'Description' => 'nullable|string',
            'Photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'Status' => 'required|boolean',
            'variants' => 'required|array|min:1',
            'variants.*.id' => 'nullable|exists:productvariant,VariantID',
            'variants.*.colour_id' => 'required|exists:colour,ColourID',
            'variants.*.volume_id' => 'required|exists:volume,VolumeID',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.stock' => 'required|integer|min:0',
            'variants.*.main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'variants.*.status' => 'nullable|boolean',
        ]);

        DB::beginTransaction();

        try {
            $photoPath = $product->Photo;

            // Xử lý upload ảnh mới cho sản phẩm
            if ($request->hasFile('Photo')) {
                if ($photoPath && file_exists(public_path($photoPath))) {
                    unlink(public_path($photoPath));
                }

                $file = $request->file('Photo');
                $fileName = 'product_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $directory = public_path('img/products');
                if (!file_exists($directory)) {
                    mkdir($directory, 0755, true);
                }
                $file->move($directory, $fileName);
                $photoPath = '/img/products/' . $fileName;
            }

            // Cập nhật sản phẩm
            $product->update([
                'ProductName' => $request->ProductName,
                'Description' => $request->Description,
                'CategoryID' => $request->CategoryID,
                'Photo' => $photoPath,
                'Status' => $request->Status,
            ]);

            // Xử lý variants
            if ($request->has('variants')) {
                $existingVariantIds = [];

                foreach ($request->variants as $index => $variantData) {
                    if (!empty($variantData['colour_id']) && !empty($variantData['volume_id'])) {
                        $mainImagePath = null;

                        // Xử lý upload ảnh cho variant
                        if (isset($variantData['main_image']) && $variantData['main_image']) {
                            $file = $variantData['main_image'];
                            $fileName = 'variant_' . time() . '_' . $index . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                            $directory = public_path('img/variants');
                            if (!file_exists($directory)) {
                                mkdir($directory, 0755, true);
                            }
                            $file->move($directory, $fileName);
                            $mainImagePath = '/img/variants/' . $fileName;
                        }

                        if (isset($variantData['id'])) {
                            // Cập nhật variant hiện có
                            $variant = ProductVariant::find($variantData['id']);
                            if ($variant && $variant->ProductID == $product->ProductID) {
                                // Nếu có ảnh mới, xóa ảnh cũ
                                if ($mainImagePath && $variant->MainImage && file_exists(public_path($variant->MainImage))) {
                                    unlink(public_path($variant->MainImage));
                                }

                                $updateData = [
                                    'ColourID' => $variantData['colour_id'],
                                    'VolumeID' => $variantData['volume_id'],
                                    'Price' => $variantData['price'] ?? 0,
                                    'StockQuantity' => $variantData['stock'] ?? 0,
                                    'Status' => $variantData['status'] ?? 1,
                                ];

                                if ($mainImagePath) {
                                    $updateData['MainImage'] = $mainImagePath;
                                }

                                $variant->update($updateData);
                                $existingVariantIds[] = $variant->VariantID;
                            }
                        } else {
                            // Tạo variant mới
                            $newVariant = ProductVariant::create([
                                'ProductID' => $product->ProductID,
                                'ColourID' => $variantData['colour_id'],
                                'VolumeID' => $variantData['volume_id'],
                                'Price' => $variantData['price'] ?? 0,
                                'StockQuantity' => $variantData['stock'] ?? 0,
                                'MainImage' => $mainImagePath,
                                'Status' => $variantData['status'] ?? 1,
                            ]);
                            $existingVariantIds[] = $newVariant->VariantID;
                        }
                    }
                }

                // Xóa các variant không còn trong danh sách
                $variantsToDelete = ProductVariant::where('ProductID', $product->ProductID)
                    ->whereNotIn('VariantID', $existingVariantIds)
                    ->get();

                foreach ($variantsToDelete as $variant) {
                    // Xóa ảnh của variant nếu có
                    if ($variant->MainImage && file_exists(public_path($variant->MainImage))) {
                        unlink(public_path($variant->MainImage));
                    }
                    $variant->delete();
                }
            }

            DB::commit();

            return redirect()->route('admin.products')->with('success', 'Product and variants updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error occurred: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Hiển thị chi tiết sản phẩm
    public function show($id)
    {
        $product = Product::with(['category', 'variants'])->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    // Hiển thị form chỉnh sửa sản phẩm (với variants)
    public function edit($id)
    {
        $product = Product::with('variants.colour', 'variants.volume')->findOrFail($id);
        $categories = Category::where('Status', 1)->get();
        $colours = Colour::all();
        $volumes = Volume::all();

        return view('admin.products.edit', compact('product', 'categories', 'colours', 'volumes'));
    }

    // Xóa sản phẩm
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);

            // Kiểm tra xem sản phẩm có biến thể không
            $variantCount = ProductVariant::where('ProductID', $id)->count();
            if ($variantCount > 0) {
                return redirect()->route('admin.products')->with('error', 'Cannot delete product because it has ' . $variantCount . ' variants!');
            }

            // Xóa ảnh sản phẩm nếu có
            if ($product->Photo && file_exists(public_path($product->Photo))) {
                unlink(public_path($product->Photo));
            }

            $product->delete();

            return redirect()->route('admin.products')->with('success', 'Product deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.products')->with('error', 'Error deleting product: ' . $e->getMessage());
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

        return view('admin.categories.index', compact('categories', 'search'));
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
            'CategoryName' => 'required|string|max:255|unique:category,CategoryName',
            'Description' => 'nullable|string',
            'Status' => 'required|boolean',
        ]);

        try {
            Category::create([
                'CategoryName' => $request->CategoryName,
                'Description' => $request->Description,
                'Status' => $request->Status,
            ]);

            return redirect()->route('admin.categories')->with('success', 'Category created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error creating category: ' . $e->getMessage())
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
            'CategoryName' => 'required|string|max:255|unique:category,CategoryName,' . $id . ',CategoryID',
            'Description' => 'nullable|string',
            'Status' => 'required|boolean',
        ]);

        try {
            $category->update([
                'CategoryName' => $request->CategoryName,
                'Description' => $request->Description,
                'Status' => $request->Status,
            ]);

            return redirect()->route('admin.categories')->with('success', 'Category updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating category: ' . $e->getMessage())
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
                return redirect()->route('admin.categories')->with('error', 'Cannot delete category because it has ' . $productCount . ' products!');
            }

            $category->delete();

            return redirect()->route('admin.categories')->with('success', 'Category deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.categories')->with('error', 'Error deleting category: ' . $e->getMessage());
        }
    }

    public function users()
    {
        $users = Account::where('Role', 0)->orderBy('AccountID', 'desc')->get();
        return view('admin.users.index', compact('users'));
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

            return redirect()->route('admin.users')->with('success', 'User updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating user: ' . $e->getMessage())
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
                return redirect()->route('admin.users')->with('error', 'Cannot delete admin account!');
            }

            // Xóa user - feedback sẽ tự động set AccountID = NULL
            $user->delete();

            DB::commit();

            return redirect()->route('admin.users')->with('success', 'User deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.users')->with('error', 'Error deleting user: ' . $e->getMessage());
        }
    }

    public function blogIndex()
    {
        $blogs = Blog::orderBy('created_at', 'desc')->get();
        return view('admin.blog.index', compact('blogs'));
    }

    /**
     * Hiển thị form tạo blog mới
     */
    public function blogCreate()
    {
        return view('admin.blog.create');
    }

    /**
     * Lưu blog mới
     */
    public function blogStore(Request $request)
    {
        $request->validate([
            'Title' => 'required|string|max:255',
            'Content' => 'required|string',
            'Image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'Author' => 'required|string|max:100',
        ]);

        try {
            $imagePath = null;

            // Xử lý upload ảnh nếu có
            if ($request->hasFile('Image')) {
                $file = $request->file('Image');

                // Tạo tên file unique
                $fileName = 'blog_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                // Tạo thư mục nếu chưa tồn tại
                $directory = public_path('img/blog');
                if (!file_exists($directory)) {
                    mkdir($directory, 0755, true);
                }

                // Di chuyển file vào thư mục public/img/blog
                $file->move($directory, $fileName);

                // Lưu đường dẫn (tương đối từ thư mục public)
                $imagePath = '/img/blog/' . $fileName;
            }

            Blog::create([
                'Title' => $request->Title,
                'Content' => $request->Content,
                'Image' => $imagePath,
                'Author' => $request->Author,
            ]);

            return redirect()->route('admin.blog.index')->with('success', 'Blog post created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error creating blog post: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Cập nhật blog
     */
    public function blogUpdate(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'Title' => 'required|string|max:255',
            'Content' => 'required|string',
            'Image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'Author' => 'required|string|max:100',
        ]);

        try {
            $imagePath = $blog->Image;

            // Xử lý upload ảnh nếu có ảnh mới
            if ($request->hasFile('Image')) {
                // Xóa ảnh cũ nếu tồn tại
                if ($imagePath && file_exists(public_path($imagePath))) {
                    unlink(public_path($imagePath));
                }

                $file = $request->file('Image');

                // Tạo tên file unique
                $fileName = 'blog_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                // Tạo thư mục nếu chưa tồn tại
                $directory = public_path('img/blog');
                if (!file_exists($directory)) {
                    mkdir($directory, 0755, true);
                }

                // Di chuyển file vào thư mục public/img/blog
                $file->move($directory, $fileName);

                // Lưu đường dẫn mới
                $imagePath = '/img/blog/' . $fileName;
            }

            $blog->update([
                'Title' => $request->Title,
                'Content' => $request->Content,
                'Image' => $imagePath,
                'Author' => $request->Author,
            ]);

            return redirect()->route('admin.blog.index')->with('success', 'Blog post updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating blog post: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Hiển thị chi tiết blog (admin view)
     */
    public function blogShow($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.blog.show', compact('blog'));
    }

    /**
     * Hiển thị form chỉnh sửa blog
     */
    public function blogEdit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.blog.edit', compact('blog'));
    }

    /**
     * Xóa blog
     */
    public function blogDestroy($id)
    {
        try {
            $blog = Blog::findOrFail($id);

            // Xóa ảnh blog nếu có
            if ($blog->Image && file_exists(public_path($blog->Image))) {
                unlink(public_path($blog->Image));
            }

            $blog->delete();

            return redirect()->route('admin.blog.index')->with('success', 'Blog post deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.blog.index')->with('error', 'Error deleting blog post: ' . $e->getMessage());
        }
    }

    // 2 hàm xử lý tin nhắn liên hệ: toggleMessageHandled và messages
    public function toggleMessageHandled($id)
    {
        $message = Contact::findOrFail($id);

        // Đảo ngược trạng thái xử lý
        $message->is_handled = !$message->is_handled;
        $message->save();

        // Chuyển hướng về trang danh sách tin nhắn với thông báo
        return redirect()->route('admin.messages')->with('success', 'Processing status updated successfully.');
    }

    public function messages()
    {
        $messages = Contact::orderBy('created_at', 'desc')->paginate(10);
        $unreadCount = Contact::where('is_read', 0)->count();
        $unhandledCount = Contact::where('is_handled', 0)->count();

        return view('admin.messages.contact_messages', compact('messages', 'unreadCount', 'unhandledCount'));
    }

    public function visitors()
    {
        // Lấy dữ liệu 30 ngày gần nhất
        $visitorStats = VisitorCount::orderBy('date', 'desc')
            ->take(30)
            ->get();

        // Tổng visitors
        $totalVisitors = VisitorCount::sum('count');

        // Today visitors
        $todayVisitors = VisitorCount::where('date', today())->value('count') ?? 0;

        // Tháng này
        $monthVisitors = VisitorCount::whereYear('date', now()->year)
            ->whereMonth('date', now()->month)
            ->sum('count');

        return view('admin.visitors.index', compact(
            'visitorStats',
            'totalVisitors',
            'todayVisitors',
            'monthVisitors'
        ));
    }

    public function reviews()
    {
        $reviews = Feedback::with(['product', 'user'])
            ->orderBy('SubmissionDate', 'desc')
            ->paginate(20);

        // Thống kê
        $stats = [
            'total' => Feedback::count(),
            'average_rating' => Feedback::avg('Rating') ?? 0,
            'five_star' => Feedback::where('Rating', 5)->count(),
            'today' => Feedback::whereDate('SubmissionDate', today())->count(),
        ];

        return view('admin.reviews.index', compact('reviews', 'stats'));
    }
}
