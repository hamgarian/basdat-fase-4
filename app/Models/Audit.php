<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Audit extends Model
{
    use HasFactory;

    protected $table = 'audit';
    protected $primaryKey = 'id_audit';
    
    public $timestamps = false;

    protected $fillable = [
        'id_karyawan',
        'nomor_audit',
        'judul',
        'kategori',
        'tanggal_pelaksanaan',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_pelaksanaan' => 'date',
    ];

    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }

    public function temuan(): HasMany
    {
        return $this->hasMany(Temuan::class, 'id_audit');
    }
}
