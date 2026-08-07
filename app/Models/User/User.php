<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'AccountUser';

    protected $primaryKey = 'UserId';

    public $incrementing = true;

    protected $keyType = 'int';

    public const CREATED_AT = 'CreatedAt';

    public const UPDATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'role' => 'integer',
            'is_active' => 'boolean',
            'CreatedAt' => 'datetime',
        ];
    }

    public function getNameAttribute(): ?string
    {
        return $this->attributes['username'] ?? null;
    }

    public function setNameAttribute(string $value): void
    {
        $this->attributes['username'] = $value;
    }

    public function setUsernameAttribute(string $value): void
    {
        $this->attributes['username'] = trim($value);
    }
}
