<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pilot extends Model
{
    use HasFactory;

    protected $table = 'pilot';
    protected $primaryKey = 'id_pilot';
    
    public $timestamps = false;

    protected $fillable = [
        'id_karyawan',
        'lisensi_pilot',
        'jam_terbang_total',
        'rating_pesawat',
        'status',
    ];

    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }

    public function flightMovements(): HasMany
    {
        return $this->hasMany(FlightMovement::class, 'id_pilot');
    }
}
