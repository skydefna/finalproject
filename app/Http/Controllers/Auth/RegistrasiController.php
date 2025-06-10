<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegistrasiController
{
    public function daftar()
    {
        return view('auth.registrasi');
    }
     public function submit(Request $request)
    {
        $request->validate([
            'nama_pengguna' => 'required|string|max:100',
            'no_kontak' => 'required|string|max:15',
            'username' => 'required|string|unique:pengguna,username',
            'password' => 'required|string|min:6',
        ], [
            'nama_pengguna.required' => 'Nama lengkap wajib diisi',
            'nama_pengguna.max' => 'Nama lengkap maksimal 100 huruf',
            'no_kontak.required' => 'Nomor Kontak wajib diisi',
            'no_kontak.max' => 'Nomor Kontak maksimal 15 angka',
            'username.required' => 'Username wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);

        $user = User::create([
            'role_id' => 2,
            'nama_pengguna' => $request->nama_pengguna,
            'no_kontak' => $request->no_kontak,
            'username' => $request->username,
            'email' => null,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        return redirect('/');
    }
}
