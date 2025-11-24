<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        // Dữ liệu blog mẫu
        $blogs = [
            [
                'id' => 1,
                'title' => 'Xu hướng sử dụng nhựa PET trong ngành thực phẩm',
                'excerpt' => 'Nhựa PET đang trở thành lựa chọn hàng đầu cho các sản phẩm đóng gói thực phẩm nhờ tính an toàn và thân thiện môi trường...',
                'image' => '/img/blog/blog-1.jpg',
                'date' => '15/11/2024',
                'category' => 'Công nghệ'
            ],
            [
                'id' => 2,
                'title' => 'Lợi ích của nhựa PP trong công nghiệp hóa chất',
                'excerpt' => 'Nhựa PP với khả năng kháng hóa chất vượt trội, là vật liệu lý tưởng cho các ứng dụng trong ngành công nghiệp hóa chất...',
                'image' => '/img/blog/blog-2.jpg',
                'date' => '10/11/2024',
                'category' => 'Ứng dụng'
            ],
            [
                'id' => 3,
                'title' => 'Bảo quản sản phẩm nhựa đúng cách',
                'excerpt' => 'Hướng dẫn cách bảo quản và sử dụng sản phẩm nhựa để đảm bảo tuổi thọ và an toàn cho người sử dụng...',
                'image' => '/img/blog/blog-3.jpg',
                'date' => '05/11/2024',
                'category' => 'Mẹo hay'
            ],
            [
                'id' => 4,
                'title' => 'Tái chế nhựa - Giải pháp bảo vệ môi trường',
                'excerpt' => 'Cùng tìm hiểu về quy trình tái chế nhựa và những lợi ích to lớn đối với môi trường và cộng đồng...',
                'image' => '/img/blog/blog-4.jpg',
                'date' => '01/11/2024',
                'category' => 'Môi trường'
            ],
        ];

        return view('blog.index', compact('blogs'));
    }

    public function show($id)
    {
        // Dữ liệu blog chi tiết mẫu
        $blog = [
            'id' => $id,
            'title' => 'Xu hướng sử dụng nhựa PET trong ngành thực phẩm',
            'content' => '
                <p>Nhựa PET (Polyethylene Terephthalate) đang trở thành lựa chọn hàng đầu cho các sản phẩm đóng gói thực phẩm nhờ những ưu điểm vượt trội về tính an toàn và thân thiện với môi trường.</p>
                
                <h3>Ưu điểm của nhựa PET</h3>
                <p>PET có độ trong suốt cao, cho phép người tiêu dùng dễ dàng quan sát sản phẩm bên trong. Vật liệu này cũng có khả năng chịu lực tốt, bảo vệ sản phẩm khỏi các tác động bên ngoài.</p>
                
                <h3>Ứng dụng trong thực phẩm</h3>
                <p>Từ chai nước suối, nước ngọt đến các loại chai dầu ăn, hộp đựng thực phẩm, PET đều thể hiện được tính ưu việt của mình.</p>
                
                <h3>An toàn cho sức khỏe</h3>
                <p>PET không chứa BPA, một chất có thể gây hại cho sức khỏe, nên rất an toàn khi sử dụng cho thực phẩm và đồ uống.</p>
            ',
            'image' => '/img/blog/blog-1.jpg',
            'date' => '15/11/2024',
            'category' => 'Công nghệ',
            'author' => 'Admin',
            'read_time' => '5 phút'
        ];

        return view('blog.show', compact('blog'));
    }
}
