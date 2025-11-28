<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FlightMovement extends Model
{
    use HasFactory;

    protected $table = 'flight_movement';
    protected $primaryKey = 'id_flight_movement';
    
    public $timestamps = false;

    protected $fillable = [
        'id_penerbangan',
        'id_pilot',
        'tanggal_penerbangan',
        'rute',
        'jam_terbang',
    ];

    protected $casts = [
        'tanggal_penerbangan' => 'date',
    ];

    public function penerbangan(): BelongsTo
    {
        return $this->belongsTo(Penerbangan::class, 'id_penerbangan');
    }

    public function pilot(): BelongsTo
    {
        return $this->belongsTo(Pilot::class, 'id_pilot');
    }
}
