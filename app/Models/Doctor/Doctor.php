<?php

namespace App\Models\Doctor;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Doctor extends Authenticatable
{
    protected $table = 'Doctor';
    protected $primaryKey = 'DoctorId';
    public $timestamps = false;

    protected $fillable = [
        'DoctorName',
        'DoctorAccount',
        'Password',
        'Sex',
        'PhoneNumber',
        'Email',
        'SpecializationId',
        'Qualifications',
        'CityId',
        'Address',
    ];

    protected $hidden = [
        'Password',
    ];

    public function getAuthPassword()
    {
        return $this->Password;
    }
}
