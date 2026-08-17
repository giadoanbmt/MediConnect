<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\DoctorSchedule;

class Doctor extends Authenticatable
{
    protected $table = 'Doctor';

    protected $primaryKey = 'DoctorId';

    public $timestamps = false;

    protected $fillable = [
        'FullName',
        'Username',
        'Password',
        'Gender',
        'PhoneNumber',
        'Email',
        'SpecializationId',
        'Qualifications',
        'CityId',
        'Address',
        'AvatarUrl',
        'RoomId',
    ];

    protected $hidden = [
        'Password',
    ];

    public function city()
    {
        return $this->belongsTo(
            \App\Models\City::class,
            'CityId',
            'CityId'
        );
    }

    public function specialization()
    {
        return $this->belongsTo(
            \App\Models\Specialization::class,
            'SpecializationId',
            'SpecializationId'
        );
    }

    public function clinicRoom()
    {
        return $this->belongsTo(
            \App\Models\ClinicRoom::class,
            'RoomId',
            'RoomId'
        );
    }

    public function appointments()
    {
        return $this->hasMany(
            \App\Models\Appointment::class,
            'DoctorId',
            'DoctorId'
        );
    }

    public function schedules()
    {
        return $this->hasMany(
            DoctorSchedule::class,
            'DoctorId',
            'DoctorId'
        );
    }

    public function getAuthPassword()
    {
        return $this->Password;
    }
}