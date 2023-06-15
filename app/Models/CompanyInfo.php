<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyInfo extends Model
{
    protected $table = 'companyinfo';

    protected $fillable = [ 
        'id',
        'companyName',
        'companyEmail',
        'companyPhoneNo',
        'companyAddress',
    ];
}
