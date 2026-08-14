<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    use HasFactory;

    protected $table = 'DoctorSchedule';
    protected $primaryKey = 'ScheduleId';

    public $timestamps = true;
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';

    protected $fillable = [
        'DoctorId',
        'WorkDate',
        'StartTime',
        'EndTime',
        'MaxPatients',
        'Status',
        'Note',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'DoctorId', 'DoctorId');
    }
}
