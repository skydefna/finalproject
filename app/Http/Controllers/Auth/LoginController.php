<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class LoginController
{
    public function index()
    {
        return view('auth.login');
    }
    public function authenticate(Request $request)
    {
        $messages = [
            'login.required' => 'Username atau email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'g-recaptcha-response.required' => 'Silakan verifikasi bahwa Anda bukan robot.',
            'g-recaptcha-response.captcha' => 'Verifikasi CAPTCHA gagal, coba lagi.',
        ];

        $credentials = $request->validate([
            'login' => 'required',
            'password' => 'required|min:6',
            'g-recaptcha-response' => 'required',
        ], $messages);

        // Verifikasi CAPTCHA manual ke Google
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        if (!$response->json('success')) {
            return back()->withErrors(['g-recaptcha-response' => 'Verifikasi CAPTCHA gagal.'])->withInput();
        }

        // Cek apakah input login adalah email atau username
        $fieldType = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $pengguna = User::where($fieldType, $credentials['login'])->first();

        if (!$pengguna) {
            return back()->withErrors(['login' => ucfirst($fieldType) . ' tidak ditemukan.'])->withInput();
        }

        if (!Hash::check($credentials['password'], $pengguna->password)) {
            return back()->withErrors(['password' => 'Password salah.'])->withInput();
        }

        if (Auth::attempt([$fieldType => $credentials['login'], 'password' => $credentials['password']])) {
        // Hapus semua sesi lain user ini (single session login)
        DB::table('sessions')->where('user_id', $pengguna->id)->delete();
        // Regenerasi session baru untuk user yang baru login
        $request->session()->regenerate();

        $roles = Auth::user();

        switch ($roles->role->nama) {
            case 'admin':
                return redirect()->intended('/utama');
            case 'tamu':
                return redirect()->intended('/beranda');
            case 'teknisi':
                return redirect()->intended('/home');
            case 'pimpinan':
                return redirect()->intended('/dashboard');
            case 'super admin':
                return redirect()->intended('/menu/tabel');
            default:
                Auth::logout();
                return back()->with('loginError', 'Role tidak dikenali.');
        }
    }

        return back()->with('loginError', 'Akun anda tidak terdaftar');
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate(); // Hapus data sesi
        $request->session()->regenerateToken(); // Buat ulang CSRF token untuk mencegah serangan
        $request->session()->flush();

        return redirect('/'); // Atau redirect ke halaman lain yang Anda inginkan
    }
}