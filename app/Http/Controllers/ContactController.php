<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
class ContactController extends Controller
{
    /**
     * Hiển thị trang liên hệ (PUBLIC)
     */
    public function showContactForm()
    {
        return view('contact.index');
    }
    /**
     * Xử lý gửi biểu mẫu liên hệ
     */
    // ContactController.php

    public function submitContactForm(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // LƯU VÀO DATABASE
        Contact::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'message' => $request->input('message'),
        ]);

        // CHUYỂN HƯỚNG VÀ HIỂN THỊ THÔNG BÁO THÀNH CÔNG
        return redirect()->back()->with('success', 'Cảm ơn bạn đã liên hệ với chúng tôi! Chúng tôi sẽ phản hồi sớm nhất có thể.');
    }
}