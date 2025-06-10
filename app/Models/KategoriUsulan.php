<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriUsulan extends Model
{
    use HasFactory;
    protected $table = 'kategori_usulan';

    protected $primaryKey = 'id_kategori';

    protected $fillable = ['nama_kategori'];

    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class, 'kategori_id');
    }
}
