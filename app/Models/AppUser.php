<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AppUser extends Model
{
    use HasFactory;

    protected $table = 'user';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'username',
        'password',
    ];

    public function karyawan(): HasOne
    {
        return $this->hasOne(Karyawan::class, 'id_user', 'id_user');
    }
}
