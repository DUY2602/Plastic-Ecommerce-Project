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

                if ($user->Role == 1) {
                    return redirect()->route('admin.dashboard')->with('success', 'Đăng nhập admin thành công!');
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
                'Role' => 0,
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

        return redirect()->route('home')->with('success', 'Đăng xuất thành công!');
    }
}
