<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http; 

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.admin_login'); // Pastikan view ini menggunakan Admin LTE
    }

    public function login(Request $request)
    {
        $login = $request->input('email_or_phone'); // Bisa berupa email atau nomor telepon
        $password = $request->input('password');

        $validation = Validator::make($request->all(), [
            'email_or_phone' => 'required',
            'password' => 'required',
        ]);

        if ($validation->fails()) {
            return redirect()->route('admin.login')->withErrors($validation->errors());
        }

        $credentials = filter_var($login, FILTER_VALIDATE_EMAIL)
            ? ['email' => $login, 'password' => $password, 'is_admin' => 1]
            : ['phone' => $login, 'password' => $password, 'is_admin' => 1];

        if (Auth::attempt($credentials)) {
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
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15|unique:users',
            'password' => 'required|string|min:2|confirmed',
        ]);

        if ($validation->fails()) {
            return redirect()->route('admin.register')->withErrors($validation->errors());
        }

        User::create([
            'username' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'is_admin' => 1,
        ]);

        return redirect()->route('admin.login')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|numeric',
        ]);

        $otp = rand(100000, 999999); // Generate OTP
        Session::put('otp', $otp);
        Session::put('phone', $request->phone_number);

        // Kirim OTP via WhatsApp menggunakan Fonnt API
        $response = $this->sendOtpToFonnt($request->phone_number, $otp);

        if (isset($response['status']) && $response['status'] === true) {
            return response()->json(['message' => 'OTP has been sent!'], 200);
        }

        return response()->json(['message' => 'Failed to send OTP.'], 500);
    }

    private function sendOtpToFonnt($phone, $otp)
    {
        $apiKey = "h7fkxTaeM9jprRxCHrTH";
        $message = "Kode OTP Anda adalah: $otp";

        $response = Http::withHeaders([
            'Authorization' => $apiKey,
        ])->timeout(30)->post('https://api.fonnte.com/send', [
            'target' => $phone,
            'message' => $message,
        ]);

        return $response->json();
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('status', 'Anda telah berhasil logout.');
    }
}
