<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Account;
use App\Models\Category;

class AuthController extends Controller
{
    public function showLogin()
    {
        $categories = Category::active()->get();
        return view('auth.login', compact('categories'));
    }

    // 🔥 PHƯƠNG THỨC HIỂN THỊ FORM ĐĂNG NHẬP ADMIN
    public function showAdminLogin()
    {
        return view('auth.admin-login');
    }

    public function showRegister()
    {
        $categories = Category::active()->get();
        return view('auth.register', compact('categories'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        try {
            $user = Account::where('Email', $credentials['email'])
                ->where('Status', 1)
                ->first();

            if ($user && Hash::check($credentials['password'], $user->Password)) {
                Auth::login($user);
                $request->session()->regenerate();

                // 🔥 CHỈ CHO PHÉP USER THƯỜNG ĐĂNG NHẬP Ở TRANG NÀY
                if ($user->Role == 1) {
                    Auth::logout();
                    return back()->withErrors([
                        'email' => 'Tài khoản admin vui lòng đăng nhập tại trang admin.',
                    ])->withInput($request->except('password'));
                }

                return redirect()->route('home')->with('success', 'Đăng nhập thành công!');
            }

            return back()->withErrors([
                'email' => 'Email hoặc mật khẩu không chính xác.',
            ])->withInput($request->except('password'));
        } catch (\Exception $e) {
            return back()->withErrors([
                'email' => 'Lỗi hệ thống: ' . $e->getMessage(),
            ])->withInput($request->except('password'));
        }
    }

    // 🔥 PHƯƠNG THỨC ĐĂNG NHẬP ADMIN
    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        try {
            $user = Account::where('Email', $credentials['email'])
                ->where('Status', 1)
                ->first();

            if ($user && Hash::check($credentials['password'], $user->Password)) {
                // 🔥 CHỈ CHO PHÉP ADMIN ĐĂNG NHẬP Ở TRANG NÀY
                if ($user->Role != 1) {
                    return back()->withErrors([
                        'email' => 'Tài khoản không có quyền truy cập admin.',
                    ])->withInput($request->except('password'));
                }

                Auth::login($user);
                $request->session()->regenerate();

                return redirect()->route('admin.dashboard')->with('success', 'Đăng nhập admin thành công!');
            }

            return back()->withErrors([
                'email' => 'Email hoặc mật khẩu không chính xác.',
            ])->withInput($request->except('password'));
        } catch (\Exception $e) {
            return back()->withErrors([
                'email' => 'Lỗi hệ thống: ' . $e->getMessage(),
            ])->withInput($request->except('password'));
        }
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string|max:255|unique:account,Username',
            'email' => 'required|email|unique:account,Email',
            'password' => 'required|string|min:6',
            'terms' => 'required|accepted',
        ], [
            'terms.required' => 'You must agree to the Terms and Conditions.',
            'terms.accepted' => 'You must agree to the Terms and Conditions.',
        ]);

        try {
            $user = Account::create([
                'Username' => $data['username'],
                'Email' => $data['email'],
                'Password' => $data['password'],
                'Role' => 0, // 🔥 LUÔN LÀ USER THƯỜNG
                'Status' => 1,
            ]);

            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->route('home')->with('success', 'Đăng ký thành công!');
        } catch (\Exception $e) {
            return back()->withErrors([
                'email' => 'Lỗi đăng ký: ' . $e->getMessage(),
            ])->withInput($request->except('password'));
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Điều hướng về trang chủ công khai cho user thường
        return redirect()->route('home')->with('success', 'Đăng xuất thành công!');
    }

    // 🔥 PHƯƠNG THỨC ĐĂNG XUẤT MỚI CHO ADMIN
    public function adminLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Điều hướng về trang đăng nhập Admin
        return redirect()->route('admin.login')->with('success', 'Đăng xuất admin thành công!');
    }
}
