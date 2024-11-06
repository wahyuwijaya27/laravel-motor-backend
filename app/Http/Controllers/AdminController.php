<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Motor;
use App\Models\User;
use App\Models\Activity;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Fungsi untuk menampilkan dashboard
    public function dashboard()
    {
        $totalMotors = Motor::count();
        $totalUsers = User::count();
        $recentActivities = Activity::with('user')->orderBy('created_at', 'desc')->take(5)->get();
        // // Mendapatkan nama admin yang sedang login
        // $adminName = Auth::user()->name;
        
        // Kirim data ke view admin.dashboard
        return view('admin.dashboard', compact('totalMotors', 'totalUsers', 'recentActivities'));
    }


    // Fungsi untuk menampilkan daftar motor
    public function manageMotor()
    {
        $motors = Motor::all();
        return view('admin.manage_motor', compact('motors'));
    }

    // Fungsi untuk menampilkan daftar pengguna
    public function manageUsers()
    {
        $users = User::all();
        return view('admin.manage_users', compact('users'));
    }

    // Fungsi untuk menampilkan form tambah motor
    public function createMotor()
    {
        return view('admin.create_motor'); 
    }

    // Fungsi untuk menyimpan motor baru
    public function storeMotor(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'specification' => 'required|string',
        ]);
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images/motors', 'public');
            $validatedData['image'] = $path;
        }
        
        Motor::create($validatedData);
        
        return redirect()->route('admin.motor')->with('success', 'Motor berhasil ditambahkan.');
    }

    // Fungsi untuk menampilkan form edit motor
    public function editMotor($id)
    {
        $motor = Motor::findOrFail($id);
        return view('admin.edit_motor', compact('motor'));
    }
    
    // Fungsi untuk memperbarui data motor
    public function updateMotor(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'specification' => 'required|string',
        ]);
        
        $motor = Motor::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($motor->image) {
                Storage::disk('public')->delete($motor->image);
            }
            $path = $request->file('image')->store('images/motors', 'public');
            $validatedData['image'] = $path;
        }

        $motor->update($validatedData);
        
        return redirect()->route('admin.motor')->with('success', 'Motor berhasil diperbarui.');
    }
    
    // Fungsi untuk menghapus motor
    public function destroyMotor($id)
    {
        $motor = Motor::findOrFail($id);
        
        if ($motor->image) {
            Storage::disk('public')->delete($motor->image);
        }
        
        $motor->delete();
        
        return redirect()->route('admin.motor')->with('success', 'Motor berhasil dihapus.');
    }

    // Fungsi untuk menampilkan form edit pengguna
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit_user', compact('user'));
    }

    // Fungsi untuk memperbarui data pengguna
    public function updateUser(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $user = User::findOrFail($id);
        $user->update($validatedData);

        return redirect()->route('admin.users')->with('success', 'User berhasil diperbarui.');
    }

    // Fungsi untuk menghapus pengguna
    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus.');
    }
}
