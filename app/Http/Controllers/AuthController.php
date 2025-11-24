<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;
use App\Models\Category;

class AuthController extends Controller
{
    public function showLogin()
    {
        $categories = Category::active()->get();
        return view('auth.login', compact('categories'));
    }

    public function login(Request $request)
    {
        // Validate
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        try {
            // 👇 THỬ CÁCH NÀY - đơn giản hơn
            $user = Account::where('Email', $credentials['email'])
                ->where('Password', $credentials['password'])
                ->where('Status', 1)
                ->first();

            if ($user) {
                // Login thủ công
                Auth::login($user);
                $request->session()->regenerate();

                // Redirect based on role
                if ($user->Role == 1) {
                    return redirect()->route('admin.dashboard')->with('success', 'Đăng nhập admin thành công!');
                }

                return redirect()->route('home')->with('success', 'Đăng nhập thành công!');
            }

            return back()->withErrors([
                'email' => 'Email hoặc mật khẩu không chính xác.',
            ])->withInput($request->except('password'));
        } catch (\Exception $e) {
            // 👇 HIỆN LỖI ĐỂ DEBUG
            return back()->withErrors([
                'email' => 'Lỗi hệ thống: ' . $e->getMessage(),
            ])->withInput($request->except('password'));
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Đăng xuất thành công!');
    }
}
