<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Temuan extends Model
{
    use HasFactory;

    protected $table = 'temuan';
    protected $primaryKey = 'id_temuan';
    
    public $timestamps = false;

    protected $fillable = [
        'id_audit',
        'deskripsi_temuan',
        'rekomendasi',
        'status_tindak_lanjut',
    ];

    public function audit(): BelongsTo
    {
        return $this->belongsTo(Audit::class, 'id_audit');
    }
}
