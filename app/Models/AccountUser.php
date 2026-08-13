<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AccountUser extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'AccountUser';
    protected $primaryKey = 'UserId';

    public $timestamps = true;
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

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

    public function getAuthPassword()
    {
        return $this->Password;
    }

    public function getRememberTokenName()
    {
        return null;
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'UserId', 'UserId');
    }

    public function news()
    {
        return $this->hasMany(News::class, 'UserId', 'UserId');
    }

    protected static function newFactory(): Factory
    {
        return \Database\Factories\AccountUserFactory::new();
    }
}
