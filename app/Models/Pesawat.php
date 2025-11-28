<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pesawat extends Model
{
    use HasFactory;

    protected $table = 'pesawat';
    protected $primaryKey = 'id_pesawat';
    
    public $timestamps = false;

    protected $fillable = [
        'id_client',
        'registrasi',
        'merk_model',
        'tahun_pembuatan',
        'jam_terbang',
        'status',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'id_client');
    }

    public function penerbangan(): HasMany
    {
        return $this->hasMany(Penerbangan::class, 'id_pesawat');
    }

    public function helicopter(): HasOne
    {
        return $this->hasOne(Helicopter::class, 'id_pesawat');
    }

    public function privateJet(): HasOne
    {
        return $this->hasOne(PrivateJet::class, 'id_pesawat');
    }
}
