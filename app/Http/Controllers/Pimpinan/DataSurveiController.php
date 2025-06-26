<?php

namespace App\Http\Controllers\Pimpinan;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataSurveiController
{
    public function updateStatus(Request $request, $pengajuanId)
    {
        $request->validate([
            'status_id' => 'required|exists:status,id_status',
        ]);

        $pengajuan = Pengajuan::findOrFail($pengajuanId);

        // Pastikan nama kolom sesuai di tabel pivot
        DB::table('pengajuan_status')
            ->where('pengajuan_id', $pengajuanId)
            ->delete();

        $pengajuan->status()->attach($request->status_id, [
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Status berhasil diperbarui');
    }
}
