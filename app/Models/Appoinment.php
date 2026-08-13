<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'Appointment';
    protected $primaryKey = 'AppointmentId';

    public $timestamps = true;
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';

    protected $fillable = [
        'UserId',
        'DoctorId',
        'RoomId',
        'AppointmentDate',
        'StartTime',
        'EndTime',
        'Status',
        'Reason',
        'CancellationReason',
    ];

    public function accountUser()
    {
        return $this->belongsTo(AccountUser::class, 'UserId', 'UserId');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'DoctorId', 'DoctorId');
    }

    public function room()
    {
        return $this->belongsTo(ClinicRoom::class, 'RoomId', 'RoomId');
    }
}
