<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentInfo extends Model
{
    protected $table = 'appointmentinfo';

    protected $fillable = [
        'id',
        'staffID',
        'visitorID',
        'appointmentName',
        'appointmentDate',
        'appointmentTime',
        'appointmentPurpose',
    ];
}
