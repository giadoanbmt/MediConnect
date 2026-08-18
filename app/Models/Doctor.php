<?php

namespace App\Models;

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

    public function getAuthPassword()
    {
        return $this->Password;
    }

    public function getRememberTokenName()
    {
        return null;
    }

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

    public function clinicRoom()
    {
        return $this->room();
    }

    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class, 'DoctorId', 'DoctorId');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'DoctorId', 'DoctorId');
    }
}
