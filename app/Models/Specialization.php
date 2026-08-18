<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    use HasFactory;

    protected $table = 'Specialization';
    protected $primaryKey = 'SpecializationId';

    // Bảng Specialization không sử dụng timestamps (CreatedAt, UpdatedAt)
    public $timestamps = false;

    protected $fillable = [
        'SpecializationName',
        'Description',
        'ImageUrl',           // Đã bổ sung cột ảnh minh họa
        'Content',            // Đã bổ sung cột nội dung chi tiết[cite: 4]
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
