<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan';

    protected $primaryKey = 'id_karyawan';
    
    public $timestamps = false;

    protected $fillable = [
        'id_karyawan',
        'id_user',
        'nama_karyawan',
        'nik',
        'tanggal_lahir',
        'alamat',
        'nomor_telepon',
    ];

    public function hazardReports(): HasMany
    {
        return $this->hasMany(HazardReport::class, 'id_karyawan', 'id_karyawan');
    }

    public function audits(): HasMany
    {
        return $this->hasMany(Audit::class, 'id_karyawan');
    }

    public function libraryManuals(): HasMany
    {
        return $this->hasMany(LibraryManual::class, 'id_karyawan');
    }

    public function pilot(): HasOne
    {
        return $this->hasOne(Pilot::class, 'id_karyawan');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(AppUser::class, 'id_user', 'id_user');
    }
}
