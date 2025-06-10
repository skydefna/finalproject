<?php

namespace App\Models;

use App\Models\Pengajuan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lokasi extends Model
{
    use HasFactory;

    protected $table = 'lokasi';

    protected $primaryKey = 'id_lokasi';

    protected $fillable = ['nama_lokasi', 'longitude', 'latitude'];

    public function pengajuan()
    {
        return $this->belongsToMany(Pengajuan::class, 'pengajuan_lokasi', 'lokasi_id', 'pengajuan_id', 'id_lokasi', 'id_pengajuan');
    }
    public function pemasangan()
    {
        return $this->belongsToMany(Pemasangan::class, 'pemasangan_lokasi', 'lokasi_id', 'pemasangan_id', 'id_lokasi', 'id_pemasangan');
    }
}