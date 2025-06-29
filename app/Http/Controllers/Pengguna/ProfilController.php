<?php
namespace App\Http\Controllers\Pengguna;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProfilController
{
    public function profil()
    {
        $user = Auth::user(); // ambil pengguna yang sedang login
        $adminUsers = User::where('role_id', '01')->get();

        return view('content.01.profil-pengguna', compact('user', 'adminUsers'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'no_kontak'      => 'required|max:20',
            'nik'            => 'required|max:16',
            'nama_instansi'  => 'required|max:100',
            'jabatan'        => 'required|max:100',
        ]);

        DB::table('pengguna')->where('id_pengguna', Auth::id())->update([
            'no_kontak'     => $request->no_kontak,
            'nik'           => $request->nik,
            'nama_instansi' => $request->nama_instansi,
            'jabatan'       => $request->jabatan,
            'updated_at'    => now(),
        ]);

        return back()->with('success', 'Data berhasil diperbarui.');
    }
}