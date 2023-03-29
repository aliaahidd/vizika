<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitRecord extends Model
{
    protected $table = 'visitrecord';

    protected $fillable = [
        'id',
        'userID',
        'checkInDate',
        'checkInTime',
        'checkOutDate',
        'checkOutTime',
    ];
}
