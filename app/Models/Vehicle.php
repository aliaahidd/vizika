<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = 'vehicle';

    protected $fillable = [ 
        'id',
        'vehicleRegNo',
        'vehicleType',
        'vehicleCC',
        'vehicleColour',
        'vehicleWeight',
        'companyID',
    ];
}
