<?php

namespace App\Models;

use App\Models\DataAduan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StatusAduan extends Model
{
    use HasFactory;

    protected $table = 'status_aduan';
    protected $primaryKey = 'id_status'; // default 'id', bisa dihilangkan jika pakai default
    public $timestamps = false; // biasanya tabel status tidak perlu timestamps

    protected $fillable = [
        'nama_status_aduan',
    ];

    // Relasi ke DataAduan
    public function aduan()
    {
        return $this->hasMany(DataAduan::class, 'status_id');
    }
}