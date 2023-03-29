<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BriefingSession extends Model
{
    protected $table = 'briefingsession';

    protected $fillable = [
        'id',
        'briefingID',
        'contractorID',
        'totalParticipant',
    ];
}
