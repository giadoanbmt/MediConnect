<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $table = 'City';
    protected $primaryKey = 'CityId';

    public $timestamps = false;

    protected $fillable = [
        'CityName',
        'DistrictName',
    ];

    public function doctors()
    {
        return $this->hasMany(Doctor::class, 'CityId', 'CityId');
    }
}
