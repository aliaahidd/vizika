<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    protected $table = 'transport';

    protected $fillable = [ 
        'id',
        'companyID',
        'vehicleRegNo',
        'contractorID',
        'noIC',
        'plant',
        'passNo',
        'checkInDate',
        'checkInTime',
        'checkOutDate',
        'checkOutTime',
    ];
}
