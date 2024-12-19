<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.admin_login'); // Pastikan view ini menggunakan Admin LTE
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Tambahkan validasi jika ingin

        $validation = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if($validation->fails()) {
            dd($validation->errors()->all());
        }

        if (Auth::attempt(array_merge($credentials, ['is_admin' => 1]))) { // gunakan 1 untuk true
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('admin.login')->withErrors('Login gagal, periksa kembali kredensial Anda.');
    }

    public function showRegisterForm()
    {
        return view('auth.admin_register'); 
    }

    public function register(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:2|confirmed',
        ]);

        if($validation->fails()) {
            dd($validation->errors()->all());
        }

        User::create([
            'username' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => 1, // Atur is_admin ke 1 saat registrasi
        ]);

        return redirect()->route('admin.login')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout(); // Logout dari guard 'web'
        $request->session()->invalidate(); // Menghapus sesi
        $request->session()->regenerateToken(); // Regenerasi token CSRF
        
        return redirect()->route('admin.login')->with('status', 'Anda telah berhasil logout.');
    }

}
