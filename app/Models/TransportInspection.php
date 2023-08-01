<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportInspection extends Model
{
    protected $table = 'transportinspection';

    protected $fillable = [ 
        'id',
        'companyID',
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
