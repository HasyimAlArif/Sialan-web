<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AdminResetPasswordMail;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    // Token berlaku selama 60 menit
    private const TOKEN_EXPIRY_MINUTES = 60;

    // =========================================================
    //  STEP 1 — Tampilkan form permintaan reset (input email)
    // =========================================================
    public function showRequestForm()
    {
        return view('admin.auth.forgot-password');
    }

    // =========================================================
    //  STEP 1 — Proses kirim email berisi link reset
    // =========================================================
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
        ], [
            'email.exists' => 'Email ini tidak terdaftar sebagai admin.',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        // Hapus token lama jika ada
        DB::table('admin_password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        // Buat token baru
        $token = Str::random(64);

        DB::table('admin_password_reset_tokens')->insert([
            'email'      => $request->email,
            'token'      => Hash::make($token),
            'created_at' => now(),
        ]);

        // Buat URL reset dengan token plain (belum di-hash)
        $resetUrl = route('admin.password.reset.form', [
            'token' => $token,
            'email' => $request->email,
        ]);

        // Kirim email
        Mail::to($request->email)->send(
            new AdminResetPasswordMail($resetUrl, $admin->name)
        );

        return back()->with('success',
            'Link reset password telah dikirim ke email Anda. Cek inbox (atau folder spam).'
        );
    }

    // =========================================================
    //  STEP 2 — Tampilkan form password baru (dari link email)
    // =========================================================
    public function showResetForm(Request $request, string $token)
    {
        return view('admin.auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    // =========================================================
    //  STEP 2 — Proses simpan password baru
    // =========================================================
    public function reset(Request $request)
    {
        $request->validate([
            'email'                 => 'required|email|exists:admins,email',
            'token'                 => 'required',
            'password'              => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
        ], [
            'email.exists'       => 'Email tidak ditemukan.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Cari token di database
        $record = DB::table('admin_password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        // Validasi: token ada, cocok, dan belum kadaluarsa
        if (! $record || ! Hash::check($request->token, $record->token)) {
            return back()->withErrors(['token' => 'Link reset tidak valid atau sudah digunakan.']);
        }

        $expired = now()->diffInMinutes($record->created_at) > self::TOKEN_EXPIRY_MINUTES;
        if ($expired) {
            DB::table('admin_password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['token' => 'Link reset sudah kadaluarsa (60 menit). Silakan minta ulang.']);
        }

        // Update password
        Admin::where('email', $request->email)->update([
            'password' => Hash::make($request->password),
        ]);

        // Hapus token setelah berhasil
        DB::table('admin_password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('admin.login')
            ->with('success', 'Password berhasil direset! Silakan login dengan password baru Anda.');
    }
}
