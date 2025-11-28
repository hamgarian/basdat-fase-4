<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class HazardReport extends Model
{
    use HasFactory;

    protected $table = 'hazard_report';

    protected $primaryKey = 'id_hazard';
    
    public $timestamps = false;

    protected $fillable = [
        'id_karyawan',
        'nama_pelapor',
        'tanggal_laporan',
        'kategori',
        'deskripsi',
        'status',
    ];

    protected $casts = [
        'tanggal_laporan' => 'date',
        'id_karyawan' => 'integer',
    ];

    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }

    public function investigation(): HasOne
    {
        return $this->hasOne(Investigation::class, 'id_hazard');
    }
}
