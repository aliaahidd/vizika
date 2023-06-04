<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiometricInfo extends Model
{
    protected $table = 'biometricinfo';

    protected $fillable = [ 
        'id',
        'userID',
        'facialRecognition',
    ];
}
