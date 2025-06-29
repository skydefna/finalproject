<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController
{
    public function create()
    {
        return view('auth.buatpassword');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik'           => 'required|max:16',
            'nama_instansi' => 'required',
            'jabatan'       => 'required',
            'no_kontak'     => 'required',
            'password'      => 'required|min:6',
        ]);

        $userId = session('google_user_id');            // id baris A
        if (!$userId) abort(403, 'Session expired');

        DB::table('pengguna')
            ->where('id_pengguna', $userId)
            ->update([
                'nik'           => $request->nik,
                'nama_instansi' => $request->nama_instansi,
                'jabatan'       => $request->jabatan,
                'no_kontak'     => $request->no_kontak,
                'password'      => Hash::make($request->password),
                'auth_type'     => 'google_manual',
                'updated_at'    => now(),
            ]);

        // kirim OTP ke baris yang sama
        return app(OtpController::class)->sendOtp($userId);
    }
}

