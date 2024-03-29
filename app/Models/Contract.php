<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table = 'contract';

    protected $fillable = [ 
        'id',
        'contractName',
        'contractStartDate',
        'contractendDate',
        'companyID',
        'contractorID',
        'staffID',
        'contractAmount',
    ];
}
