<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Motor;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Menampilkan daftar keranjang
    public function index()
    {
        $carts = Cart::with('motor')->where('user_id', auth()->id())->get();
        return response()->json($carts);
    }

    // Menambahkan motor ke keranjang
    public function store(Request $request)
    {
        $request->validate([
            'motor_id' => 'required|exists:motors,id',
        ]);

        $cart = Cart::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'motor_id' => $request->motor_id,
            ],
        );

        return response()->json(['message' => 'Motor ditambahkan ke keranjang', 'cart' => $cart]);
    }

    // Menghapus motor dari keranjang
    public function destroy($id)
    {
        $cart = Cart::where('user_id', auth()->id())->findOrFail($id);
        $cart->delete();

        return response()->json(['message' => 'Motor dihapus dari keranjang']);
    }
}
