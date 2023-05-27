<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DutyRoster extends Model
{
    use HasFactory;

    protected $table = "DutyRoster";
    protected $fillable = [
        'user_id',
        'week',
        'date',
        'status',
        'start_time',
        'end_time',
        'created_date',
        'updated_date',
    ];
}
