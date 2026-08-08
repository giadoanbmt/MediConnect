<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class AccountUser extends Authenticatable
{
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
            'Role' => 'integer',
            'IsActive' => 'boolean',
        ];
    }

    public function getAuthPassword()
    {
        return $this->Password;
    }

    protected static function newFactory(): Factory
    {
        return \Database\Factories\AccountUserFactory::new();
    }
}
