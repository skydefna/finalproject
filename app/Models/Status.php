<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $table = 'status'; // Nama tabel (optional jika sama)
    
    protected $primaryKey = 'id_status';

    protected $fillable = ['nama_status']; // Kolom yang bisa diisi (mass assignment)

    public function pengajuan()
    {
        return $this->belongsToMany(Pengajuan::class, 'pengajuan_status', 'status_id', 'pengajuan_id', 'id_status', 'id_pengajuan');
    }
}
