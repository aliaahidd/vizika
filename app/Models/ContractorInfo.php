<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractorInfo extends Model
{
    protected $table = 'contractorinfo';

    protected $fillable = [
        'id',
        'userID',
        'companyName',
        'phoneNo',
        'passExpiryDate',
        'birthDate',
        'address',
        'validityPassPhoto',
    ];
}