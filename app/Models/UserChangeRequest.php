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
        'visitDate',
        'vehicleRegNo',
        'primeMoverInside',
        'primeMoverBack',
        'trailerUnder',
        'trailerBehind',
        'trailerLeft',
        'trailerRight',
        'security',
    ];
}
