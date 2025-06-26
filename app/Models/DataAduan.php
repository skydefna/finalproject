<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataAduan extends Model
{
    use HasFactory;

    protected $table = 'data_aduan'; // pastikan nama tabel sesuai
    protected $primaryKey = 'id_aduan'; // jika primary key bukan 'id'
    public $timestamps = true; // jika tabel punya created_at & updated_at

    protected $fillable = [
        'pengajuan_id',
        'lokasi_id',
        'pengguna_id',
        'status_id',
        'deskripsi',
        'foto',        
    ];

    // Relasi ke Status
    public function statusaduan()
    {
        return $this->belongsTo(StatusAduan::class, 'status_id');
    }
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id', 'id_lokasi');
    }
    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'pengajuan_id', 'id_pengajuan');
    }
}
