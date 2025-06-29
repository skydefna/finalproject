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
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        if (!$googleUser->getEmail()) {
            return redirect()->route('login')->with('error','Gagal mendapatkan email!');
        }

        // cari atau buat baris user (tabel = pengguna)
        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],                 // kunci unik
            [
                'role_id'       => 2,
                'nama_pengguna' => $googleUser->getName(),
                'username'      => $googleUser->getEmail(),
                'auth_type'     => 'google',
            ]
        );

        Auth::login($user);
        // simpan id di session supaya form berikutnya tahu baris mana yang harus di‑update
        session(['google_user_id' => $user->id_pengguna]);

        // kalau belum punya password ⇒ suruh lengkapi data
        if ($user->password === null) {
            return redirect()->route('password.create');
        }

        return redirect()->route('beranda');
    }
}