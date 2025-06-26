<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataSurvei extends Model
{
    use HasFactory;

    protected $table = 'data_survei'; // pastikan nama tabel sesuai
    protected $primaryKey = 'id_survei'; // jika primary key bukan 'id'
    public $timestamps = true; // jika tabel punya created_at & updated_at

    protected $fillable = [
        'pengajuan_id',
        'lokasi_id',
        'status_id',
        'nama_surveyor',
        'deskripsi',
        'tanggal_survei',        
        'foto',        
    ];
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id', 'id_lokasi');
    }
    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'pengajuan_id', 'id_pengajuan');
    }
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id_status');
    }
}
