<?php

namespace App\Exports;

use Illuminate\Support\Facades\Auth; // jika pakai Auth juga di dalam export
use App\Models\Pengajuan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PengajuanExport implements FromCollection, WithHeadings
{
    protected $status;
    protected $kecamatanId;

    public function __construct($status = null, $kecamatanId = null)
    {
        $this->status = $status;
        $this->kecamatanId = $kecamatanId;
    }

    public function collection()
    {
        $query = Pengajuan::with(['kecamatan', 'desakelurahan', 'kategori', 'status']);

        if ($this->status) {
            $query->whereHas('status', function ($q) {
                $q->where('nama_status', $this->status);
            });
        }

        if ($this->kecamatanId) {
            $query->where('kecamatan_id', $this->kecamatanId);
        }

        return $query->get()->map(function ($item) {
            return [
                'Nama PIC' => $item->nama_pic_lokasi,
                'Pengusul' => $item->pengusul,
                'Lokasi' => $item->lokasi->pluck('nama_lokasi')->join(', '),
                'Latitude' => $item->lokasi->pluck('latitude')->join(', '),
                'Longitude' => $item->lokasi->pluck('longitude')->join(', '),
                'Kecamatan' => $item->kecamatan->nama_kecamatan,
                'Desa/Kelurahan' => $item->desakelurahan->nama_desa_kelurahan,
                'Alamat Aktual' => $item->alamat_aktual,
                'Kategori' => $item->kategori->nama_kategori,
                'Kontak PIC' => $item->kontak_pic_lokasi,
                'Status' => optional($item->status->last())->nama_status,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama PIC',
            'Pengusul',
            'Lokasi',
            'Latitude',
            'Longitude',
            'Kecamatan',
            'Desa/Kelurahan',
            'Alamat Aktual',
            'Kategori',
            'Kontak PIC',
            'Status',
        ];
    }
}
