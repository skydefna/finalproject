<?php

namespace App\Models;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kecamatan extends Model
{
    use HasFactory;
    protected $table = 'kecamatan';

    protected $primaryKey = 'id_kecamatan';

    protected $fillable = ['nama_kecamatan'];

    public function desaKelurahan()
    {
        return $this->hasMany(DesaKelurahan::class, 'kecamatan_id');
    }
    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class, 'kecamatan_id');
    }
    public function pengguna()
    {
        return $this->hasMany(User::class, 'kecamatan_id', 'id_kecamatan');
    }
}