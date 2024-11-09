<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Motor;
use App\Models\Activity; // Import model Activity
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MotorController extends Controller
{
    public function index()
    {
        return Motor::all(); // Mengambil semua motor
    }

    public function show($id)
    {
        return Motor::findOrFail($id); // Mengambil motor berdasarkan ID
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'specification' => 'nullable|string', // Validasi untuk spesifikasi
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images/motors', 'public');
            $validatedData['image'] = $path;
        }

        // Menyimpan data motor dengan spesifikasi
        $motor = Motor::create($validatedData);

        // Simpan aktivitas penambahan motor
        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'Added a new motor',
        ]);

        return response()->json($motor, 201); // Mengembalikan data motor yang baru dibuat
    }

    public function update(Request $request, $id)
    {
        $motor = Motor::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'specification' => 'nullable|string', // Validasi untuk spesifikasi
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($motor->image) {
                Storage::disk('public')->delete($motor->image);
            }
            $path = $request->file('image')->store('images/motors', 'public');
            $validatedData['image'] = $path;
        }

        // Mengupdate data motor dengan spesifikasi
        $motor->update($validatedData);

        // Simpan aktivitas pembaruan motor
        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'Updated motor details',
        ]);

        return response()->json($motor, 200); // Mengembalikan data motor yang diperbarui
    }

    public function destroy($id)
    {
        $motor = Motor::findOrFail($id);
        
        if ($motor->image) {
            Storage::disk('public')->delete($motor->image);
        }

        $motor->delete();

        // Simpan aktivitas penghapusan motor
        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'Deleted a motor',
        ]);

        return response()->json(null, 204); // Mengembalikan status 204 No Content
    }

    public function getRecommendedMotors()
    {
        
        $motors = Motor::where('is_recommended', '1')->get();

        // Modifikasi URL gambar menjadi URL publik
        foreach ($motors as $motor) {
            if ($motor->image) {
                $motor->image = asset('storage/' . $motor->image);
            }
        
        }

        $motors = $motors->map(function($motor) {
            $motor->price = "Rp" . number_format($motor->price, 0, ",", ".");

            return $motor;
        });

        return response()->json($motors);
    }

}
