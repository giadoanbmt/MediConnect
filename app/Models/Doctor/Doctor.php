<?php

namespace App\Models\Doctor;

use App\Models\City;
use App\Models\ClinicRoom;
use App\Models\Specialization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Doctor extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'Doctor';
    protected $primaryKey = 'DoctorId';

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
        'PhoneNumber',
        'Qualifications',
        'Address',
        'AvatarUrl',
        'CityId',
        'SpecializationId',
        'RoomId',
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
            'CreatedAt' => 'datetime',
            'UpdatedAt' => 'datetime',
            'DeletedAt' => 'datetime',
        ];
    }

    // Chỉ định cột Password cho Auth
    public function getAuthPassword()
    {
        return $this->Password;
    }

    public function getRememberTokenName()
    {
        return null;
    }

    // --- Các Mối quan hệ (Relationships) ---

    public function city()
    {
        return $this->belongsTo(City::class, 'CityId', 'CityId');
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class, 'SpecializationId', 'SpecializationId');
    }

    public function room()
    {
        return $this->belongsTo(ClinicRoom::class, 'RoomId', 'RoomId');
    }
}
