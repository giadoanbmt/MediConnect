<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    use HasFactory;

    protected $table = 'DoctorSchedule';
    protected $primaryKey = 'ScheduleId';

    // Khai báo tên cột Timestamps viết hoa theo Database
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';

    protected $fillable = [
        'DoctorId',
        'WorkDate',
        'StartTime',
        'EndTime',
        'MaxPatients',
        'Status',
        'IsBooked',
        'Note',
    ];

    protected $casts = [
        'WorkDate'    => 'date',
        'IsBooked'    => 'boolean',
        'MaxPatients' => 'integer',
    ];

    /**
     * Mối quan hệ với Model Doctor
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'DoctorId', 'DoctorId');
    }
}
