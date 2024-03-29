<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Shift extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'shift';
    protected $fillable = [
        'id',
        'start_date_time',
        'end_date_time',
        'refund',
        'created_by',
        'updated_by'
    ];
}
