<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class OtpController
{
    public function verifyOtpForm($id_pengguna)
    {
        $pengguna = DB::table('pengguna')->where('id_pengguna', $id_pengguna)->first();
        if (!$pengguna) abort(404);

        $otp = DB::table('otps')->where('phone', $pengguna->no_kontak)->first();

        return view('auth.verify-otp', [
            'otps'      => $otp,
            'pengguna'  => $pengguna,
        ]);
    }
    public function sendOtp($id_pengguna)
    {
        $pengguna = DB::table('pengguna')->where('id_pengguna', $id_pengguna)->first();
        if (!$pengguna) {
            return back()->with('error', 'User tidak ditemukan');
        }

        // generate & simpan OTP
        $otp = rand(100000, 999999);
        DB::table('otps')->updateOrInsert(
            ['phone' => $pengguna->no_kontak],
            [
                'otp'        => $otp,
                'expired_at' => now()->addMinutes(5),
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        // kirim via Fonnte
        try {
            $token = config('services.fonnte.token');
            $response = Http::withHeaders([
                'Authorization' => $token
            ])->asForm()->post('https://api.fonnte.com/send', [
                'target'  => preg_replace('/^0/', '62', $pengguna->no_kontak),
                'message' => "Kode OTP Anda adalah *$otp*. Berlaku 5 menit."
            ]);

            $json = $response->json();
            if (!$json['status']) {
                return redirect()
                    ->route('verify-otp.form', $id_pengguna)   // ✅ redirect ke GET
                    ->with('warning', 'OTP tersimpan, tapi gagal dikirim WA. Hubungi admin.');
            }
        } catch (\Throwable $e) {
            return redirect()
                ->route('verify-otp.form', $id_pengguna)       // ✅ redirect ke GET
                ->with('warning', 'OTP tersimpan, namun terjadi error pengiriman.');
        }

        // sukses
        return redirect()
            ->route('verify-otp.form', $id_pengguna)           // ✅ redirect ke GET
            ->with('success', 'Kode OTP dikirim ke WhatsApp Anda.');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'otp'   => 'required|digits:6',
        ]);

        $row = DB::table('otps')
                ->where('phone', $request->phone)
                ->first();

        if (!$row || $row->otp != $request->otp) {
            return back()->withErrors(['otp' => 'Kode OTP salah'])->withInput();
        }

        if (now()->greaterThan($row->expired_at)) {
            return back()->withErrors(['otp' => 'Kode OTP sudah kadaluarsa'])->withInput();
        }

        // ======= di sini OTP valid =======
        // Lakukan apa pun (tandai verifikasi, login, dsb.)
        return redirect()->route('beranda')->with('success', 'OTP terverifikasi!');
    }
}
