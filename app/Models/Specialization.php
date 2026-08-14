<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    use HasFactory;

    protected $table = 'Specialization';
    protected $primaryKey = 'SpecializationId';

    public $timestamps = false;

    protected $fillable = [
        'SpecializationName',
        'Description',
    ];

    public function doctors()
    {
        return $this->hasMany(Doctor::class, 'SpecializationId', 'SpecializationId');
    }

    public function clinicRooms()
    {
        return $this->hasMany(ClinicRoom::class, 'SpecializationId', 'SpecializationId');
    }
}
