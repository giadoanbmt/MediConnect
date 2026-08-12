<?php 

namespace App\Models\Specialization;

use Illuminate\Database\Eloquent\Model;
use App\Models\Doctor\Doctor; 

class Specialization extends Model
{
    protected $table = 'Specialization';

    
    protected $primaryKey = 'SpecializationId';

    public $timestamps = false;

    protected $fillable = [
        'SpecializationName',
        'Description',
    ];

    
    //  Mối quan hệ
    
    public function doctors()
    {
        return $this->hasMany(Doctor::class, 'SpecializationId', 'SpecializationId');
    }
}