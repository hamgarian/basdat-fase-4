<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Helicopter extends Model
{
    use HasFactory;

    protected $table = 'helicopter';
    protected $primaryKey = 'id_pesawat';

    public $incrementing = false;
    protected $keyType = 'integer';
    
    public $timestamps = false;

    protected $fillable = [
        'id_pesawat',
        'tipe_mesin',
    ];

    public function pesawat(): BelongsTo
    {
        return $this->belongsTo(Pesawat::class, 'id_pesawat');
    }
}
