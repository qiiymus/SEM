<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DutyRoster extends Model
{
    use HasFactory;

    protected $table = "DutyRosters";
    protected $fillable = [
        'user_id',
        'user_name',
        'week',
        'date',
        'status',
        'start_time',
        'end_time',
        'created_date',
        'updated_date',
    ];
}
