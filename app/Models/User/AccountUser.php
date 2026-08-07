<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AccountUser extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'AccountUser';

    protected $primaryKey = 'UserId';

    public $timestamps = false;

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'Username',
        'Password',
        'Email',
        'Role',
        'IsActive',
        'CreatedAt',
    ];

    protected $hidden = [
        'Password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'Password' => 'hashed',
            'Role' => 'integer',
            'IsActive' => 'boolean',
        ];
    }

    protected static function newFactory(): Factory
    {
        return \Database\Factories\AccountUserFactory::new();
    }

    public function getNameAttribute(): ?string
    {
        return $this->attributes['Username'] ?? null;
    }

    public function setNameAttribute(string $value): void
    {
        $this->attributes['Username'] = $value;
    }
}
