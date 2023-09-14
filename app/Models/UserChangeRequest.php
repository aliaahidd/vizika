<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserChangeRequest extends Model
{
    protected $table = 'userchangerequests';

    protected $fillable = [ 
        'id',
        'userID',
        'original_value',
        'field_changed',
        'new_value',
        'request_date',
        'requestStatus',
        'passStatus',
    ];
}
