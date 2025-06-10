<?php

namespace App\Http\Controllers\Akun;

use App\Models\Kecamatan;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AkunController extends Controller
{
    public function akun()
    {
        $pengguna = User::with('role')->get();
        $roles = Role::all();
        $kecamatan = DB::table('kecamatan')->get(); // ← ini penting

        $jumlah_per_role = [];
        foreach ($roles as $role) {
            $jumlah_per_role[$role->nama] = $pengguna->where('role_id', $role->id)->count();
        }

        return view('content.05.data_akun', compact('pengguna', 'roles', 'jumlah_per_role', 'kecamatan'));
    }
    public function submit(Request $request)
    {
        $role = Role::find($request->role_id);

        $rules = [
            'nama_pengguna' => 'required|string|max:100',
            'username' => 'required|string|min:5|max:20|unique:pengguna,username',
            'no_kontak' => 'nullable|string|max:15',
            'role_id' => 'required|exists:roles,id',
            'password' => 'required|min:6',
        ];

        if ($role && strtolower($role->nama) === 'admin') {
            $rules['kecamatan_id'] = 'required|integer|exists:kecamatan,id_kecamatan';
        } else {
            $rules['kecamatan_id'] = 'nullable|integer|exists:kecamatan,id_kecamatan';
        }

        $request->validate($rules, [
            'nama_pengguna.required' => 'Nama pengguna wajib dipilih.',
            'username.required' => 'Username wajib diisi.',
            'no_kontak.max' => 'Nomor Kontak maksimal 15 huruf.',
            'role_id.required' => 'Role wajib dipilih.',
            'kecamatan_id.required' => 'Kecamatan wajib dipilih (khusus untuk Role Admin).',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 huruf.',
        ]);

        User::create([
            'role_id' => $request->role_id,
            'nama_pengguna' => $request->nama_pengguna,
            'no_kontak' => $request->no_kontak,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'kecamatan_id' => $request->kecamatan_id ?? null,
        ]);

        return redirect()->route('akun.data_akun')->with('Berhasil', 'Akun pengguna berhasil tersimpan');
    }
    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'nama_pengguna' => 'required|string|max:100',
            'username' => 'required|string|max:100|unique:pengguna,username,' . $id . ',id_pengguna',
            'no_kontak' => 'nullable|string|max:15',
            'role_id' => 'required|exists:roles,id',
            'kecamatan_id' => 'nullable|integer|exists:kecamatan,id_kecamatan',
        ];

        $validatedData = $request->validate($rules);

        $user->update([
            'role_id' => $validatedData['role_id'],
            'nama_pengguna' => $validatedData['nama_pengguna'],
            'username' => $validatedData['username'],
            'no_kontak' => $validatedData['no_kontak'] ?? null,
            'kecamatan_id' => $validatedData['kecamatan_id'] ?? null,
            'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
            'auth_type' => $user->auth_type, // <- ini ditambahkan agar tidak berubah
        ]);

        return redirect()->route('akun.data_akun')->with('success', 'Akun berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $isDelete = User::destroy($id);
        if ($isDelete) {
            return redirect()->route('akun.data_akun')->with('success', 'Data berhasil dihapus.');
        } else {
            return redirect()->route('akun.data_akun')->with('error', 'Data gagal dihapus.');
        }
    }
}