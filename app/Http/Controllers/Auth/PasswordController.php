<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
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
            'nik' => 'required|string|max:25',
            'nama_instansi' => 'required|string|max:100',
            'jabatan' => 'required|string|max:100',
            'no_kontak' => 'required|string|max:20',
            'password' => 'required|string|min:6',
        ],[
            'nik.required' => 'NIK wajib diisi',
            'nik.max' => 'NIK maksimal 16 angka',
            'nama_instansi.required' => 'Nama Instansi wajib diisi',
            'jabatan.required' => 'Jabatan wajib diisi',
            'no_kontak.required' => 'Nomor Kontak wajib diisi',
            'password.required' => 'Kata sandi wajib diisi',
        ]);

        $user = Auth::user();

        // Assign manual (ini pasti aman meskipun update() tidak tersedia)
        $user->nik = $request->nik;
        $user->nama_instansi = $request->nama_instansi;
        $user->jabatan = $request->jabatan;
        $user->no_kontak = $request->no_kontak;
        $user->password = Hash::make($request->password);
        $user->auth_type = 'google_manual';

        $user->save(); // simpan ke database

        return redirect()->route('beranda')->with('success', 'Data berhasil disimpan.');
    }
}

