<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class AccountUser extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'AccountUser';

    protected $primaryKey = 'UserId';

    public $timestamps = true;
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'FullName',
        'Username',
        'Email',
        'Password',
        'Gender',
        'Address',
        'AvatarUrl',
        'Role',
        'IsActive',
        'CreatedAt',
        'UpdatedAt',
        'DeletedAt',
    ];

    protected $hidden = [
        'Password',
    ];

    protected function casts(): array
    {
        return [
            'Role' => 'integer',
            'IsActive' => 'boolean',
            'CreatedAt' => 'datetime',
            'UpdatedAt' => 'datetime',
            'DeletedAt' => 'datetime',
        ];
    }

    // Chỉ định cột Password cho Laravel Auth
    public function getAuthPassword()
    {
        return $this->Password;
    }

    // Tắt tính năng remember_token do CSDL không có cột này
    public function getRememberTokenName()
    {
        return null;
    }

    protected static function newFactory(): Factory
    {
        return \Database\Factories\AccountUserFactory::new();
    }
}
