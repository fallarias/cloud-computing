<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    protected $fillable = [
        'id_number',
        'time_in',
        'time_out'
    ];

    protected $table = 'staff_entry';
}
