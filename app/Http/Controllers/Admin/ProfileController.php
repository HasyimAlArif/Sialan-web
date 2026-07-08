<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.profile.index', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins,email,' . $admin->id,
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->save();

        return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $admin = Auth::guard('admin')->user();

        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        $admin->password = Hash::make($request->password);
        $admin->save();

        return redirect()->route('admin.profile')->with('success', 'Password berhasil diubah.');
    }
}
