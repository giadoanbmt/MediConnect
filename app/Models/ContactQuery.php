<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactQuery extends Model
{
    use HasFactory;

    protected $table = 'ContactQuery';
    protected $primaryKey = 'QueryId';

    public $timestamps = false;

    protected $fillable = [
        'SenderName',
        'Email',
        'PhoneNumber',
        'Subject',
        'MessageText',
        'Status',
        'AdminNotes',
        'RespondedBy',
        'SubmittedAt',
        'RespondedAt',
    ];

    protected function casts(): array
    {
        return [
            'SubmittedAt' => 'datetime',
            'RespondedAt' => 'datetime',
        ];
    }

    public function respondedByAdmin()
    {
        return $this->belongsTo(AccountUser::class, 'RespondedBy', 'UserId');
    }
}
