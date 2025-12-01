<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm (PUBLIC)
     */
    public function index(Request $request)
    {
        $query = Product::with(['variants', 'category'])
            ->where('product.Status', 1);

        // Xử lý tìm kiếm
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('product.ProductName', 'like', "%{$search}%");
        }

        // Xử lý danh mục
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('CategoryName', '=', $request->category);
            });
        }

        // Xử lý sắp xếp
        $sortBy = $request->get('sort_by', 'default');
        switch ($sortBy) {
            case 'price_asc':
                $query->addSelect([
                    'min_price' => ProductVariant::selectRaw('MIN(Price)')
                        ->whereColumn('ProductID', 'product.ProductID')
                ])->orderBy('min_price', 'ASC');
                break;

            case 'price_desc':
                $query->addSelect([
                    'max_price' => ProductVariant::selectRaw('MAX(Price)')
                        ->whereColumn('ProductID', 'product.ProductID')
                ])->orderBy('max_price', 'DESC');
                break;

            default:
                $query->orderBy('product.ProductID', 'desc');
                break;
        }

        $products = $query->get();
        $categories = Category::where('Status', 1)->get();

        // Xử lý favorite products
        $favoriteProductIds = [];
        if (Auth::check()) {
            $favoriteProductIds = Favorite::where('AccountID', Auth::id())
                ->pluck('ProductID')
                ->toArray();
        }

        // Nếu là AJAX request, trả về HTML của product list
        // Trong phần AJAX response của ProductController
        if ($request->ajax()) {
            $html = '';

            if ($products->count() > 0) {
                foreach ($products as $product) {
                    $isFavorite = in_array($product->ProductID, $favoriteProductIds);
                    $minPrice = $product->variants->min('Price') * 1000;

                    $html .= '
            <div class="col-lg-4 col-md-4 col-sm-6 mb-4">
                <div class="product__item">
                    <div class="product__item__pic">
                        <img src="' . asset($product->Photo) . '" alt="' . $product->ProductName . '" class="img-fluid">
                        <ul class="product__item__pic__hover">
                            <li>
                                <a href="#" class="favorite-btn" data-product-id="' . $product->ProductID . '" title="Yêu thích">
                                    ' . ($isFavorite ?
                        '<i class="fa fa-heart heart-icon" style="color: #ff0000"></i>' :
                        '<i class="fa fa-heart heart-icon" style="color: #000000ff"></i>') . '
                                </a>
                            </li>
                            <li>
                                <a href="' . route('product.download', $product->ProductID) . '" class="download-btn" title="Tải tài liệu">
                                    <i class="fa fa-download download-icon"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="product__item__text">
                        <h6><a href="' . route('product.detail', $product->ProductID) . '" class="product-link">' . $product->ProductName . '</a></h6>
                        <h5>từ ' . number_format($minPrice, 0, ',', '.') . 'đ</h5>
                    </div>
                </div>
            </div>';
                }
            } else {
                $html = '<div class="col-12 text-center py-5"><h4>Không tìm thấy sản phẩm nào</h4><p>Vui lòng thử lại với bộ lọc khác</p></div>';
            }

            return response()->json([
                'success' => true,
                'products' => $products,
                'html' => $html,
                'count' => $products->count()
            ]);
        }

        return view('products.index', compact('products', 'categories', 'favoriteProductIds'));
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

    //download file
    public function downloadFile($id)
    {
        // 1. Tìm sản phẩm và kiểm tra đường dẫn
        $product = Product::select('ProductID', 'ProductName', 'DocumentURL')
            ->where('ProductID', $id)
            ->firstOrFail();


        $documentUrl = $product->DocumentURL;


        if (!$documentUrl) {
            // Không có đường dẫn nào được lưu
            abort(404, 'Sản phẩm này không có tài liệu để tải xuống.');
        }


        // 2. Xây dựng đường dẫn vật lý (dựa trên vị trí lưu file trong storage/app)
        $filePath = storage_path('app/' . $documentUrl);


        // Đặt tên file tải xuống
        $fileName = $product->ProductName . '_TaiLieuKyThuat.pdf';


        // 3. Kiểm tra file có tồn tại
        if (!File::exists($filePath)) {
            abort(404, 'File tài liệu không tìm thấy trên server.');
        }


        // 4. Trả về Response download
        return response()->download($filePath, $fileName);
    }
}
