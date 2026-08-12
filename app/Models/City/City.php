<?php

namespace App\Models\City;

use Illuminate\Database\Eloquent\Model;
use App\Models\Doctor\Doctor;

class City extends Model
{
    protected $table = 'City';
    protected $primaryKey = 'CityId';
    public $timestamps = false;
    protected $fillable = ['CityName'];

    public function doctors()
    {
        return $this->hasMany(Doctor::class, 'CityId', 'CityId');
    }
}