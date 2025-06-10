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
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->auth_type = 'google_manual';
        $user->save();

        return redirect()->route('beranda')->with('success', 'Password berhasil disimpan.');
    }
}

