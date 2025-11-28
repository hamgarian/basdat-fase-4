<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Penerbangan extends Model
{
    use HasFactory;

    protected $table = 'penerbangan';
    protected $primaryKey = 'id_penerbangan';
    
    public $timestamps = false;

    protected $fillable = [
        'id_pesawat',
        'tanggal_penerbangan',
        'jenis_penerbangan',
        'status_penerbangan',
        'catatan',
    ];

    protected $casts = [
        'tanggal_penerbangan' => 'date',
    ];

    public function pesawat(): BelongsTo
    {
        return $this->belongsTo(Pesawat::class, 'id_pesawat');
    }

    public function incidents(): HasMany
    {
        return $this->hasMany(Incident::class, 'id_penerbangan');
    }

    public function flightMovements(): HasMany
    {
        return $this->hasMany(FlightMovement::class, 'id_penerbangan');
    }
}
