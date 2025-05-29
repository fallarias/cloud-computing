<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = [
        'id_number',
        'first',
        'last',
        'middle',
        'department',
        'soft_del',
    ];
}
