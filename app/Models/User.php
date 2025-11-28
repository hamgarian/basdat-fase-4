<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Disable remember token functionality since the table doesn't have remember_token column.
     */
    public function getRememberToken()
    {
        return null;
    }

    public function setRememberToken($value)
    {
        // Do nothing - remember token not supported
    }

    public function getRememberTokenName()
    {
        return null;
    }

    protected $table = 'user';
    protected $primaryKey = 'id_user';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // Password is already hashed in database, don't cast it
        ];
    }

    /**
     * Set the password attribute (store as plain text, no hashing).
     */
    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = $value;
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'id_user';
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the karyawan associated with this user.
     */
    public function karyawan(): HasOne
    {
        return $this->hasOne(Karyawan::class, 'id_user', 'id_user');
    }

    /**
     * Get the user's name from karyawan or fallback to username.
     */
    public function getNameAttribute(): string
    {
        return $this->karyawan?->nama_karyawan ?? $this->username;
    }

    /**
     * Get the user's email (using username as email for compatibility).
     */
    public function getEmailAttribute(): string
    {
        return $this->username;
    }
}
