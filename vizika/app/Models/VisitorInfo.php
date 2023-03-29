<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorInfo extends Model
{
    protected $table = 'visitorinfo';

    protected $fillable = [
        'id',
        'userID',
        'employeeID',
        'company',
        'occupation',
        'phoneNo',
    ];
}
