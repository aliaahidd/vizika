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
        'employeeNo',
        'companyName',
        'occupation',
        'phoneNo',
        'birthDate',
        'address',
        'passportPhoto',
    ];
}