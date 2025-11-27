<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    // CHỈ GIỮ LẠI CÁC METHOD PUBLIC
    // XÓA CÁC METHOD ADMIN VÌ ĐÃ CHUYỂN SANG AdminController

    // Hiển thị danh sách blog (public)
    public function index()
    {
        $blogs = Blog::orderBy('created_at', 'desc')->paginate(6);
        return view('blog.index', compact('blogs'));
    }

    // Hiển thị chi tiết blog (public)
    public function show($id)
    {
        $blog = Blog::findOrFail($id);

        // Tính thời gian đọc (ước tính 200 từ/phút)
        $wordCount = str_word_count(strip_tags($blog->Content));
        $readTime = max(1, ceil($wordCount / 200));

        // Lấy bài viết trước và sau
        $prevBlog = Blog::where('BlogID', '<', $blog->BlogID)
            ->orderBy('BlogID', 'desc')
            ->first();

        $nextBlog = Blog::where('BlogID', '>', $blog->BlogID)
            ->orderBy('BlogID', 'asc')
            ->first();

        // Lấy bài viết gần đây
        $recentBlogs = Blog::where('BlogID', '!=', $blog->BlogID)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return view('blog.show', compact('blog', 'readTime', 'prevBlog', 'nextBlog', 'recentBlogs'));
    }
}
