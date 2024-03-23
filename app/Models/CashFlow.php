<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashFlow extends Model
{
     use HasFactory;
    protected $table = 'cash_flow';
    protected $fillable = [
        'id',
        'shift_id',
        '50',
        '100',
        '200',
        '500',
        '1000',
        '5000',
        '10000',
        '20000',
        'updated_at',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];
}
