<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $table = 'client';
    protected $primaryKey = 'id_client';
    
    public $timestamps = false;

    protected $fillable = [
        'nama_perusahaan',
        'contact_person',
        'nomor_telepon',
        'alamat',
    ];

    public function pesawat(): HasMany
    {
        return $this->hasMany(Pesawat::class, 'id_client');
    }
}
