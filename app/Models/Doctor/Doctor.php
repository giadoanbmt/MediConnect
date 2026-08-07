<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
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
}
