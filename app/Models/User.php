<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *        
     * @var list<string>
     */
    protected $table = 'pengguna';

    protected $primaryKey = 'id_pengguna';

    protected $fillable = ['role_id', 'kecamatan_id','nama_pengguna', 'no_kontak','username', 'email','password'];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'pengguna_id');
    }
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id', 'id_kecamatan');
    }
    public function scopeAdmin($query)
    {
        return $query->where('role', 'admin');
    }
}
