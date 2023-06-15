<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitRecord extends Model
{
    protected $table = 'visitrecord';

    protected $fillable = [
        'id',
        'staffID',
        'contVisitID',
        'appointmentPurpose',
        'appointmentAgenda',
        'passNo',
        'checkInDate',
        'checkInTime',
        'checkOutDate',
        'checkOutTime',
    ];
}
