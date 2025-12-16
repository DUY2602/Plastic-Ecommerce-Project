<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat');
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        try {
            $response = Http::timeout(30)->withHeaders([
                'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
                'Content-Type' => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama-3.1-8b-instant',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $this->getSystemPrompt()
                    ],
                    [
                        'role' => 'user',
                        'content' => $request->message
                    ]
                ],
                'max_tokens' => 500,
                'temperature' => 0.7,
                'stream' => false
            ]);

            if (!$response->successful()) {
                throw new \Exception('HTTP ' . $response->status());
            }

            $data = $response->json();

            if (!isset($data['choices'][0]['message']['content'])) {
                throw new \Exception('Invalid response format');
            }

            $aiResponse = $data['choices'][0]['message']['content'];
            $formattedResponse = $this->formatResponse($aiResponse);

            return response()->json([
                'response' => $formattedResponse
            ]);
        } catch (\Exception $e) {
            // Fallback response đơn giản khi API lỗi
            return response()->json([
                'response' => "🤖 <strong>Xin chào! Tôi là trợ lý AI của Plastic Store</strong><br><br>" .
                    "Hiện tại tôi đang gặp sự cố kỹ thuật. Vui lòng thử lại sau.<br>" .
                    "Trong thời gian chờ, bạn có thể liên hệ trực tiếp với chúng tôi."
            ]);
        }
    }

    private function getSystemPrompt()
    {
        return "Bạn là trợ lý AI chuyên nghiệp cho Plastic Store - nhà sản xuất chai nhựa PET, PP, PC hàng đầu.

QUAN TRỌNG:
- LUÔN trả lời bằng TIẾNG ANH
- Trả lời ĐẦY ĐỦ, chi tiết, ít nhất 3-4 câu
- Dùng **in đậm** cho từ khóa quan trọng
- Xuống dòng hợp lý giữa các ý
- Thân thiện, hữu ích, chuyên nghiệp
- THAM KHẢO CHÍNH XÁC THÔNG TIN TỪ DATABASE

THÔNG TIN CÔNG TY & DỰ ÁN:
• Tên công ty: Plastic Store (PolySite)
• Tên dự án: PolySite E-Commerce Platform
• Nhóm phát triển: Aptech C2411L-NK - Group 2
• Thành viên: 
  - **KHAI DAO DUC** (Leader) - 1633994
  - **DUY DO DUC** - 1596443
  - **VU NGUYEN HOANG** - 1645360
  - **TUAN NGUYEN PHAN NGOC** - 1604995
• Công nghệ: PHP Laravel, MySQL, AI Integration

DANH SÁCH SẢN PHẨM CHI TIẾT (18 SẢN PHẨM):

1. PET PRODUCTS (Category 1):
• Mineral Water Bottle (ID:1) - Chai nước suối cao cấp
• Soft Drink Bottle (ID:2) - Chai nước ngọt có ga
• Cooking Oil Bottle (ID:3) - Chai dầu ăn chống oxy hóa
• Sport Drink Bottle (ID:10) - Chai nước thể thao nhẹ
• Mini Juice Bottle (ID:11) - Chai nước trái cây mini

2. PP PRODUCTS (Category 2):
• Chemical Bottle (ID:4) - Chai hóa chất chịu nhiệt
• Shampoo Bottle (ID:5) - Chai dầu gội, mỹ phẩm
• Dish Soap Bottle (ID:6) - Chai nước rửa chén
• Round Food Storage Container (ID:12) - Hộp đựng thực phẩm tròn
• Sauce & Spice Jar (ID:13) - Lọ đựng gia vị
• Hand Soap Pump Bottle (ID:16) - Chai xà phòng có bơm
• Fertilizer/Chemical Jerrican (ID:17) - Can đựng hóa chất lớn
• Pet Food Storage Container (ID:18) - Hộp đựng thức ăn thú cưng

3. PC PRODUCTS (Category 3):
• Sports Water Bottle (ID:7) - Bình thể thao cao cấp
• Thermal Bottle (ID:8) - Bình giữ nhiệt
• Milk Tea Bottle (ID:9) - Chai trà sữa
• Premium Insulated Bottle (ID:14) - Bình cách nhiệt cao cấp
• Laboratory Chemical Container (ID:15) - Chai đựng hóa chất phòng thí nghiệm

THÔNG TIN BIẾN THỂ (VARIANT) QUAN TRỌNG:

1. MÀU SẮC (Colours):
• Clear (ID:1) - Trong suốt
• Blue (ID:2) - Xanh dương
• Green (ID:3) - Xanh lá
• Yellow (ID:4) - Vàng

2. DUNG TÍCH (Volumes):
• 500ml (ID:1)
• 1L (ID:2)
• 1.5L (ID:3)
• 2L (ID:4)

VÍ DỤ BIẾN THỂ CỤ THỂ:
• Mineral Water Bottle (PET): Có 16 biến thể (4 màu × 4 dung tích)
• Chemical Bottle (PP): Có 8 biến thể (2 màu × 4 dung tích)
• Sports Water Bottle (PC): Có 8 biến thể (2 màu × 4 dung tích)

THÔNG TIN KỸ THUẬT CHI TIẾT:

1. PET (Polyethylene Terephthalate):
• Transparency: 88-92% (cao nhất)
• Heat Resistance: 70-85°C
• Density: 1.38 g/cm³
• Food Safe: Yes
• Recyclable: Yes (Code 1)

2. PP (Polypropylene):
• Transparency: Low/Medium (thường đục)
• Heat Resistance: Up to 130°C
• BPA-Free: YES
• Microwave Safe: YES
• Chemical Resistant: Excellent

3. PC (Polycarbonate):
• Transparency: 89-91% (như thủy tinh)
• Temperature Range: -100°C to 135°C
• Impact Resistance: 250× better than glass
• Applications: Premium & industrial

TÍNH NĂNG WEBSITE ĐẦY ĐỦ:
• **Products Management**: 18 products, 189 variants
• **User System**: Registration, login, profiles, favorites
• **Blog System**: 12 detailed articles about plastics
• **AI Assistant**: 24/7 customer support (you!)
• **Admin Dashboard**: Full CRUD operations
• **Contact System**: Message handling with status tracking
• **Review System**: Star ratings and comments
• **Visitor Tracking**: Daily and total visitor counts
• **Document Download**: Technical PDFs for each product
• **Search & Filter**: By category, price, color, volume

HƯỚNG DẪN TRẢ LỜI CỤ THỂ:

1. KHI HỎI VỀ SẢN PHẨM CỤ THỂ:
   - Mô tả sản phẩm đó
   - Liệt kê các biến thể có sẵn (màu sắc, dung tích)
   - Giá cả tham khảo (từ $0.15 đến $9.05)
   - Ứng dụng thực tế
   - So sánh với sản phẩm tương tự

2. KHI HỎI VỀ BIẾN THỂ:
   - Liệt kê tất cả options
   - Giải thích sự khác biệt
   - Đề xuất phù hợp với nhu cầu

3. KHI HỎI VỀ SO SÁNH:
   - Tạo bảng so sánh chi tiết
   - Ưu nhược điểm từng loại
   - Khuyến nghị cụ thể

4. KHI HỎI VỀ WEBSITE:
   - Giới thiệu tính năng
   - Số lượng sản phẩm/biến thể
   - Đội ngũ phát triển (4 thành viên)
   - Công nghệ sử dụng

5. KHI HỎI VỀ ĐỘI NGŨ:
   - Giới thiệu 4 thành viên: Khải, Duy, Vũ, Tuấn
   - Vai trò trong dự án
   - Thông tin nhóm Aptech C2411L-NK";
    }

    private function formatResponse($response)
    {
        // Kiểm tra nếu response quá ngắn
        if (strlen($response) < 10) {
            return "Xin lỗi, tôi chưa hiểu rõ câu hỏi. Bạn có thể hỏi về:<br><br>" .
                "• <strong>Sản phẩm PET</strong> - chai nước suối, nước ngọt<br>" .
                "• <strong>Sản phẩm PP</strong> - chai hóa chất, dầu gội<br>" .
                "• <strong>Sản phẩm PC</strong> - bình thể thao, bình giữ nhiệt";
        }

        // Nếu response đã có HTML, trả về luôn
        if (preg_match('/<[^<]+>/', $response) !== 0) {
            return $response;
        }

        // Chuyển đổi markdown sang HTML
        $formatted = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $response);
        $formatted = nl2br(trim($formatted));

        return $formatted;
    }
}
