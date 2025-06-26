<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController 
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback(Request $request)
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'role_id' => 2,
                'nama_pengguna' => $googleUser->getName(),
                'username' => $googleUser->getEmail(),
                'email' => $googleUser->getEmail(),
                'no_kontak' => $request->input('no_kontak'),
                'nik' => $request->input('nik'),
                'nama_instansi' => $request->input('nama_instansi'),
                'jabatan' => $request->input('jabatan'),
                'password' => null,
                'auth_type' => 'google',
            ]);
        }

        if (!$googleUser->getEmail()) {
            return redirect()->route('login')->with('error', 'Gagal mendapatkan email dari akun Google.');
        }

        Auth::login($user);

        if ($user->password === null) {
            return redirect()->route('password.create');
        }

        return redirect()->route('beranda');
    }
}