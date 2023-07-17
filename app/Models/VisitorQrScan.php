<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorQrScan extends Model
{
    protected $table = 'visitorqrscan';

    protected $fillable = [
        'id',
        'name',
        'email',
        'phoneNo',
        'companyName',
        'employeeNo',
        'occupation',
        'visitPurpose',
        'passNo',
        'checkInDate',
        'checkInTime',
        'checkOutDate',
        'checkOutTime',
    ];
}