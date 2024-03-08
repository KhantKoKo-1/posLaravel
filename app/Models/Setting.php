<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'setting';
    protected $fillable = [
        'id',
        'company_name',
        'company_phone',
        'company_email',
        'company_address',
        'image',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];
}
