<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use HasFactory;
    protected $table = 'order_detail';
    protected $fillable = [
        'id',
        'quantity',
        'original_amount',
        'discount_amount',
        'sub_total',
        'order_id',
        'item_id',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];

   // Category model
    public function getItems(): HasMany
    {
        return $this->hasMany(Item::class, 'id', 'item_id');
    }
    
    public function getOrder(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'order_id', 'id');
    }
}
