<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentHistory extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'payment_history';
    protected $fillable = [
        'id',
        'code_no',
        'cash',
        'quantity',
        'order_id',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];

    public function getOrderDetail(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }
}
