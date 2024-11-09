<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input dari aplikasi Android
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'alamat_lengkap' => 'required|string',
            'nomor_telepon' => 'required|string|max:15',
            'motor_id' => 'required|exists:motors,id', // pastikan motor yang dibeli ada di database
            'bukti_transaksi' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // gambar bukti pembayaran
        ]);

        // Simpan gambar bukti transaksi jika ada
        if ($request->hasFile('bukti_transaksi')) {
            $path = $request->file('bukti_transaksi')->store('images/bukti_transaksi', 'public');
            $validatedData['bukti_transaksi'] = $path;
        }

        // Simpan data checkout ke database
        $checkout = Checkout::create($validatedData);

        return response()->json($checkout, 201);
    }

    public function showCheckouts()
    {
        $checkouts = Checkout::with('motor')->get();
        return view('admin.checkouts.manage_checkout', compact('checkouts'));
    }

}
