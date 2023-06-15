<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlacklistVisitor extends Model
{
    protected $table = 'blacklistvisitor';

    protected $fillable = [
        'id',
        'userID',
        'blacklistReason',
    ];
}
