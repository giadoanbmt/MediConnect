<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    protected $table = 'DoctorSchedule';

    protected $primaryKey = 'ScheduleId';

    public $timestamps = false;

    protected $fillable = [
        'DoctorId',
        'WorkDate',
        'StartTime',
        'EndTime',
        'MaxPatients',
        'Status',
        'Note',
        'CreatedAt',
        'UpdatedAt',
    ];

    protected $casts = [
        'WorkDate' => 'date',
    ];

    public function doctor()
    {
        return $this->belongsTo(
            Doctor::class,
            'DoctorId',
            'DoctorId'
        );
    }
}