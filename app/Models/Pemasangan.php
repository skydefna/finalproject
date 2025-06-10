<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pemasangan extends Model
{
    use HasFactory;

    protected $table = 'pemasangan';

    protected $primaryKey = 'id_pemasangan';

    protected $fillable = ['pengajuan_id', 'ip_assigment', 'tipe_koneksi', 'tipe_alat', 'tanggal_pemasangan', 'dokumentasi_pemasangan'];

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'pengajuan_id');
    }
    public function lokasi() {
        return $this->belongsToMany(Lokasi::class, 'pemasangan_lokasi', 'pemasangan_id', 'lokasi_id');
    }
    public function provider() {
        return $this->belongsToMany(Provider::class, 'pemasangan_provider', 'pemasangan_id', 'provider_id');
    }
}
