<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use App\Models\Motor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'alamat_lengkap' => 'required|string',
            'nomor_telepon' => 'required|string|max:15',
            'motor_id' => 'required|exists:motors,id',
            // 'bukti_transaksi' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Tambahkan `users_id` dari user yang sedang login
        $validatedData['users_id'] = Auth::id(); // Pastikan user sudah login

        // // Simpan gambar bukti transaksi jika ada
        // if ($request->hasFile('bukti_transaksi')) {
        //     $path = $request->file('bukti_transaksi')->store('images/bukti_transaksi', 'public');
        //     $validatedData['bukti_transaksi'] = $path;
        // }

        // Simpan data checkout ke database
        $checkout = Checkout::create($validatedData);

        $motor = Motor::find($checkout->motor_id);
        if(!$motor) {
            return response()->json([
                'error' => true,
                'message' => 'Motor tidak ada.'
            ]);
        }

        $motor->update([
            'status' => 'not_available'
        ]);

        // Hapus data motor dari tabel motors
        // Motor::where('id', $validatedData['motor_id'])->delete();

        return response()->json($checkout, 201);
    }

    public function getCheckouts()
    {
        // Ambil data checkout beserta user dan motor yang terkait
        $checkouts = Checkout::with(['motor', 'user'])->get();
        return response()->json($checkouts);
    }

    public function index()
    {
        $checkouts = Checkout::with('user')->get();
        return view('checkouts.index', compact('checkouts'));
    }

    public function showCheckouts()
    {
        $checkouts = Checkout::with(['motor', 'user'])->orderBy('created_at', 'desc')->get();
        
        return view('admin.checkouts.manage_checkout', compact('checkouts'));
    }

    public function getRiwayat()
    {
        // Mendapatkan data checkout yang sesuai dengan ID pengguna yang sedang login
        $checkoutData = Checkout::with('motor')
            ->where('users_id', Auth::id())
            ->get()
            ->map(function ($checkout) {
                return [
                    'nama' => $checkout->motor->name,
                    'harga' => $checkout->motor->price,
                    'created_at' => $checkout->created_at->toDateTimeString(),
                    'image' => asset('storage/' . $checkout->motor->image)
                ];
            });

        // Mengembalikan data dalam format JSON
        return response()->json($checkoutData);
    }

    public function uploadBuktiTransaksi(Request $request, $id)
    {
        $request->validate([
            'bukti_transaksi' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Simpan file ke storage
        if ($request->hasFile('bukti_transaksi')) {
            $path = $request->file('bukti_transaksi')->store('bukti_transaksi', 'public');

            // Update database atau lakukan logika lain
            $checkoutData = Checkout::find($id);
            $checkoutData->bukti_transaksi = $path;
            $checkoutData->save();
            
            return response()->json([
                'status' => 'success',
                'message' => 'Bukti transaksi berhasil diunggah',
                'file_path' => $path,
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Gagal mengunggah bukti transaksi',
        ], 400);
    }



}
