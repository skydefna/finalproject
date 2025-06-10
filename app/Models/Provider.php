<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Provider extends Model
{
    
    use HasFactory;

    protected $table = 'provider';

    protected $primaryKey = 'id_provider';

    protected $fillable = ['nama_provider'];

    public function pemasangan()
    {
        return $this->belongsToMany(Pemasangan::class, 'pemasangan_provider', 'provider_id', 'pemasangan_id', 'id_provider', 'id_pemasangan');
    }

}
