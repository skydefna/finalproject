<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller

{
    public function showLinkRequestForm()
    {
        return view('auth.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => 'Kami telah mengirimkan link reset password ke email Anda.'])
            : back()->withErrors(['email' => 'Kami tidak dapat mengirim link reset. Silakan cek kembali email Anda.']);
    }
}