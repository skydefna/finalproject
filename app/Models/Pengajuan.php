<?php

namespace App\Models;

use App\Models\Lokasi;
use App\Models\Kecamatan;
use App\Models\DesaKelurahan;
use App\Models\KategoriUsulan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengajuan extends Model
{
    use HasFactory;

    protected $table = 'pengajuan';

    protected $primaryKey = 'id_pengajuan';

    protected $fillable = ['pengguna_id', 'role_id', 'kecamatan_id', 'desa_kelurahan_id', 'kategori_id', 'nama_pic_lokasi', 'pengusul', 'alamat_aktual', 'kontak_pic_lokasi', 'tanggal_usul','status_on'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($pengajuan) {
            // 1. Hapus relasi di tabel pivot
            foreach ($pengajuan->lokasi as $lokasi) {
                $pengajuan->lokasi()->detach($lokasi->id_lokasi);

                // 2. Jika lokasi tidak punya pengajuan lain, hapus lokasi
                if ($lokasi->pengajuan()->count() === 0) {
                    $lokasi->delete();
                }
            }

            // Jika kamu juga punya relasi status, detach juga kalau perlu
            $pengajuan->status()->detach();
        });
    }

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id', 'id_kecamatan');
    }
    public function desakelurahan()
    {
        return $this->belongsTo(DesaKelurahan::class, 'desa_kelurahan_id', 'id_desa_kelurahan');
    }
    public function kategori()
    {
        return $this->belongsTo(KategoriUsulan::class, 'kategori_id', 'id_kategori');
    }
    public function lokasi() {
        return $this->belongsToMany(Lokasi::class, 'pengajuan_lokasi', 'pengajuan_id', 'lokasi_id', 'id_pengajuan', 'id_lokasi');
    }
    public function status() {
        return $this->belongsToMany(Status::class, 'pengajuan_status', 'pengajuan_id', 'status_id')
                    ->withPivot('is_active', 'created_at', 'updated_at')
                    ->withTimestamps()
                    ->wherePivot('is_active', true); // hanya ambil status aktif;
    }
    public function pemasangan(){
        return $this->belongsTo(Pemasangan::class,'pengajuan_id');
    }
}
