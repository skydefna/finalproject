<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DesaKelurahan extends Model
{
    use HasFactory;
    protected $table = 'desa_kelurahan';

    protected $primaryKey = 'id';

    protected $fillable = ['kecamatan_id', 'nama_desa_kelurahan'];

    public function kecamatan()
    {
        return $this->hasMany(Kecamatan::class, 'kecamatan_id');
    }
    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class, 'desa_kelurahan_id');
    }
}