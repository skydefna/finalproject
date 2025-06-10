<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles'; // Nama tabel (optional jika sama)

    protected $primaryKey = 'id';

    protected $fillable = ['nama']; // Kolom yang bisa diisi (mass assignment)

    // Relasi jika diperlukan, misalnya satu role bisa dimiliki banyak pengguna

    public function pengguna()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }
}
