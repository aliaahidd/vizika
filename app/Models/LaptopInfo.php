<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaptopInfo extends Model
{
    protected $table = 'laptopinfo';

    protected $fillable = [
        'id',
        'appointmentID',
        'laptopBrand',
        'laptopModel',
        'laptopColor',
        'laptopSerialNo',
    ];
}
