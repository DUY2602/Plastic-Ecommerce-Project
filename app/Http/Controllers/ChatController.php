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

        if (!Auth::check()) {
            return response()->json(['error' => 'Vui lòng đăng nhập trước'], 401);
        }

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
        return "Bạn là trợ lý AI cho Plastic Store - cửa hàng chai nhựa.

QUAN TRỌNG:
- LUÔN trả lời bằng TIẾNG VIỆT
- Trả lời ĐẦY ĐỦ, ít nhất 3-4 câu
- Dùng **in đậm** cho từ khóa quan trọng
- Xuống dòng hợp lý giữa các ý

THÔNG TIN SẢN PHẨM:
• PET: Chai nước suối, nước ngọt - trong suốt, an toàn thực phẩm
• PP: Chai hóa chất, dầu gội - chịu nhiệt, kháng hóa chất  
• PC: Bình thể thao, bình giữ nhiệt - bền, cao cấp

Hãy trả lời chi tiết và hữu ích!";
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
