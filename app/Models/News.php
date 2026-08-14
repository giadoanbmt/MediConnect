<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'News';
    protected $primaryKey = 'NewsId';

    public $timestamps = true;
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

    protected $fillable = [
        'Title',
        'Category',
        'Content',
        'ThumbnailUrl',
        'AuthorType',
        'UserId',
        'DoctorId',
        'PublishedAt',
        'IsPublished',
    ];

    protected function casts(): array
    {
        return [
            'IsPublished' => 'boolean',
            'PublishedAt' => 'datetime',
        ];
    }

    public function adminAuthor()
    {
        return $this->belongsTo(AccountUser::class, 'UserId', 'UserId');
    }

    public function doctorAuthor()
    {
        return $this->belongsTo(Doctor::class, 'DoctorId', 'DoctorId');
    }
}
