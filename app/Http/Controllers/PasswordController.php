<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    // Tampilkan form
    public function showForm()
    {
        return view('password_reset');
    }

    // Proses reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'pertanyaan' => 'required',
            'jawaban' => 'required',
            'password_baru' => 'required|min:6'
        ]);

        // Cari user
        $user = User::where('username', $request->username)->first();

        // Verifikasi jawaban (ini contoh sederhana)
        if ($user && $request->jawaban === "jawaban_benar") {
            // Update password
            $user->password = Hash::make($request->password_baru);
            $user->save();

            return redirect()->back()->with('success', 'Password berhasil direset!');
        }

        return redirect()->back()->with('error', 'Gagal reset password. Periksa data Anda.');
    }
}
