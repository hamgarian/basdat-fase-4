<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Incident extends Model
{
    use HasFactory;

    protected $table = 'incident';
    protected $primaryKey = 'id_incident';
    
    public $timestamps = false;

    protected $fillable = [
        'id_penerbangan',
        'kategori_insiden',
        'lokasi_insiden',
        'status',
    ];

    public function penerbangan(): BelongsTo
    {
        return $this->belongsTo(Penerbangan::class, 'id_penerbangan');
    }
}
