<?php

namespace App\Http\Controllers\Teknisi;

use App\Models\Lokasi;
use App\Models\DataAduan;
use App\Models\Pengajuan;
use App\Models\StatusAduan;
use Illuminate\Http\Request;

class DataAduanController
{
    public function aduan()
    {
        return view('content.04.data_lapor', [
            'aduan' => DataAduan::all(),
            'statusaduan' => StatusAduan::all(),
            'lokasi' => Lokasi::all(),
            'pengajuan' => Pengajuan::all(),
        ]);
    }
    public function updateStatus(Request $request, $id)
    {
        $aduan = DataAduan::findOrFail($id);
        $aduan->status_id = $request->status_id;
        $aduan->save();

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }
}
