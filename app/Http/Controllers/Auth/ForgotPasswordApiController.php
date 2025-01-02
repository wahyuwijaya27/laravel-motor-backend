<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache; // Tambahkan ini
use Illuminate\Support\Facades\Http;

class ForgotPasswordApiController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|exists:users,phone',
        ]);

        $otp = rand(100000, 999999); // Generate OTP
        $phone = $request->phone;

        // Simpan OTP di cache dengan key yang unik
        Cache::put("otp_{$request->phone}", $otp, now()->addMinutes(10));

        // Kirim OTP melalui WhatsApp menggunakan Fonnte API
        $response = $this->sendOtpToFonnt($phone, $otp);

        if (isset($response['status']) && $response['status'] === true) {
            return response()->json([
                'status' => true,
                'message' => 'OTP telah dikirim ke WhatsApp Anda.',
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Gagal mengirim OTP.',
        ], 500);
    }

    // Kirim OTP melalui API Fonnte
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
            'phone'=> 'required|exists:users,phone',
            'otp' => 'required|numeric',
        ]);

        // dd(Cache::get("otp_{$request->phone}"));
    
        $otp = Cache::get("otp_{$request->phone}");
        if ($request->otp == $otp) {
            return response()->json([
                'status' => true,
                'message' => 'OTP Valid',
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'OTP Tidak Valid',
        ], 500);
    }


    // Endpoint untuk memvalidasi OTP dan mereset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'phone' => 'required|exists:users,phone',
            'otp' => 'required|numeric',
            'password' => 'required|string|min:8',
            'c_password'=>'required'
        ]);

        // Ambil OTP yang disimpan di cache
        $otp = Cache::get("otp_{$request->phone}");

        // Validasi OTP
        if (!$otp || $otp != $request->otp) {
            return response()->json([
                'status' => false,
                'message' => 'OTP tidak valid atau telah kedaluwarsa.',
            ], 400);
        }

        // Cari user berdasarkan phone
        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Nomor telepon tidak ditemukan.',
            ], 404);
        }

        if ($request->password != $request->c_password){
            return response()->json([
                'status' => false,
                'message' => 'Password tidak sesuai',
            ], 404);
        }

        // Reset password
        $user->password = Hash::make($request->password);
        $user->save();

        // Hapus OTP dari cache
        Cache::forget("otp_{$request->phone}");

        return response()->json([
            'status' => true,
            'message' => 'Password berhasil direset. Silakan login.',
        ], 200);
    }
}
