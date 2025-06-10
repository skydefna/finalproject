<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
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

        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'role_id' => 2,
                'nama_pengguna' => $googleUser->getName(),
                'username' => $googleUser->getEmail(),
                'email' => $googleUser->getEmail(),
                'no_kontak' => null,
                'password' => null,
                'auth_type' => 'google',
            ]);
        }

        if (!$googleUser->getEmail()) {
            return redirect()->route('login')->with('error', 'Gagal mendapatkan email dari akun Google.');
        }

        Auth::login($user);

        // Redirect ke buat password jika auth_type google dan belum punya password
        if ($user->password === null) {
            return redirect()->route('password.create');
        }

        return redirect()->route('beranda');
    }
}