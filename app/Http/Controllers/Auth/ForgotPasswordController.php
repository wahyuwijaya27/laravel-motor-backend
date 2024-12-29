<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http; // Tambahkan ini

class ForgotPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('auth.forgot_password');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|numeric|exists:users,phone',
        ]);

        $otp = rand(100000, 999999); // Generate OTP
        Session::put('otp', $otp);
        Session::put('phone', $request->phone);

        // Kirim OTP via WhatsApp menggunakan Fonnt API
        $response = $this->sendOtpToFonnt($request->phone, $otp);

        if (isset($response['status']) && $response['status'] === true) {
            return redirect()->route('forgot-password.reset-form')->with('success', 'OTP telah dikirim ke WhatsApp Anda.');
        }

        return redirect()->route('forgot-password.reset-form')->withErrors('Gagal mengirim OTP.');
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

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        if ($request->otp == Session::get('otp')) {
            return view('auth.reset_password');
        }

        return redirect()->route('forgot-password.form')->withErrors('OTP tidak valid.');
    }

    public function resetPasswordForm()
    {
        $phone = Session::get('phone');
        $otp = Session::get('otp');

        if($phone == null && $otp == null) {
            return redirect()->route('forgot-password.form');
        }

        return view('auth.reset_password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'otp' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $otp = Session::get('otp');
        if($request->otp != $otp) {
            return 'Salah bos!';
        }

        $phone = Session::get('phone');
        $user = User::where('phone', $phone)->first();

        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();

            Session::forget(['otp', 'phone']);

            return redirect()->route('admin.login')->with('success', 'Password berhasil direset. Silakan login.');
        }

        return redirect()->route('forgot-password.form')->withErrors('Terjadi kesalahan. Silakan coba lagi.');
    }
}
