<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Investigation extends Model
{
    use HasFactory;

    protected $table = 'investigation';
    protected $primaryKey = 'id_investigasi';
    
    public $timestamps = false;

    protected $fillable = [
        'id_hazard',
        'tanggal_mulai',
        'tanggal_selesai',
        'teknologi',
        'hasil_wawancara',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function hazardReport(): BelongsTo
    {
        return $this->belongsTo(HazardReport::class, 'id_hazard');
    }
}
