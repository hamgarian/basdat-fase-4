<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LibraryManual extends Model
{
    use HasFactory;

    protected $table = 'library_manual';
    protected $primaryKey = 'id_manual';
    
    public $timestamps = false;

    protected $fillable = [
        'id_karyawan',
        'judul_manual',
        'tanggal_terbit',
        'departemen_pemilik',
        'status',
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
    ];

    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }
}
