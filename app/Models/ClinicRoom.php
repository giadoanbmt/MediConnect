<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicRoom extends Model
{
    use HasFactory;

    protected $table = 'ClinicRoom';
    protected $primaryKey = 'RoomId';

    public $timestamps = false;

    protected $fillable = [
        'RoomName',
        'RoomNumber',
        'SpecializationId',
        'LocationFloor',
        'IsActive',
    ];

    protected function casts(): array
    {
        return [
            'IsActive' => 'boolean',
        ];
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class, 'SpecializationId', 'SpecializationId');
    }

    public function doctors()
    {
        return $this->hasMany(Doctor::class, 'RoomId', 'RoomId');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'RoomId', 'RoomId');
    }
}
