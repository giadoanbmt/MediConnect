<?php

namespace App\Models\Doctor;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Specialization\Specialization;
use App\Models\City\City;

class Doctor extends Authenticatable
{
    protected $table = 'Doctor';
    protected $primaryKey = 'DoctorId';

    // 2. CSDL MediConnectDb có 2 cột CreatedAt & UpdatedAt
    public $timestamps = true;
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';

    // 3. Đã sửa lại tên cột khớp 100% với Database MediConnectDb
    protected $fillable = [
        'FullName',        // DB dùng FullName (thay cho DoctorName)
        'Username',        // DB dùng Username (thay cho DoctorAccount)
        'Email',
        'Password',
        'Gender',          // DB dùng Gender (thay cho Sex)
        'PhoneNumber',
        'Qualifications',
        'RoomId',          // Đã bổ sung RoomId
        'CityId',
        'Address',
        'SpecializationId',
        'AvatarUrl',       // Đã bổ sung AvatarUrl
    ];

    protected $hidden = [
        'Password',
    ];

    // Khai báo cột Password viết hoa cho Auth Laravel
    public function getAuthPassword()
    {
        return $this->Password;
    }

    // Khai báo mối liên hệ khóa ngoại
    public function specialization()
    {
        return $this->belongsTo(Specialization::class, 'SpecializationId', 'SpecializationId');
    }
    public function city()
    {
    return $this->belongsTo(City::class, 'CityId', 'CityId');
    }
}